<?php

namespace App\Utils\Services\SystemLog;

use Exception;
use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class LogService implements LogServiceInterface
{

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LogService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @inheritDoc
     */
    public function logServiceError(Exception $e): void
    {
        $this->logger->error(sprintf(
            "THROW SERVICE ERROR - %s - %s - %s",
            $e->getCode(),
            $e->getMessage(),
            json_encode($e->getTrace())
        ));
    }

    /**
     * @inheritDoc
     */
    public function logException($e, ?UserInterface $user): void
    {
        try
        {
            if ($user instanceof UserInterface)
                $cdUser = $user->getUserIdentifier();
            else
                $cdUser = 'ERROR';
        }
        catch(Exception $exception)
        {
            $cdUser = 'ERROR';
        }

        $this->logger->error(sprintf("THROW EXCEPTION %s - %s - %s",
            $cdUser, $e->getMessage(),json_encode($e->getTrace())));
    }

    /**
     * @inheritDoc
     */
    public function logGlobalException(Exception $e): void
    {
        $this->logger->log($e->getCode(), sprintf("****** %s ******", $e->getMessage()));
    }

    /**
     * @inheritDoc
     */
    public function logWarning(string $message): void
    {
        $this->logger->warning(sprintf("** %s **", $message));
    }

    /**
     * @inheritDoc
     */
    public function logInfo(string $message): void
    {
        $this->logger->info(sprintf(" %s ", $message));
    }

    /**
     * @inheritDoc
     */
    public function logError(string $message): void
    {
        $this->logger->error(sprintf(" %s ", $message));
    }
}