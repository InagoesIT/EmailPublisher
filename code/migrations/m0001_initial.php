<?php

use app\core\App;

class m0001_initial
{
	public function up()
	{
		$SQL = "CREATE TABLE users (
    		id INT AUTO_INCREMENT PRIMARY KEY,
    		email VARCHAR(255) NOT NULL,
    		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
		) ENGINE=INNODB;";
		App::$app->db->pdo->exec($SQL);
	}

	public function down()
	{
		$SQL = "DELETE FROM migrations WHERE migration = __FILE__;";
		App::$app->db->pdo->exec($SQL);
	}
}
