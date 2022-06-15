<?php

namespace app\controllers;

use app\core\Database;
use app\models\Publication;
use function MongoDB\BSON\toJSON;
use app\models\User;

class MailController extends Controller
{
    public function getMail()
    {

        $host = "{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}INBOX";

        $user = "emailpublisherweb@gmail.com";
        $password = "lqfalrpltsljnbwx";


        $conn = imap_open($host, $user, $password) or die("unable to connect Gmail: " . imap_last_error());
        $mails = imap_search($conn, 'UNSEEN');

        if ($mails == NULL)
            echo "NO NEW EMAILS";
        else
            foreach ($mails as $msg_number) {

                $path='C:\\xampp\\htdocs\\emailPublisher\\mail_files\\' . $msg_number . 'mail.html';

                $header = imap_headerinfo($conn, $msg_number);

//                echo "personal " . $header->sender[0]->mailbox . "<br>";
//                echo "fromaddress " . $header->sender[0]->host . "<br>";

                $myEmail=$header->sender[0]->mailbox . '@' . $header->sender[0]->host;

                echo $myEmail . "<br>";
                //cream un user nou in cazul in care acesta nu este in db
                if(!User::verifyIfEmailExists($myEmail) && $myEmail!='emailpublisherweb@gmail.com'){
                    $user= new User();
                    $user->setEmail($myEmail);
                    $user->setIsActive(true);
                    $user->setToken('1234567');
                    $user->save();
                }

                error_reporting(E_ALL ^ E_NOTICE);
                $body = imap_fetchbody($conn, $msg_number, "2");

                //adaugam publicatiile in db

                $publication=new Publication();

                //TODO verify if a publication is already in db or put flag to unseen
                //TODO parse subject for getting the time, the method of visibility, etc => SET IS PUBLIC 0 OR 1
                // if you get the duration then you should populate expireAt field

                $id=User::getUserIdByEmail($header->sender[0]->mailbox);
                $publication->setIdUser($id);

                $publication->setIsPublic(0);
                $publication->setPassword('password');
                $publication->setSubject($header->subject);
                $publication->setBody($body);
                $publication->save();

                $printable = imap_qprint($body);

                echo $header->subject . "<br>";

                file_put_contents($path, $printable);

                imap_clearflag_full($conn, $msg_number, "\\Seen");
            }
    }
}