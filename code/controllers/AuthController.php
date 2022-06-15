<?php

namespace app\controllers;

use app\core\App;
use app\core\Request;
use app\core\Response;
use app\models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class AuthController extends Controller
{
	private const TOKEN = 'token';
	private const EMAIL = 'email';

    public function sendMail (User $user)
    {
        $mail = new PHPMailer(true);

        try {
            // Server settings
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
            $mail->addAddress($user->email, $user->email);

            // Setting the email content
            $mail->IsHTML(true);
            $mail->Subject = "Validation token";
            $mail->Body = 'Your token is:<br>' . $user->token;
            $mail->AltBody = $user->token;

            $mail->send();
        } catch (Exception $e) {

        }
    }

	public function auth(Request $request, Response $response)
	{
		if (isset($_POST[self::TOKEN]))
			return $this->login($request, $response);
		return $this->tokenAuth($response);
	}

	private function login(Request $request, Response $response): string
	{
		$session = App::$app->session;
		$token = $request->getValueFor(self::TOKEN);
		$user = new User($session->get(self::EMAIL));

		//will add the error message
		if (!$user->isTokenValid($token))
		{
			$response->setStatusCode(400);
			$this->setTitle("authentication");
			return $this->render('auth_token', ["isError" => true]);
		}

		$user->login();
		$response->setStatusCode(200);
		$response->redirect("/");
		return "email: " . $_SESSION[self::EMAIL] . " token: " . $_POST[self::TOKEN];
	}

	private function tokenAuth(Response $response)
	{
		$session = App::$app->session;
		$session->set(self::EMAIL, $_POST[self::EMAIL]);

		$user = new User();
		$user->setEmail($_POST[self::EMAIL]);
		$user->generateToken();
		if (!$user->save())
			$user->updateToken();

        $this->sendMail($user);

		$response->setStatusCode(200);
		$this->setTitle("authentication");
		return $this->render('auth_token');
	}

	public function authEmail(Request $request, Response $response)
	{
		$response->setStatusCode(200);
		$this->setTitle("authentication");
		return $this->render('auth_email');
	}

	public function logout(Request $request, Response $response) : void
	{
		App::$app->logout();
		$response->redirect('/');
	}
}