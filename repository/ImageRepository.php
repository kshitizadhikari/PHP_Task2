<?php
    namespace app\repository;
    use app\repository\BaseRepository;

    class ImageRepository extends BaseRepository
    {
        public function tableName(): string
        {
            return 'images';
        }

        public function className(): string
        {
            return 'Image';
        }

        public function findByImageName($imageName) {
            $sql = "SELECT * FROM $this->tableName WHERE img_name=?";
            $result = $this->db->query($sql, [$imageName]);
            if (!empty($result)) {
                $row = $result[0];
                $user = ObjectMapper::mapToObject($row, 'User');
                return $user;
            } else {
                return null;
            }
        }
    }