<?php

namespace App\Utils\Clients\Auth;

use App\Utils\Response\_Api\ApiErrorResponse;
use App\Utils\Response\User\LoginResponse;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

interface AuthClientInterface
{
	/**
	 * @param array $parameters
	 * @return LoginResponse|ApiErrorResponse
	 * @throws GuzzleException|Exception
	 */
	public function validateCredentials(array $parameters);
}