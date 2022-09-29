<?php

namespace App\Utils\Services\Auth;

use App\Utils\Clients\Auth\AuthClientInterface;
use App\Utils\Request\Auth\LoginParameters;
use App\Utils\Response\User\LoginResponse;
use App\Utils\Traits\HttpUtils;

class AuthService implements AuthServiceInterface
{
	use HttpUtils;

	/**
	 * @var AuthClientInterface
	 */
	private $client;

	/**
	 * @param AuthClientInterface $client
	 */
	public function __construct(AuthClientInterface $client)
	{
		$this->client = $client;
	}

	/**
	 * @inheritDoc
	 */
	public function validateCredentials(LoginParameters $parameters): LoginResponse
	{
		$response = $this->client->validateCredentials(
			$parameters->serializeToArray(self::getSerializer())
		);

		$this->validateApiResponse($response);

		return $response;
	}

}