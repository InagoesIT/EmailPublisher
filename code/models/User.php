<?php

namespace app\models;

use app\core\App;
use app\core\DbModel;

class User extends DbModel
{
    public ?int $id = null;
    public string $email = "";
    public bool $isActive = false;
    public ?string $token;


    public function __construct()
    {
        $arguments = func_get_args();
        $numberOfArguments = func_num_args();

        if (method_exists($this, $function = '__construct' . $numberOfArguments)) {
            call_user_func_array(array($this, $function), $arguments);
        }
    }

    public function __construct1($email)
    {
        $this->email = $email;
    }

    public function __construct2($email, $token)
    {
        $this->token = $token;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public static function tableName(): string
    {
        return 'users';
    }

    public static function attributes(): array
    {
        return ['email', 'isActive', 'token'];
    }

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL]
        ];
    }

    public function save(): bool
    {
        $this->isActive = false;
        return parent::save();
    }

    public function login(): bool
    {
        $user = User::findOne(['email' => $this->email]);
        $this->id = $user->id;
        $this->activateUser();

        //add the user id to the session so we know who is logged in
        return App::$app->login($this);
    }

    public function generateToken(): void
    {
        $this->token = bin2hex(openssl_random_pseudo_bytes(4));
    }

    public function updateToken()
    {
        $statement = self::prepare("UPDATE users SET token = '" . $this->token . "' 
										WHERE email = '" . $this->email . "';");
        $statement->execute();
    }

    public function activateUser()
    {
        $this->isActive = true;
        $statement = self::prepare("UPDATE users SET isActive = '" . $this->isActive . "' 
										WHERE email = '" . $this->email . "';");
        $statement->execute();
    }

    public function isTokenValid(string $token): bool
    {
        $user = self::findOne(["email" => $this->email]);
        echo $user->email;
        echo $user->token;

        return ($user->token == $token);
    }


    public static function verifyIfEmailExists($myEmail) : ?bool
    {
        $statement = self::prepare('SELECT * from users');
        $statement->execute();
        if ($statement->rowCount() > 0) {
          while($row=$statement->fetch()){
//              echo "email" . $row['email'] . "<br>";
              if($row['email']==$myEmail){
                  return true;
              }
          }
        }
        return false;
    }
    public static function getUserIdByEmail($myEmail) : ?int{
        $query="SELECT * FROM users where email like '$myEmail%'";
        echo $query;
        $statement=self::prepare($query);
        $statement->execute();
        if($statement->rowCount()==1){
            $row=$statement->fetch();
            return $row['id'];
        }
        return 0;
    }

    /**
     * @return int|null
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string|null $token
     */
    public function setToken(?string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    public static function primaryKey(): string
    {
        return 'id';
    }
}