<?php

namespace app\controllers;

use app\core\App;
use app\models\Publication;
use app\models\Stats;
use Cassandra\Date;
use Cassandra\Time;

class StatsController extends Controller
{
    public static $startDate;
    public static $endDate;
    public static int  $nrViews=0;
    public static int $startHour;
    public static int $nrDays;


    public function print(){
        return $this::render('stats');
    }
    public static function printDate(){
        echo self::$startDate;
        echo self::$endDate;
    }

    public static function filterArrayByDates($value): bool
    {
        if($value >= self::$startDate & $value <= self::$endDate){
            return true;
        }
        return false;
    }

//    public static function generateTimeStats(){
//
//        $hourArray=array();
//
//        if(  isset($_POST['endDate']) & isset($_POST['startDate'])  ){
//            $myStartDate=new \DateTime(date('Y-m-d h:i:s', strtotime(self::$startDate)));
//            $myEndDate=new \DateTime(date('Y-m-d h:i:s', strtotime(self::$endDate)));
//
//            $interval = $myEndDate->diff($myStartDate);
//            self::$nrDays = $interval->format('%a');
//            echo self::$nrDays . " zile ";
//
//            if(self::$nrDays >= 1){
//                ////TODO am cel putin 24 de ore => fac diagrama pe zile
//
//            }
//            if(self::$nrDays == 0){
//                ////TODO am cel mult 23 de ore => fac diagrama pe ore
//                /// TODO trebuie sa construiesc un array , ora -> nr de views , column diagram
//                /// merg in start date si obtin ora de la care plecam , merg in endDate si obtin ora la care ne
//                /// oprim, apoi verificam in baza de date daca avem intrare la ora respectiva , dar respectand <endTime, > startTime
//                /// si punem in array ora cu nr views, daca nu punem ora cu 0
//                ///
//
//                self::$startHour=\date('h', strtotime(self::$startDate));
//                $endHour=\date('H', strtotime(self::$endDate));
//               // echo "ora de start =" . self::$startHour . " ora de final  " . $endHour;
//
//
//
//                for($i=self::$startHour ; $i<=$endHour; $i++){
//                    //echo " i = " . $i . "<br>";
//                    //TODO verificam in baza de date daca sunt publicatii la ora asta2
//
//                    //echo"pentru ora " . $i .  Stats::getNrViewsAtHour($i) . "views " .  "<br>";
//                    $hourArray += [ "$i" => Stats::getNrViewsAtHour($i) ];
//                    //echo "<br>". "valoare" . $hourArray[$i].  "<br>";
//                    //echo key($hourArray);
//                    //next($hourArray);
//
//
//                }
//            }
//            if(self::$nrDays >= 31){
//                ////TODO am cel putin 1 luna  => fac diagrama pe luni
//
//
//            }
//
//            return $hourArray;
//        }
//    }

    public function stats(){
        $session = App::$app->session;
        if( isset($_POST['endDate']) & isset($_POST['startDate'])){
//            echo "acum setez ";
            self::$startDate=$_POST['startDate'];
            self::$endDate=$_POST['endDate'];
            $session->set("startDate", $_POST['startDate']);
            $session->set("endDate", $_POST['endDate']);
        }else{
            self::$nrViews=0;
        }

        $myArray=array();



//        echo "time o " . $myArray[0] . "<br>";
//        echo "time 1 " . $myArray[1] ."<br>";

        $link = $_SERVER['REQUEST_URI'];
        $pub = preg_split("[/]", $link);
        $pub = $pub[2];
        $id = Publication::getPublicationProprietyByLink('id', $pub);

        $myArray=Stats::findByIdPublication($id);

        $session = App::$app->session;
//        echo "start = ". $session->get("startDate");
        for($i=0; $i<count($myArray); $i++){
            if($myArray[$i] >= date('Y-m-d H:i:s', strtotime($session->get("startDate"))) && $myArray[$i] <= date('Y-m-d H:i:s', strtotime($session->get("endDate"))) ){
                self::$nrViews++;
            }
        }

//        echo  "nr de elemente filtrate ". self::$nrViews;

        return $this::render('stats');
    }

}