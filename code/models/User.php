<?php

namespace app\models;

use app\core\App;
use app\core\DbModel;

class User extends DbModel
{
	public ?int $id = null;
	private string $email;
	private bool $isActive = false;
	private ?string $token;

	/**
	 * @param string $email
	 * @param string $token
	 */
	public function __construct(string $email, string $token)
	{
		$this->email = $email;
		$this->token = $token;
	}

	public static function tableName() : string
	{
		return 'users';
	}

	public static function attributes() : array
	{
		return ['email', 'isActive'];
	}

	public function rules() : array
	{
		return [
			'email' => [self::RULE_REQUIRED, self::RULE_EMAIL]
		];
	}

	public function save() : bool
	{
		$this->isActive = false;
		return parent::save();
	}

	public function login(): bool
	{
//		$user = User::findOne(['email' => $this->email]);
//		if (!$user)
//		{
//			$this->addError('email', 'No user with this email');
//			return false;
//		}
		$this->id = 1;

		return App::$app->login($this);
	}

	/**
	 * @return int|null
	 */
	public function getId(): ?int
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