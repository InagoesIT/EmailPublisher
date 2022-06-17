<?php

namespace app\controllers;

use app\core\App;
use app\core\Database;
use app\models\Publication;
use DateInterval;
use DateTime;
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
    private const INVALID_SUBJECT = "Invalid Publish";
    private const VALID_SUBJECT = "Valid Publish";

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
//            $user->generateToken();     // TODO generate token
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
                        date_default_timezone_set('Europe/Bucharest');
                        $createdAt = new DateTime();
                        $pub->setCreatedAt($createdAt->format('Y-m-d H:i:s'));

                        $duration = preg_split("/[dhm]/", $tag[1]);
                        if (strpos($tag[1], "d") > strpos($tag[1], "h") ||
                            strpos($tag[1], "d") > strpos($tag[1], "m") ||
                            strpos($tag[1], "h") > strpos($tag[1], "m"))
                            return self::INVALID_SUBJECT;
                        else {
                            echo "<br>";
                            if (str_contains($tag[1], "d") && str_contains($tag[1], "h") && str_contains($tag[1], "m")) {
                                $modified = (clone $createdAt)->add(new DateInterval("PT{$duration[0]}D{$duration[1]}H{$duration[2]}M"));
                                $pub->setExpireAt($modified->format('Y-m-d H:i:s'));
                            }
                            else if (str_contains($tag[1], "d") && str_contains($tag[1], "h")) {
                                $modified = (clone $createdAt)->add(new DateInterval("PT{$duration[0]}D{$duration[1]}H"));
                                $pub->setExpireAt($modified->format('Y-m-d H:i:s'));
                            }
                            else if (str_contains($tag[1], "d") && str_contains($tag[1], "m")) {
                                $modified = (clone $createdAt)->add(new DateInterval("PT{$duration[0]}D{$duration[1]}M"));
                                $pub->setExpireAt($modified->format('Y-m-d H:i:s'));
                            }
                            else if (str_contains($tag[1], "h") && str_contains($tag[1], "m")) {
                                $modified = (clone $createdAt)->add(new DateInterval("PT{$duration[0]}H{$duration[1]}M"));
                                $pub->setExpireAt($modified->format('Y-m-d H:i:s'));
                            }
                            else if (str_contains($tag[1], "m")) {
                                $modified = (clone $createdAt)->add(new DateInterval("PT{$duration[0]}M"));
                                $pub->setExpireAt($modified->format('Y-m-d H:i:s'));
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

                $pub->setBody(imap_fetchbody($this->conn, $msg_number, "2"));
//                imap_clearflag_full($this->conn, $msg_number, "\\Seen");
                $pub->setLink($_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/" . md5(uniqid(), false));

                $header = imap_headerinfo($this->conn, $msg_number);
                $senderAddress = $header->sender[0]->mailbox . '@' . $header->sender[0]->host;

                if ($goodMail == self::VALID_SUBJECT) {    // TODO publication link
                    $pub->save();
                    $this->sendMail($senderAddress, $goodMail,
                        "Thank you for publishing your mail. <br>
                        Your publication can be found at {$pub->getLink()} until {$pub->getExpireAt()} using password {$pub->getPassword()}.<br>
                        Have a wonderful day!");
                }
                else
                    $this->sendMail($senderAddress, $goodMail,
                        "We are sorry to inform you, your mail was not published.");
            }
    }
}