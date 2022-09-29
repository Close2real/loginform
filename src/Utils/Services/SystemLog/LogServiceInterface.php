<?php

namespace App\Utils\Services\SystemLog;


use Error;
use Exception;
use Symfony\Component\Security\Core\User\UserInterface;
use Throwable;

interface LogServiceInterface
{
    /**
     * @param Exception $e
     */
    public function logServiceError(Exception $e): void;

    /**
     * @param Exception $e
     */
    public function logGlobalException(Exception $e) : void;

    /**
     * @param string $message
     */
    public function logWarning(string $message) : void;

    /**
     * @param string $message
     */
    public function logInfo(string $message) : void;

    /**
     * @param string $message
     */
    public function logError(string $message) : void;

    /**
     * @param Exception|Throwable|Error $e
     * @param object|UserInterface|null $user
     */
    public function logException($e, ?UserInterface $user): void;
}