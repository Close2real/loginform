<?php

namespace App\Utils\Response\_Client;

use App\Utils\Objects\Pagination\Pagination;

class ClientResponse
{
	/**
	 * @var int
	 */
	private $code;

	/**
	 * @var boolean
	 */
	private $hasError;

	/**
	 * @var string|null
	 */
	private $errorMessage;

	/**
	 * @var mixed|null
	 */
	private $data;

	/**
	 * @var string|null
	 */
	private $locale;

	/**
	 * @var Pagination|null
	 */
	private $pagination;

	/**
	 * @return int
	 */
	public function getCode(): int
	{
		return $this->code;
	}

	/**
	 * @param int $code
	 * @return ClientResponse
	 */
	public function setCode(int $code): ClientResponse
	{
		$this->code = $code;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isHasError(): bool
	{
		return $this->hasError;
	}

	/**
	 * @param bool $hasError
	 * @return ClientResponse
	 */
	public function setHasError(bool $hasError): ClientResponse
	{
		$this->hasError = $hasError;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getErrorMessage(): ?string
	{
		return $this->errorMessage;
	}

	/**
	 * @param string|null $errorMessage
	 * @return ClientResponse
	 */
	public function setErrorMessage(?string $errorMessage): ClientResponse
	{
		$this->errorMessage = $errorMessage;
		return $this;
	}

	/**
	 * @return mixed|null
	 */
	public function getData()
	{
		return $this->data;
	}

	/**
	 * @param mixed|null $data
	 * @return ClientResponse
	 */
	public function setData($data): ClientResponse
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * @return string|null
	 */
	public function getLocale(): ?string
	{
		return $this->locale;
	}

	/**
	 * @param string|null $locale
	 * @return ClientResponse
	 */
	public function setLocale(?string $locale): ClientResponse
	{
		$this->locale = $locale;
		return $this;
	}

	/**
	 * @return Pagination|null
	 */
	public function getPagination(): ?Pagination
	{
		return $this->pagination;
	}

	/**
	 * @param Pagination|null $pagination
	 * @return ClientResponse
	 */
	public function setPagination(?Pagination $pagination): ClientResponse
	{
		$this->pagination = $pagination;
		return $this;
	}

}