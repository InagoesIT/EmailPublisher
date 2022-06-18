<?php

namespace app\models;

use app\core\DbModel;

class Stats extends DbModel
{
    public int $id;
    public int $idPublication;
    public String $country;
    public $viewTime;

    public function __construct()
    {
    }
    public static function getCountById(){

    }
    static public function tableName(): string
    {
        return 'stats';
    }

    static public function attributes(): array
    {
        return ['id', 'idPublication', 'country' , 'viewTime'];
    }

    static public function primaryKey(): string
    {
       return 'id';
    }

    public function rules(): array
    {
        return [];
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