<?php

namespace App\Utils\Services\User;

use App\Utils\Exception\ServiceError;
use App\Utils\Response\User\MockUserResponse;
use Exception;
use GuzzleHttp\Exception\GuzzleException;

interface UserServiceInterface
{

    /**
     * @throws ServiceError|GuzzleException|Exception
     */
    public function getMockUser(string $username): MockUserResponse;
}