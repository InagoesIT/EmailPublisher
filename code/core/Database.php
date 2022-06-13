<?php

namespace app\core;

use PDO;

class Database
{
	public PDO $pdo;

	public function __construct(array $config)
	{
		$dsn = $config['dsn'] ?? '';
		$user = $config['user'] ?? '';
		$password = $config['password '] ?? '';
		$this->pdo = new PDO($dsn, $user, $password);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	public function applyMigrations()
	{
		$this->createMigrationsTable();
		$appliedMigrations = $this->getAppliedMigrations();
		$files = scandir('migrations');
		$newMigrations = [];

		$toApplyMigrations = array_diff($files, $appliedMigrations);
		foreach ($toApplyMigrations as $migration)
		{
			if ($migration === '.' || $migration === '..')
				continue;

			require_once 'migrations/' . $migration;
			$className = pathinfo($migration, PATHINFO_FILENAME);
			$instance = new $className();
			$this->log("Applying migration $migration");
			$instance->up();
			$this->log("Applied migration $migration");
			$newMigrations[] = $migration;
		}

		if (!empty($newMigrations))
		{
			$this->saveMigrations($newMigrations);
		}
		else
		{
			 $this->log("All migrations are applied" . PHP_EOL);
		}
	}

	private function createMigrationsTable()
	{
		$this->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
    		id INT AUTO_INCREMENT PRIMARY KEY,
    		migration VARCHAR(255),
    		created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
    		ENGINE=INNODB;");
	}

	private function getAppliedMigrations()
	{
		$statement = $this->pdo->prepare("SELECT migration FROM migrations");
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_COLUMN);
	}

	private function saveMigrations(array $migrations)
	{
		$strValues = implode(",", array_map(fn($migration) => "('$migration')", $migrations));
		$statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES $strValues");
		$statement->execute();
	}

	public function deleteMigrations(array $migrations)
	{
		foreach ($migrations as $migration)
		{
			$instance = new $migration();
			$this->deleteMigrationFromDb($migration);
			$this->log("Deleting migration $migration");
			$instance->down();
			$this->log("Deleted migration $migration");
		}
		$this->log("All given migrations were deleted" . PHP_EOL);
	}

	protected function log($message)
	{
		echo '[' . date('d-m-Y H:i:s') . '] - ' . $message . PHP_EOL;
	}

	private function deleteMigrationFromDb($migration)
	{
		$statement = $this->pdo->prepare("DELETE FROM migrations WHERE migration = '" . $migration . "';");
		$statement->execute();
	}
}