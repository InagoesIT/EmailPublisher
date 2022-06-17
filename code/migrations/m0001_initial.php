<?php

use app\core\App;

class m0001_initial
{
	public function up()
	{
		$SQL = "CREATE TABLE users (
    		id INT AUTO_INCREMENT PRIMARY KEY,
    		email VARCHAR(255) NOT NULL UNIQUE,
    		token VARCHAR(10),
    		isActive BOOLEAN NOT NULL,
    		createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    		expireAt DATE
		) ENGINE=INNODB;";
		App::$app->db->pdo->exec($SQL);

		$SQL = "CREATE TABLE publications (
            id INT AUTO_INCREMENT PRIMARY KEY,
            idUser INT,
            isPublic BOOLEAN,
            password VARCHAR(255),
            body MEDIUMTEXT,
            subject VARCHAR(2000),
            createdAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            expireAt DATE
        ) ENGINE=INNODB;";
		App::$app->db->pdo->exec($SQL);
	}

	public function down()
	{
		App::$app->db->pdo->exec("DROP TABLE IF EXISTS users");
		App::$app->db->pdo->exec("DROP TABLE IF EXISTS publications");
	}
}
