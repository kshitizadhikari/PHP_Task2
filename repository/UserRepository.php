<?php
    namespace app\repository;
    use app\repository\BaseRepository;
    use app\repository\ObjectMapper;

    class UserRepository extends BaseRepository
    {
        public function findByFirstName($firstName) {
            $sql = "SELECT * FROM $this->tableName WHERE firstName=?";
            $result = $this->db->query($sql, [$firstName]);
            if (!empty($result)) {
                $row = $result[0];
                $user = ObjectMapper::mapToObject($row, 'User');
                return $user;
            } else {
                return null;
            }
        }

        public function searchFirstName($firstName) {
            $sql = "SELECT * FROM $this->tableName WHERE firstName LIKE ?";
            $result = $this->db->query($sql, [$firstName]);
            return $result;
        }

        public function findByUserEmail($email) {
            $sql = "SELECT * FROM $this->tableName WHERE email=?";
            $result = $this->db->query($sql, [$email]);
        
            if ($result && !empty($result)) { 
                $row = $result[0];
                
                $user = ObjectMapper::mapToObject($row, 'User');
                return $user;
            } else {
                return null;
            }
        }
        
        public function tableName(): string
        {
            return 'users';
        }

        public function className(): string
        {
            return 'User';
        }

        public function hashPassword(string $password)
        {
            return(password_hash($password, PASSWORD_DEFAULT));
        }
    }