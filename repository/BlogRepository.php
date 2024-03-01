<?php
    namespace app\repository;
    use app\repository\BaseRepository;
use PDO;

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

        // public function searchBlogs($title, $newBlogStart, $limit) {
        //     $sql = "SELECT * FROM $this->tableName WHERE title LIKE :title LIMIT :offset, :limitt";
        //     $statement = $this->db->prepare($sql);
        //     $statement->bindValue(":title", '%' . $title . '%');
        //     $statement->bindValue(":offset", $newBlogStart, PDO::PARAM_INT);
        //     $statement->bindValue(":limitt", $limit, PDO::PARAM_INT);
        //     $statement->execute();
        //     $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        //     return $result;
        // }
        
    }