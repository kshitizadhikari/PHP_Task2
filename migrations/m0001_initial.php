<?php
    use app\core\Application;

    class m0001_initial
    {
        public function up()
        {
            $db = Application::$app->db;

            $sql = "
                    CREATE TABLE roles (
                        id INT PRIMARY KEY AUTO_INCREMENT,
                        role VARCHAR(50)
                    );
                ";
            $db->pdo->exec($sql);

            $sql = "
                    INSERT INTO roles (role) VALUES 
                    ('admin'), ('editor'), ('author'), ('user');
                ";
            $db->pdo->exec($sql);
            
            $sql = "
                    CREATE TABLE users (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        firstName VARCHAR(50) NOT NULL,
                        lastName VARCHAR(50) NOT NULL,
                        email VARCHAR(100) NOT NULL,
                        password VARCHAR(100) NOT NULL,
                        role_id INT DEFAULT 4,
                        status TINYINT NOT NULL,
                        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                        FOREIGN KEY (role_id) REFERENCES roles(id)
                    ) ENGINE=INNODB;
                ";
            $db->pdo->exec($sql);
            
            //password = password123
            $usersData = [
                ['admin', 'admin', 'admin@example.com', '$2y$10$sHS7.wxho/SIAp.aYZ24Au.uXOOHwNiwlz98j9tUDefh/.CuNxH6q', 1, 1], // Admin
                ['editor', 'editor', 'user@example.com', '$2y$10$sHS7.wxho/SIAp.aYZ24Au.uXOOHwNiwlz98j9tUDefh/.CuNxH6q', 2, 1], // Editor
                ['author', 'author', 'author@example.com', '$2y$10$sHS7.wxho/SIAp.aYZ24Au.uXOOHwNiwlz98j9tUDefh/.CuNxH6q', 3, 1], // Author
                ['user', 'user', 'user@example.com', '$2y$10$sHS7.wxho/SIAp.aYZ24Au.uXOOHwNiwlz98j9tUDefh/.CuNxH6q', 4, 1], // User
            ];
            
            foreach ($usersData as $userData) {
                $sqlInsertUser = "
                    INSERT INTO users (firstName, lastName, email, password, role_id, status)
                    VALUES (?, ?, ?, ?, ?, ?);
                ";
            
                $stmt = $db->pdo->prepare($sqlInsertUser);
                $stmt->execute($userData);
            }

            $sql = "
                CREATE TABLE blogs (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    title VARCHAR(100) NOT NULL,
                    description TEXT NOT NULL,
                    featured_img VARCHAR(255),
                    user_id INT,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    status TINYINT NOT NULL,
                    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
                ) ENGINE=INNODB;
            ";

            $db->pdo->exec($sql);


            $sql = "
                CREATE TABLE contacts (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    email VARCHAR(50) NOT NULL,
                    subject VARCHAR(100) NOT NULL,
                    body TEXT NOT NULL,
                    status TINYINT NOT NULL
                ) ENGINE=INNODB;
            ";

            $db->pdo->exec($sql);

            $sql = "
                CREATE TABLE images (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    img_name VARCHAR(100) NOT NULL,
                    img_ext VARCHAR(10) NOT NULL,
                    relative_path VARCHAR(255) NOT NULL,
                    absolute_path VARCHAR(255) NOT NULL,
                    size INT NOT NULL,
                    status TINYINT NOT NULL DEFAULT 1,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=INNODB;
            ";

            $db->pdo->exec($sql);

        }

        public function down()
        {
            $db = Application::$app->db;

            $SQL = "DROP TABLE blogs;";
            $db->pdo->exec($SQL);

            $SQL = "DROP TABLE users;";
            $db->pdo->exec($SQL);

            $SQL = "DROP TABLE roles;";
            $db->pdo->exec($SQL);

            $SQL = "DROP TABLE contacts;";
            $db->pdo->exec($SQL);

            $SQL = "DROP TABLE images";
            $db->pdo->exec($SQL);
        }
    }