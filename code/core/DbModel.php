<?php

namespace app\core;

use Exception;

abstract class DbModel extends Model
{
	abstract static public function tableName() : string;

	abstract static public function attributes() : array;

	abstract static public function primaryKey() : string;

	public function save() : bool
	{
		if (!$this->isValid())
			return false;

		$tableName = $this->tableName();
		$attributes = $this->attributes();

		$params = array_map(fn($attr) => ":$attr", $attributes);
		try
		{
			$statement = self::prepare("INSERT INTO $tableName (" .
				implode(',', $attributes) . ") 
			VALUES(" . implode(',', $params) . ")");

			//the binding doesnt work ok?? it is not inserted (the execute generates errors)!!!
			foreach ($attributes as $attribute)
				$statement->bindValue(":$attribute", $this->{$attribute});

			//this works
			//$statement = self::prepare("INSERT INTO users (email,isActive,token) VALUES('ina@j.com',true,
			//'12dd12dd');");

			$statement->execute();
			return true;
		}
		catch (Exception $exception)
		{
			return false;
		}
	}

	public static function findOne($where)
	{
		$tableName = static::tableName();
		$attributes = array_keys($where);
		$sql = implode("AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
		$statement = self::prepare("SELECT * FROM $tableName WHERE $sql");

		foreach ($where as $key => $item)
			$statement->bindValue(":$key", $item);
		$statement->execute();

		return $statement->fetchObject(static::class);
	}

	public static function prepare($sql)
	{
		return App::$app->db->pdo->prepare($sql);
	}
}