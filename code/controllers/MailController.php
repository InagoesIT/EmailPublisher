<?php

namespace app\controllers;

use app\core\Database;
use app\models\Publication;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use function MongoDB\BSON\toJSON;
use app\models\User;

class MailController extends Controller
{
    private const HOST = "{imap.gmail.com:993/imap/ssl/novalidate-cert/norsh}INBOX";
    private const USER = "emailpublisherweb@gmail.com";
    private const PASSWORD = "lqfalrpltsljnbwx";
    private const PATTERN = "/(\[{1}).*?(\]{1})/i";
    private const INVALID_SUBJECT = "Invalid Subject";
    private const VALID_SUBJECT = "Valid Subject";

    private $conn;

    public function setupInbox()
    {
        $this->conn = imap_open(self::HOST, self::USER, self::PASSWORD) or die("unable to connect Gmail: " . imap_last_error());

        return imap_search($this->conn, 'UNSEEN');
    }

    public function checkUser($pub, $msg_number)
    {
        $header = imap_headerinfo($this->conn, $msg_number);
        $senderAddress = $header->sender[0]->mailbox . '@' . $header->sender[0]->host;

        if(!User::verifyIfEmailExists($senderAddress) && $senderAddress!='emailpublisherweb@gmail.com'){
            $user= new User();
            $user->setEmail($senderAddress);
            $user->setIsActive(true);
            $user->generateToken();
            $user->save();

            $pub->setIdUser($user->getId());
        }
        else
            $pub->setIdUser(User::getUserIdByEmail($senderAddress));
    }

	public static function configureMail($mail)
	{
		$mail->SMTPDebug = SMTP::DEBUG_SERVER;
		$mail->isSMTP();
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		$mail->Port = 587;

		$mail->Username = 'emailpublisherweb@gmail.com'; // YOUR gmail email
		$mail->Password = 'lqfalrpltsljnbwx'; // YOUR gmail password

		// Sender and recipient settings
		$mail->setFrom($mail->Username, 'EmailPublisher');
	}

    public function checkSubject($pub, $msg_number): string
    {
        // TODO all echos to be replaced with actions accordingly
        $header = imap_headerinfo($this->conn, $msg_number);
        $subject = $header->subject;

        $tags = preg_match_all(self::PATTERN, $subject, $matches);
        for($it = 0; $it < $tags; $it++) {
            $tag = preg_split("[=]", $matches[0][$it]);
            if ($tag[0] != "[password" && $tag[0] != "[duration" && $tag[0] != "[public]" && $tag[0] != "[private]")
                return self::INVALID_SUBJECT;
            else {
                switch ($tag[0]) {
                    case "[password":
                        $password = substr($tag[1], 0, strlen($tag[1]) - 1);
                        $pub->setPassword($password);
                        break;
                    case "[duration":
                        $duration = preg_split("/[dhm]/", $tag[1]);
                        if (strpos($tag[1], "d") > strpos($tag[1], "h") ||
                            strpos($tag[1], "d") > strpos($tag[1], "m") ||
                            strpos($tag[1], "h") > strpos($tag[1], "m"))
                            return self::INVALID_SUBJECT;
                        else {
                            echo "<br>";
                            if (str_contains($tag[1], "d") && str_contains($tag[1], "h") && str_contains($tag[1], "m")) {
                                echo "Days: " . $duration[0] . "<br>";
                                echo "Hours: " . $duration[1] . "<br>";
                                echo "Minutes: " . $duration[2] . "<br>";
                            }
                            else if (str_contains($tag[1], "d") && str_contains($tag[1], "h")) {
                                echo "Days: " . $duration[0] . "<br>";
                                echo "Hours: " . $duration[1] . "<br>";
                            }
                            else if (str_contains($tag[1], "d") && str_contains($tag[1], "m")) {
                                echo "Days: " . $duration[0] . "<br>";
                                echo "Minutes: " . $duration[1] . "<br>";
                            }
                            else if (str_contains($tag[1], "h") && str_contains($tag[1], "m")) {
                                echo "Hours: " . $duration[0] . "<br>";
                                echo "Minutes: " . $duration[1] . "<br>";
                            }
                            else if (str_contains($tag[1], "m")) {
                                echo "Minutes: " . $duration[0] . "<br>";
                            }
                        }
                        break;
                    case "[public]":
                        $pub->setIsPublic(true);
                        break;
                    case "[private]":
                        $pub->setIsPublic(false);
                        break;
                }
            }
        }
        return self::VALID_SUBJECT;
    }

    public function sendMail ($address, $subject, $body)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            self::configureMail($mail);
            $mail->addAddress($address, $address);

            // Setting the email content
			// $mail->IsHTML(true);
            $mail->Subject = $subject;
            $mail->Body = $body;
            $mail->AltBody = $body;

            $mail->send();
        } catch (Exception $e) {

        }
    }

    public function processInbox()
    {
        $pub = new Publication();
        $mails = $this->setupInbox();
        if ($mails !== NULL)
            foreach ($mails as $msg_number) {
                $this->checkUser($pub, $msg_number);
                $goodMail = $this->checkSubject($pub, $msg_number);

                $header = imap_headerinfo($this->conn, $msg_number);
                $senderAddress = $header->sender[0]->mailbox . '@' . $header->sender[0]->host;

                echo "<br><br><br>" . $goodMail . "<br><br><br>";

                if ($goodMail == self::VALID_SUBJECT)     // TODO publication link
                    $this->sendMail($senderAddress, $goodMail,
                        "Thank you for publishing your mail.\n");
                else
                    $this->sendMail($senderAddress, $goodMail,
                        "We are sorry to inform you, your mail was not published.\n");
            }
    }

    // TODO remove code below when not useful anymore, function never called
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
                    $user->setToken('1234567'); // TODO generate token
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