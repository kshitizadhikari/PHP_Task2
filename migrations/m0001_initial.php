<?php
    use app\core\Application;

    class m0001_initial
    {
        public function up()
        {
            $db = Application::$app->db;

            $sql = "
                    CREATE TABLE roles (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        role VARCHAR(50)
                    );
                ";
            $db->pdo->exec($sql);

            $sql = "
                    INSERT INTO roles (role) VALUES 
                    ('admin'), ('author'), ('editor'), ('user');
                ";
            $db->pdo->exec($sql);
            
            $sql = "
                    CREATE TABLE users (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        firstName VARCHAR(255) NOT NULL,
                        lastName VARCHAR(255) NOT NULL,
                        email VARCHAR(255) NOT NULL,
                        password VARCHAR(255) NOT NULL,
                        role_id INT DEFAULT 4,
                        status TINYINT NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (role_id) REFERENCES roles(id)
                    ) ENGINE=INNODB;
                ";
            $db->pdo->exec($sql);
        }


        public function down()
        {
            $db = Application::$app->db;
            $SQL = "DROP TABLE roles;";
            $db->pdo->exec($SQL);

            $SQL = "DROP TABLE users;";
            $db->pdo->exec($SQL);
        }
    }