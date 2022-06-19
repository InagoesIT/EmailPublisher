<?php

namespace app\models;

use app\core\DbModel;

class Stats extends DbModel
{
    public int $id;
    public int $idPublication;
    public string $country;
    public $viewTime;
    public static int $ok=0;

    public function __construct()
    {
    }

    public static function getCountById()
    {

    }

    static public function tableName(): string
    {
        return 'stats';
    }

    static public function attributes(): array
    {
        return ['id', 'idPublication', 'country', 'viewTime'];
    }

    static public function primaryKey(): string
    {
        return 'id';
    }

    public function rules(): array
    {
        return [];
    }

    public static function findByIdPublication(int $idPublication): array
    {
        $sql = "SELECT * FROM stats where idPublication=$idPublication";
        $statement = self::prepare($sql);
        $statement->execute();
        $resultArray=array();
        if ($statement->rowCount() > 0) {
            for($index=0; $index<$statement->rowCount(); $index++)
            {
                $row=$statement->fetch();
                $resultArray[$index]=$row['viewTime'];
            }
        }
        return $resultArray;

    }
    static public function getCountries(int $idPublication): array
    {
        $query="SELECT distinct(country) FROM stats where idPublication=$idPublication";
        $statement=self::prepare($query);
        $statement->execute();

        $arrayCountries= array();
        $i=0;
        $keys=array();
        if ($statement->rowCount() > 0) {
            while($row=$statement->fetch()) {
                $key=$row['country'];
                $value=self::getCountByCountry($key);
                echo "value =" . $value . "<br>";

                $keys[$i]=$key;
                $i++;
                array_push($arrayCountries, $key, $value);


            }

        }
        //return array_unique($arrayCountries);
        return $arrayCountries;

    }
    static public function getCountByCountry($country): int
    {
        $query="SELECT * FROM stats where country='$country'";
        $statement=self::prepare($query);
        $statement->execute();

        return $statement->rowCount();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getIdPublication(): int
    {
        return $this->idPublication;
    }

    /**
     * @param int $idPublication
     */
    public function setIdPublication(int $idPublication): void
    {
        $this->idPublication = $idPublication;
    }

    /**
     * @return String
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param String $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getViewTime()
    {
        return $this->viewTime;
    }

    /**
     * @param mixed $viewTime
     */
    public function setViewTime($viewTime): void
    {
        $this->viewTime = $viewTime;
    }


}