<?php

namespace app\controllers;

use app\core\App;
use app\core\DbModel;
use app\models\Publication;


class PublishController extends Controller
{
    public function getPublish()
    {
        error_reporting(E_ALL ^ E_WARNING);
        $link = $_SERVER['REQUEST_URI'];
        $id = preg_split("[/]", $link);
        $id = $id[2];
        $pub = Publication::findOne(['link' => $id]);
        $link = $pub->link;
        $path="../../publications/{$link}.html";
        $mail = file_get_contents($path);
//        echo imap_qprint($mail);
        echo quoted_printable_decode($mail);
    }
}