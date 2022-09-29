<?php

namespace App\Utils\Response\User;

use JMS\Serializer\Annotation\Type;

class LoginResponse
{

	/**
	 * @Type("string")
	 * @var string
	 */
	private $message;

	/**
	 * @return string
	 */
	public function getMessage(): string
	{
		return $this->message;
	}

	/**
	 * @param string $message
	 * @return LoginResponse
	 */
	public function setMessage(string $message): LoginResponse
	{
		$this->message = $message;
		return $this;
	}

}