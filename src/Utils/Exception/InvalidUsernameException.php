<?php

namespace App\Utils\Exception;

use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class InvalidUsernameException extends UserNotFoundException
{

}