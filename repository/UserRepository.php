<?php
    namespace app\repository;
    use app\repository\BaseRepository;
    use app\repository\ObjectMapper;

    class UserRepository extends BaseRepository
    {
        public function findByUserName($username) {
            $sql = "SELECT * FROM $this->tableName WHERE username=?";
            $result = $this->db->query($sql, [$username]);
            if (!empty($result)) {
                $row = $result[0];
                $user = ObjectMapper::mapToObject($row, 'User');
                return $user;
            } else {
                return null;
            }
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
    }