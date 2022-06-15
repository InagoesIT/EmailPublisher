<?php

namespace app\controllers;

use app\core\Database;
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
                if(!User::verifyIfEmailExists($myEmail)){
                    $user= new User();
                    $user->setEmail($myEmail);
                    $user->setIsActive(true);
                    $user->setToken('1234567');
                    $user->save();
                }

                error_reporting(E_ALL ^ E_NOTICE);
                $body = imap_fetchbody($conn, $msg_number, "2");
                $printable = imap_qprint($body);

                echo $header->subject . "<br>";

                file_put_contents($path, $printable);

                imap_clearflag_full($conn, $msg_number, "\\Seen");
            }
    }
}