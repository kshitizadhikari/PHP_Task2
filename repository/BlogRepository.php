<?php
    namespace app\repository;
    use app\repository\BaseRepository;

    class BlogRepository extends BaseRepository
    {
        public function tableName(): string
        {
            return 'blogs';
        }

        public function className(): string
        {
            return 'Blog';
        }

        public function searchBlogs($title) {
            $sql = "SELECT * FROM $this->tableName WHERE title LIKE ?";
            $result = $this->db->query($sql, [$title]);
            return $result;
        }
    }