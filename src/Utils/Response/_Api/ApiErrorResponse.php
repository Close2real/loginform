<?php

namespace App\Utils\Response\_Api;

use JMS\Serializer\Annotation\Type;

class ApiErrorResponse
{
	/**
	 * @Type("int")
	 * @var int|null
	 */
	protected $httpStatusCode;

    /**
     * @Type("int")
     * @var int|null
     */
    protected $code;

    /**
     * @Type("string")
     * @var string|array|null
     */
    protected $message;

    /**
     * @Type("string")
     * @var string|null
     */
    protected $timestamp;

	/**
	 * @return int|null
	 */
	public function getHttpStatusCode(): ?int
	{
		return $this->httpStatusCode;
	}

	/**
	 * @param int|null $httpStatusCode
	 * @return ApiErrorResponse
	 */
	public function setHttpStatusCode(?int $httpStatusCode): ApiErrorResponse
	{
		$this->httpStatusCode = $httpStatusCode;
		return $this;
	}

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @param int|null $code
     * @return ApiErrorResponse
     */
    public function setCode(?int $code): ApiErrorResponse
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return array|string|null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param array|string|null $message
     * @return ApiErrorResponse
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getTimestamp(): ?string
    {
        return $this->timestamp;
    }

    /**
     * @param string|null $timestamp
     * @return ApiErrorResponse
     */
    public function setTimestamp(?string $timestamp): ApiErrorResponse
    {
        $this->timestamp = $timestamp;
        return $this;
    }

    /**
     * @return string
     */
    public static function getClassName()
    {
        return get_called_class();
    }
}
