<?php

namespace app\controllers;

use app\core\App;
use app\core\DbModel;
use app\models\Publication;
use DateInterval;
use DateTime;


class PublishController extends Controller
{
    public static string $password;
    public static string $duration;
    public static string $visibility;

    public function print() {
        return self::render('mailAuth');
    }

    public function printChangeTags() {
        return self::render('changeTags');
    }

    public function changeTags() {
        $link = $_SERVER['REQUEST_URI'];
        $id = preg_split("[/]", $link);
        $id = $id[2];

        if( isset($_POST['password']) && $_POST['password'] != '') {
            PublishController::$password = $_POST['password'];
            DbModel::updatePublication('password', self::$password, $id);
        }
        if( isset($_POST['duration']) ) {
            $now = new DateTime();
            $duration = preg_split("/[dhm]/", $_POST['duration']);

            if (str_contains($_POST['duration'], "d") && str_contains($_POST['duration'], "h") && str_contains($_POST['duration'], "m") &&
                    strpos($_POST['duration'], "d") < strpos($_POST['duration'], "h") &&
                    strpos($_POST['duration'], "h") < strpos($_POST['duration'], "m")) {
                $modified = (clone $now)->add(new DateInterval("P{$duration[0]}DT{$duration[1]}H{$duration[2]}M"));
                DbModel::updatePublication('expireAt', $modified->format('Y-m-d H:i:s'), $id);

            } else if (str_contains($_POST['duration'], "d") && str_contains($_POST['duration'], "h") &&
                        strpos($_POST['duration'], "d") < strpos($_POST['duration'], "h")) {
                $modified = (clone $now)->add(new DateInterval("P{$duration[0]}DT{$duration[1]}H"));
                DbModel::updatePublication('expireAt', $modified->format('Y-m-d H:i:s'), $id);

            } else if (str_contains($_POST['duration'], "d") && str_contains($_POST['duration'], "m") &&
                        strpos($_POST['duration'], "d") < strpos($_POST['duration'], "m")) {
                $modified = (clone $now)->add(new DateInterval("P{$duration[0]}DT{$duration[1]}M"));
                DbModel::updatePublication('expireAt', $modified->format('Y-m-d H:i:s'), $id);

            } else if (str_contains($_POST['duration'], "h") && str_contains($_POST['duration'], "m") &&
                        strpos($_POST['duration'], "h") < strpos($_POST['duration'], "m")) {
                $modified = (clone $now)->add(new DateInterval("PT{$duration[0]}H{$duration[1]}M"));
                DbModel::updatePublication('expireAt', $modified->format('Y-m-d H:i:s'), $id);

            } else if (str_contains($_POST['duration'], "d")) {
                $modified = (clone $now)->add(new DateInterval("P{$duration[0]}D"));
                DbModel::updatePublication('expireAt', $modified->format('Y-m-d H:i:s'), $id);

            } else if (str_contains($_POST['duration'], "h")) {
                $modified = (clone $now)->add(new DateInterval("PT{$duration[0]}H"));
                DbModel::updatePublication('expireAt', $modified->format('Y-m-d H:i:s'), $id);

            } else if (str_contains($_POST['duration'], "m")) {
                $modified = (clone $now)->add(new DateInterval("PT{$duration[0]}M"));
                DbModel::updatePublication('expireAt', $modified->format('Y-m-d H:i:s'), $id);
            }
        }
        if( isset($_POST['visibility']) ) {
            PublishController::$visibility = $_POST['visibility'];
            if (self::$visibility == 'public')
                DbModel::updatePublication('isPublic', 1, $id);
            if (self::$visibility == 'private')
                DbModel::updatePublication('isPublic', 0, $id);
        }
    }

    public function getPublish()
    {
        if( isset($_POST['password']) ) {
            PublishController::$password = $_POST['password'];

            error_reporting(E_ALL ^ E_WARNING);
            date_default_timezone_set('Europe/Bucharest');
            $now = new DateTime();

            $link = $_SERVER['REQUEST_URI'];
            $id = preg_split("[/]", $link);
            $id = $id[2];

            $isPublic = Publication::getPublicationProprietyByLink('isPublic', $id);
            $password = Publication::getPublicationProprietyByLink('password', $id);
            $expirationDate = Publication::getPublicationProprietyByLink('expireAt', $id);


            if ($isPublic && $password == self::$password && $expirationDate > $now->format('Y-m-d H:i:s')) {
                $link = Publication::getPublicationProprietyByLink('link', $id);
                $path = "../../publications/{$link}.html";
                $mail = file_get_contents($path);
                echo quoted_printable_decode($mail);
            }
            else
                echo "UNAUTHORIZED";
        }
    }
}