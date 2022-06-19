<?php

namespace app\controllers;

use app\core\App;
use app\core\DbModel;
use app\models\Publication;
use DateTime;


class PublishController extends Controller
{
    public static string $password;

    public function print() {
        return self::render('mailAuth');
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