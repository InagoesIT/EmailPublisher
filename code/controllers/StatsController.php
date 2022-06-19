<?php

namespace app\controllers;

use app\core\App;
use app\models\Stats;
use Cassandra\Date;
use Cassandra\Time;

class StatsController extends Controller
{
    public static  $startDate;
    public static  $endDate;
    public static int  $nrViews=0;


    public function print(){
        return $this::render('stats');
    }
    public static function printDate(){
        echo self::$startDate;
        echo self::$endDate;
    }

    public function setData(){


    }
    public static function filterArrayByDates($value): bool
    {
        if($value >= self::$startDate & $value <= self::$endDate){
            return true;
        }
        return false;
    }
    public function stats(){
        if( isset($_POST['endDate']) & isset($_POST['startDate'])){
            echo "acum setez ";
            self::$startDate=$_POST['startDate'];
            self::$endDate=$_POST['endDate'];
            $session = App::$app->session;
            $session->set("startDate", $_POST['startDate']);
            $session->set("endDate", $_POST['endDate']);
        }else{
            self::$nrViews=0;
        }
        $myArray=array();

        $myArray=Stats::findByIdPublication(1);

        echo "time o " . $myArray[0] . "<br>";
        echo "time 1 " . $myArray[1] ."<br>";

//        for($i=0; $i<count($myArray); $i++){
//            echo "- " . $myArray[$i];
//            $myArray[$i]=date('y-m-d',$myArray[$i]);
//            echo "+ " . $myArray[$i];
//        }
//        $filteredArray=array_filter($myArray, function ($value){
//            if($value >= self::$startDate & $value <= self::$endDate){
//                return true;
//            }
//            return false;
//        });
        $session = App::$app->session;
        echo "start = ". $session->get("startDate");
        for($i=0; $i<count($myArray); $i++){
            preg_replace('T', " ", $myArray[$i]);
            if($myArray[$i] >= $session->get("startDate") && $myArray[$i] <= $session->get("endDate") ){
                self::$nrViews++;
            }
        }

        echo  "nr de elemente filtrate ". self::$nrViews;



        return $this::render('stats');
    }

}