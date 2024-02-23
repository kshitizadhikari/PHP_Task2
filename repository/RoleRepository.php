<?php
    namespace app\repository;
    use app\repository\BaseRepository;

    class RoleRepository extends BaseRepository
    {
        public function tableName(): string
        {
            return 'roles';
        }
    }