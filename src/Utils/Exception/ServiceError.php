<?php

namespace App\Utils\Exception;

use Exception;
use Throwable;

class ServiceError extends Exception
{
    /**
     * @var string|null
     */
    private $customCode;

    /**
     * @inheritDoc
     * @param string|null $customCode
     */
    public function __construct(?string $message = null , ?string $customCode = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);

        $this->customCode = $customCode;
    }

    public function getCustomCode(): ?string
    {
        return $this->customCode;
    }

    public function setCustomCode(?string $customCode): ServiceError
    {
        $this->customCode = $customCode;
        return $this;
    }
}