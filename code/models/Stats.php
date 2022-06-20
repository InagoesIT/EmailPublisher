<?php

namespace app\models;

use app\controllers\StatsController;
use app\core\DbModel;
use Composer\Factory;
use DateInterval;
use React\Promise\FulfilledPromise;

class Stats extends DbModel
{
    public int $id;
    public int $idPublication;
    public string $country;
    public $viewTime;
    public static int $ok=0;
    public static int $nrDays;
    public static int $startDay;

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

//    static function getViewTimeByIdPublication( int $id){
//        $query="SELECT distinct(country) FROM stats where idPublication=$idPublication";
//        $statement=self::prepare($query);
//        $statement->execute();
//    }
    static public function getCountries(int $idPublication): array
    {
        $startDate=\date('Y-m-d H:i:s', strtotime(StatsController::$startDate));
        $endDate=\date('Y-m-d H:i:s', strtotime(StatsController::$endDate));
        $query="SELECT distinct(country), viewTime FROM stats where idPublication=$idPublication";
        $statement=self::prepare($query);
        $statement->execute();

        $arrayCountries= array();
        $i=0;
        $keys=array();
        if ($statement->rowCount() > 0) {
            while($row=$statement->fetch()) {
                $key=$row['country'];
                $value=self::getCountByCountry($key);
                $keys[$i]=$key;
                $i++;
                $time= $row['viewTime'];
                if(  $time <= $endDate && $time >= $startDate )
                {
                    array_push($arrayCountries, $key, $value);
                }

            }

        }
        return $arrayCountries;
    }

    public static function getCountByDay($day){
        $startDate=\date('Y-m-d H:i:s', strtotime(StatsController::$startDate));
        $endDate=\date('Y-m-d H:i:s', strtotime(StatsController::$endDate));
        $query="SELECT * FROM stats WHERE viewTime LIKE '%-%-$day%' and viewTime>='$startDate' and viewTime <= '$endDate'";
//        echo $query;
        $statement=self::prepare($query);
        $statement->execute();

        return $statement->rowCount();
    }
    public static function generateTimeStats(){

        $hourArray=array();
        $dayArray=array();
        $returnArray=array();

        if(  isset($_POST['endDate']) & isset($_POST['startDate'])  ){

//            echo "INTRU UNDE AM SETAT VARS ";
            $myStartDate=new \DateTime(date('Y-m-d h:i:s', strtotime(StatsController::$startDate)));
            $myEndDate=new \DateTime(date('Y-m-d h:i:s', strtotime(StatsController::$endDate)));

            $interval = $myEndDate->diff($myStartDate);
            $nrDays = $interval->format('%a');
            self::$nrDays=$nrDays;
//            echo $nrDays . " zile ";


            if($nrDays >= 1){
                ////TODO am cel putin 24 de ore => fac diagrama pe zile

                $startDay=\date('Y-m-d H:i:s', strtotime(StatsController::$startDate));

                $endDay=\date('Y-m-d H:i:s', strtotime(StatsController::$endDate));

                self::$startDay=date('d', strtotime($startDay));
                while ($startDay  != $endDay){
//                    echo "start " . $startDay;

//                    echo "my end date " . $endDay;

                    $mySearchDay=date('d', strtotime($startDay));

                    //echo "my seacrh day =" + $mySearchDay . "<br>";


                    ////trebuie sa vad in baza de date daca corespunde

                    $startDay=date('Y-m-d H:i:s', strtotime($startDay. '+1 day'));
//                    echo ' noua zi : ' .  $startDay . "<br>";
//
                    $dayArray+=[ "$mySearchDay" => self::getCountByDay($mySearchDay) ];


                    //luam data si verificam daca exista in baza de date

                    //break;
//
                }


                $returnArray=$dayArray;
            }
            if($nrDays == 0){
                ////TODO am cel mult 23 de ore => fac diagrama pe ore
                /// TODO trebuie sa construiesc un array , ora -> nr de views , column diagram
                /// merg in start date si obtin ora de la care plecam , merg in endDate si obtin ora la care ne
                /// oprim, apoi verificam in baza de date daca avem intrare la ora respectiva , dar respectand <endTime, > startTime
                /// si punem in array ora cu nr views, daca nu punem ora cu 0
                ///

                StatsController::$startHour=\date('h', strtotime(StatsController::$startDate));
                $endHour=\date('H', strtotime(StatsController::$endDate));
                // echo "ora de start =" . self::$startHour . " ora de final  " . $endHour;



                for($i=StatsController::$startHour ; $i<=$endHour; $i++){
                    //echo " i = " . $i . "<br>";
                    //TODO verificam in baza de date daca sunt publicatii la ora asta2

                    //echo"pentru ora " . $i .  Stats::getNrViewsAtHour($i) . "views " .  "<br>";
                    $hourArray += [ "$i" => self::getNrViewsAtHour($i) ];
                    //echo "<br>". "valoare" . $hourArray[$i].  "<br>";
                    //echo key($hourArray);
                    //next($hourArray);


                }
                $returnArray=$hourArray;
            }
            if($nrDays >= 31){
                ////TODO am cel putin 1 luna  => fac diagrama pe luni


            }

            return $returnArray;
        }
    }

    public static function getNrViewsAtHour( $hour ){

        $startDate=\date('Y-m-d H:i:s', strtotime(StatsController::$startDate));
        $endDate=\date('Y-m-d H:i:s', strtotime(StatsController::$endDate));
        $query="SELECT * FROM stats WHERE viewTime LIKE '%$hour:%:%' and viewTime>='$startDate' and viewTime <= '$endDate'";
//        echo $query;
        $statement=self::prepare($query);
        $statement->execute();

        return $statement->rowCount();

    }

    static public function getCountByCountry($country): int
    {
        $startDate=\date('Y-m-d H:i:s', strtotime(StatsController::$startDate));
        $endDate=\date('Y-m-d H:i:s', strtotime(StatsController::$endDate));
        $query="SELECT * FROM stats where country='$country'  and viewTime>='$startDate' and viewTime <= '$endDate'";
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