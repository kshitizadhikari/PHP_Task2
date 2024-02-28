<?php
    namespace app\repository;
    use app\repository\BaseRepository;

    class ContactRepository extends BaseRepository
    {
        public function tableName(): string
        {
            return 'contacts';
        }
        public function className(): string
        {
            return 'Contact';
        }
    }