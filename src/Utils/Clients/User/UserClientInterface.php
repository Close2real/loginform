<?php

namespace App\Utils\Clients\User;

use Exception;
use GuzzleHttp\Exception\GuzzleException;
use App\Utils\Response\User\MockUserResponse;
use App\Utils\Response\_Api\ApiErrorResponse;

interface UserClientInterface
{

    /**
     * @param string $username
     * @return MockUserResponse|ApiErrorResponse
     * @throws GuzzleException
     * @throws Exception
     */
    public function getMockUser(string $username);
}