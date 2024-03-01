<?php
    namespace app\repository;

use app\core\Application;
use app\core\db\Database;
use PDO;

    abstract class BaseRepository extends IBaseRepository
    {
        protected Database $db;
        protected $tableName;
        protected $className;

        public function __construct()
        {
            $this->db = Application::$app->db;
            $this->className = static::className();
            $this->tableName = static::tableName();
        }

        public function save($obj)
        {
            $data =  $this->getObjectData($obj);
            $columns = implode(', ', array_keys($data));
            $values = implode(', ', array_fill(0, count($data), '?'));
            $sql = "INSERT INTO $this->tableName ($columns) VALUES ($values)";
            return $this->db->query($sql, array_values($data));
        }

        public function findById($id)
        {
            $sql = "SELECT * FROM $this->tableName WHERE id=?";
            $result = $this->db->query($sql, [$id]);
            if (!empty($result)) {
                $arr = $result[0];
                $object = ObjectMapper::mapToObject($arr, $this->className);
                return $object; //return object 
            } else {
                return null;
            }
        }


        public function findAll()
        {
            $sql = "SELECT * FROM $this->tableName";
            $result = $this->db->query($sql); //return associative array
            return $result;
        }

        public function findWithLimit($offset, $limit)
        {
            $sql = "SELECT * FROM $this->tableName LIMIT :offset, :limitt";
            $statement = $this->db->prepare($sql);
            $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
            $statement->bindValue(':limitt', $limit, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }

        public function findTotalPages($limit)
        {
            $sql = "SELECT * FROM $this->tableName";
            $statement = $this->db->prepare($sql);
            $statement->execute();
            $total_rows = $statement->rowCount();
            $totalPageNum = ceil($total_rows/$limit);
            return $totalPageNum;

        }


        public function update($obj)
        {
            $data = $this->getObjectData($obj);
            $setClause = '';
            $values = [];
            
            foreach ($data as $key => $value) {
                if ($key !== 'id') { 
                    $setClause .= "$key=?, ";
                    $values[] = $value;
                }
            }
            
            $setClause = rtrim($setClause, ', ');
            $sql = "UPDATE $this->tableName SET $setClause WHERE id=?";
            $values[] = $data['id'];
            
            return $this->db->query($sql, $values);
        }

        public function delete($id)
        {
            $sql = "DELETE FROM $this->tableName WHERE id=?";
            $result = $this->db->query($sql, [$id]);
            return $result;
        }

        public function searchWithPagination($columnName, $searchTerm, $offset, $limit) {
            $sql = "SELECT * FROM $this->tableName WHERE $columnName LIKE :searchTerm LIMIT :offset, :limit";
            $statement = $this->db->prepare($sql);
            $statement->bindValue(":searchTerm", '%' . $searchTerm . '%');
            $statement->bindValue(":offset", $offset, PDO::PARAM_INT);
            $statement->bindValue(":limit", $limit, PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        }
        

    }
?>