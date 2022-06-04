<?php

namespace app\models;

use app\core\App;
use app\core\DbModel;

class User extends DbModel
{
	private string $email = '';
	private bool $isActive = false;
	private ?string $token = null;

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

	public function login()
	{
		$user = User::findOne(['email' => $this->email]);
		if (!$user)
		{
			$this->addError('email', 'No user with this email');
			return false;
		}

		return App::$app->login($user);
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