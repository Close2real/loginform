<?php

namespace App\Utils\Response\User;

use App\Utils\Objects\User\Mock\UserData;
use App\Utils\Objects\User\Mock\UserExtraData;
use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation\Type;

class MockUserResponse
{
    /**
     * @Type("App\Utils\Objects\User\Mock\UserData")
     * @var UserData
     */
    private $userData;

    /**
     * @Type("ArrayCollection<App\Utils\Objects\User\SJ3\UserExtraData>")
     * @var ArrayCollection<UserExtraData>|null
     */
    private $userExtraData;

    /**
     * @return ArrayCollection|null
     */
    public function getUserExtraData(): ?ArrayCollection
    {
        return $this->userExtraData;
    }

    /**
     * @param ArrayCollection|null $userExtraData
     * @return MockUserResponse
     */
    public function setUserExtraData(?ArrayCollection $userExtraData): MockUserResponse
    {
        $this->userExtraData = $userExtraData;
        return $this;
    }

    /**
     * @return UserData
     */
    public function getUserData(): UserData
    {
        return $this->userData;
    }

    /**
     * @param UserData $userData
     * @return MockUserResponse
     */
    public function setUserData(UserData $userData): MockUserResponse
    {
        $this->userData = $userData;
        return $this;
    }
}