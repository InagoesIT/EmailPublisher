<?php

namespace app\core;

use app\models\Publication;
use Exception;
use PDO;

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

			foreach ($attributes as $attribute)
			{
				if ((substr($attribute, 0, 2) == "is"))
					$statement->bindParam(":$attribute", $this->{$attribute}, PDO::PARAM_INT);
				$statement->bindValue(":$attribute", $this->{$attribute});
			}

			$statement->execute();
			return true;
		}
		catch (Exception $exception)
		{
//            echo "nu vreau sa inserez si cu asta basta";
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

		$result = $statement->fetchObject(static::class);
		if (!$result)
			return null;
		return $result;
	}


    public static function count(): int
    {
        $tableName = static::tableName();
        $sql= self::prepare("SELECT * FROM $tableName");
         $sql->execute();

        return $sql->rowCount();
    }

    public static function findAll()
    {
        $tableName = static::tableName();
        $statement = self::prepare("SELECT * FROM $tableName");

        $statement->execute();

        $result[] = new Publication();
        $result = $statement->fetchAll(PDO::FETCH_CLASS);
        if (!$result)
            return null;
        return $result;
    }

    public static function getPublicationProprietyByLink($property, $link) {
        $query="SELECT $property FROM publications where link like '$link%'";
        $statement=self::prepare($query);
        $statement->execute();
        if($statement->rowCount()==1){
            $row=$statement->fetch();
            return $row[$property];
        }
        return NULL;
    }

    public static function getPublicationProprietyByUserId($property, $id)
    {
        $query="SELECT * FROM publications where idUser = $id";
        $statement=self::prepare($query);
        $statement->execute();

        $it = 0;
        while ($row=$statement->fetch()) {
            $result[$it] = $row['link'];
            $it++;
        }

        return $result;
    }

    public static function countPublicationOfUser($id): int
    {
        $sql= self::prepare("SELECT * FROM publications where idUser = $id");
        $sql->execute();

        return $sql->rowCount();
    }

    public static function updatePublication($property, $value, $link) {
        $query= "UPDATE publications SET " . $property  . "=" . "'" . $value  . "'" . " where " . "link" . "=" . "'" . $link  . "'";
//        echo $query;
        $statement=self::prepare($query);
        $statement->execute();
    }

	public static function prepare($sql)
	{
		return App::$app->db->pdo->prepare($sql);
	}
}