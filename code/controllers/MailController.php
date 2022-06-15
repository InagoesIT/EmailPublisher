<?php

namespace app\controllers;

use function MongoDB\BSON\toJSON;

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
                // Get email headers and body

                $path='C:\\xampp\\htdocs\\emailPublisher\\mail_files\\' . $msg_number . 'mail.html';

                $header = imap_headerinfo($conn, $msg_number);
                error_reporting(E_ALL ^ E_NOTICE);
                $body = imap_fetchbody($conn, $msg_number, "2");
                $printable = imap_qprint($body);

                echo $header->subject . "<br>";
//                echo imap_qprint($body);

                file_put_contents($path, $printable);

                imap_clearflag_full($conn, $msg_number, "\\Seen");
            }
    }
}