<?php

namespace App\Utils\Services\Auth;

use App\Utils\Exception\ServiceError;
use App\Utils\Request\Auth\LoginParameters;
use App\Utils\Response\User\LoginResponse;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

interface AuthServiceInterface
{

	/**
	 * @param LoginParameters $parameters
	 * @return LoginResponse
	 * @throws ServiceError|GuzzleException|Exception
	 */
	public function validateCredentials(LoginParameters $parameters): LoginResponse;

}