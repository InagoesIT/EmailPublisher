<?php

namespace app\controllers;

use app\core\DbModel;
use app\models\Publication;

class PublishController extends Controller
{
    public function getPublish()
    {
        $link = $_SERVER['REQUEST_URI'];
        $id = preg_split("[/]", $link);
        $id = $id[2];
        $pub = Publication::findOne(['link' => $id]);
        $link = $pub->link;
        $path="C:/xampp/htdocs/emailPublisher/mail_files/mail/{$link}.html";
        $mail = file_get_contents($path);
        echo imap_qprint($mail);
    }
}