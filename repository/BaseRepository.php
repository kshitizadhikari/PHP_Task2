<?php
    namespace app\repository;

use app\core\Application;
use app\core\db\Database;

    abstract class BaseRepository extends IBaseRepository
    {
        protected Database $db;
        protected $tableName;
        protected $className;

        public function __construct($className)
        {
            $this->db = Application::$app->db;
            $this->className = $className;
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

    }
?>