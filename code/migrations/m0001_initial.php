<?php

use app\core\App;

class m0001_initial
{
    public function up()
    {
        $SQL = "CREATE TABLE users (
    		id INT AUTO_INCREMENT PRIMARY KEY,
    		email VARCHAR(255) NOT NULL,
    		token VARCHAR(10) NOT NULL,
    		is_active BOOLEAN,
    		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    		expire_at DATE,
		) ENGINE=INNODB;";
        App::$app->db->pdo->exec($SQL);

        $SQL1 = "CREATE TABLE publications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_user INT,
            is_public BOOLEAN,
            password VARCHAR(255),
            bodyPath VARCHAR(255),
            subject VARCHAR(2000),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            expire_at DATE
        ) ENGINE=INNODB;";
        App::$app->db->pdo->exec($SQL1);
    }

    public function down()
    {
        $SQL = "DROP TABLE IF EXISTS users";
        $SQL1 = "DROP TABLE IF EXISTS publications";
        App::$app->db->pdo->exec($SQL);
        App::$app->db->pdo->exec($SQL1);
    }
}
