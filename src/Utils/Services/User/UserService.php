<?php

namespace App\Utils\Services\User;

use App\Utils\Clients\User\UserClientInterface;
use App\Utils\Response\User\MockUserResponse;
use App\Utils\Traits\HttpUtils;

class UserService implements UserServiceInterface
{
    use HttpUtils;

    /**
     * @var UserClientInterface
     */
    private $client;

    /**
     * @param UserClientInterface $client
     */
    public function __construct(UserClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @inheritDoc
     */
    public function getMockUser(string $username): MockUserResponse
    {
        $response = $this->client->getMockUser($username);

        $this->validateApiResponse($response);

        return $response;
    }
}