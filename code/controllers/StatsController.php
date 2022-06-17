<?php

namespace app\controllers;

use app\models\Stats;
use Cassandra\Date;
use Cassandra\Time;

class StatsController extends Controller
{
    public static  $startDate;
    public static  $endDate;


    public function print(){
        return $this::render('stats');
    }
    public static function printDate(){
        echo self::$startDate;
        echo self::$endDate;
    }

    public  function operatiune(){
        self::printDate();

        Stats::findOne([ "id" => 1 ]);

        return $this::render('stats');
    }
}