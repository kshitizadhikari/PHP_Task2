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
    }