<?php
namespace app\core\db;

use app\core\Application;
use PDO;
use PDOException;

class Database
{
    public PDO $pdo;

    public function __construct(array $config) {
        $dsn = $config['dsn'] ?? '';
        $user = $config['user'] ?? '';
        $password = $config['password'] ?? '';

        try {
            $this->pdo = new PDO($dsn, $user, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new \PDOException("Database connection failed: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    public function applyMigrations()
    {
        $this->createMigrationsTable();
        $appliedMigrations = $this->getAppliedMigrations();
        $newMigrations = [];
        $files = scandir(Application::$ROOT_DIR.'/migrations');

        $toApplyMigrations = array_diff($files, $appliedMigrations);            

        foreach($toApplyMigrations as $migration) {
            if($migration === '.' || $migration === '..') {
                continue;
            }

            require_once Application::$ROOT_DIR.'/migrations/'.$migration;
            $className = pathinfo($migration, PATHINFO_FILENAME);
            $instance = new $className();
            $this->log("Applying migration $migration");
            $instance->up();
            $this->log("Applied migration $migration");
            $newMigrations[] = $migration;

            if(!empty($newMigrations)) {
                $this->saveMigrations($newMigrations);
            } else {
                $this->log("All migrations have been applied");
            }
        }
    }

    public function createMigrationsTable()
    {
        try {
            $this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations(
                id INT PRIMARY KEY AUTO_INCREMENT,
                migration VARCHAR(255),
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=INNODB;");
        } catch (PDOException $e) {
            $this->log("Error creating migrations table: " . $e->getMessage());
            exit; // Exit the script if table creation fails
        }
    }

    public function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration from migrations");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }

    public function saveMigrations(array $migrations)
    {
        $values = implode(",",array_map(fn($m) => "('$m')", $migrations));
        $statement =$this->pdo->prepare("INSERT INTO migrations(migration) VALUES $values");
        $statement->execute();
    }

    protected function log($message)
    {
        echo '['.date('Y-m-d H:i:s').'] -' . $message . PHP_EOL;
    }

    public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    public function query($query, $params = []) {
        try {
            $statement = self::prepare($query);
            
            if ((strpos(strtoupper($query), 'INSERT') === 0) || (strpos(strtoupper($query), 'UPDATE') === 0) || (strpos(strtoupper($query), 'DELETE') === 0)) {
                return $statement->execute($params);
            }
            
            if(strpos(strtoupper($query), 'SELECT') === 0) {
                if ($statement->execute($params)) {
                    return $statement->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    $errorInfo = $statement->errorInfo();
                    echo "Query execution error: " . implode(", ", $errorInfo);
                    return false;
                }
            }
            
            return $statement->execute($params);
        } catch (PDOException $e) {
            echo "Query execution error: " . $e->getMessage();
            return false;
        }
    }
}
?>
