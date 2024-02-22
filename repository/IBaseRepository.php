<?php
    namespace app\repository;

    abstract class IBaseRepository
    {
        

        protected function getObjectData($obj)
        {
            return get_object_vars($obj);
        }

        abstract public function save($obj);
        abstract public function findById($id);
        abstract public function findAll();
        abstract public function update($obj);
        abstract public function delete($id);

    }
?>