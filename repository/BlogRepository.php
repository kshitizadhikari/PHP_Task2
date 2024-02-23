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
    }