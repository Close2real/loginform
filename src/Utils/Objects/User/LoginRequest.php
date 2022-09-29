<?php

namespace App\Utils\Objects\User;

use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints as Assert;

class LoginRequest
{

	/**
	 * @Assert\NotBlank(
	 *     message="Inserisci lo username"
	 * )
	 * @Type("string")
	 * @var string|null
	 */
	private $username;

	/**
	 * @Assert\NotBlank(
	 *     message="Inserisci la password"
	 * )
	 * @Type("string")
	 * @var string|null
	 */
	private $password;

	/**
	 * @return string|null
	 */
	public function getUsername(): ?string
	{
		return $this->username;
	}

	/**
	 * @param string|null $username
	 * @return LoginRequest
	 */
	public function setUsername(?string $username): LoginRequest
	{
		$this->username = $username;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getPassword(): ?string
	{
		return $this->password;
	}

	/**
	 * @param string|null $password
	 * @return LoginRequest
	 */
	public function setPassword(?string $password): LoginRequest
	{
		$this->password = $password;
		return $this;
	}

}