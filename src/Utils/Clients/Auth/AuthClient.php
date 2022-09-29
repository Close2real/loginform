<?php

namespace App\Utils\Clients\Auth;

use App\Utils\Request\HttpRequest\HttpRequestParameters;
use App\Utils\Response\User\LoginResponse;
use App\Utils\Traits\HttpUtils;

class AuthClient implements AuthClientInterface
{
	use HttpUtils;

	/**
	 * @inheritDoc
	 */
	public function validateCredentials(array $parameters)
	{
		$url = "$this->esbSj3Base/sj3-1/v1/$this->jobId/user/checkCredentials";

		$request = new HttpRequestParameters();
		$request->setParameters($parameters);
		$request->setIsExternalUri(true);
		$request->setUri($url);

		$response = $this->post($request);
		unset($request);

		return $this->parseResponse($response, LoginResponse::class, false);
	}

}