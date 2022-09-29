<?php

namespace App\Utils\Request\Auth;

use App\Utils\Request\Parameters;
use JMS\Serializer\Annotation\Type;

class LoginParameters extends Parameters
{
	/**
	 * @Type("string")
	 * @var string
	 */
	private $username;

	/**
	 * @Type("string")
	 * @var string
	 */
	private $password;

	/**
	 * @return string
	 */
	public function getUsername(): string
	{
		return $this->username;
	}

	/**
	 * @param string $username
	 * @return LoginParameters
	 */
	public function setUsername(string $username): LoginParameters
	{
		$this->username = $username;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword(): string
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 * @return LoginParameters
	 */
	public function setPassword(string $password): LoginParameters
	{
		$this->password = $password;
		return $this;
	}
}