<?php

namespace App\Utils\Request\HttpRequest;

use App\Utils\Request\HttpRequest\Data\HttpHeaders;
use App\Utils\Request\HttpRequest\Data\HttpParameters;
use App\Utils\Request\HttpRequest\Data\HttpRequestCert;
use App\Utils\Request\Parameters;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class HttpRequestParameters
 * @package App\Utils\Request\HttpRequest
 */
class HttpRequestParameters extends Parameters
{
	/**
	 * @var string
	 */
	private $httpMethod;

	/**
	 * @var string
	 */
	private $uri;

	/**
	 * @var ArrayCollection|array|mixed|null
	 */
	private $parameters;

	/**
	 * @var HttpHeaders|null
	 */
	private $headers;

	/**
	 * @var boolean
	 */
	private $isMultipartRequest;

	/**
	 * @var boolean
	 */
	private $isExternalUri;

	/**
	 * @var string
	 */
	private $httpProtocol;

	/**
	 * @var HttpRequestCert
	 */
	private $httpRequestCert;

	/**
	 * HttpRequestParameters constructor.
	 */
	public function __construct()
	{
		$this->parameters = new HttpParameters();
		$this->headers = new HttpHeaders();
		$this->httpRequestCert = new HttpRequestCert();
		$this->isMultipartRequest = false;
		$this->isExternalUri = false;
		$this->httpProtocol = '1.1';
	}

	/**
	 * @return string
	 */
	public function getHttpMethod(): string
	{
		return $this->httpMethod;
	}

	/**
	 * @param string $httpMethod
	 * @return HttpRequestParameters
	 */
	public function setHttpMethod(string $httpMethod): HttpRequestParameters
	{
		$this->httpMethod = $httpMethod;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getUri(): string
	{
		return $this->uri;
	}

	/**
	 * @param string $uri
	 * @return HttpRequestParameters
	 */
	public function setUri(string $uri): HttpRequestParameters
	{
		$this->uri = $uri;
		return $this;
	}

	/**
	 * @return array|ArrayCollection|mixed|null
	 */
	public function getParameters()
	{
		return $this->parameters;
	}

	/**
	 * @param array|ArrayCollection|mixed|null $parameters
	 */
	public function setParameters($parameters): HttpRequestParameters
	{
		$this->parameters = $parameters;
		return $this;
	}

	/**
	 * @return HttpHeaders|null
	 */
	public function getHeaders(): ?HttpHeaders
	{
		return $this->headers;
	}

	/**
	 * @param HttpHeaders|null $headers
	 * @return HttpRequestParameters
	 */
	public function setHeaders(?HttpHeaders $headers): HttpRequestParameters
	{
		$this->headers = $headers;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isMultipartRequest(): bool
	{
		return $this->isMultipartRequest;
	}

	/**
	 * @param bool $isMultipartRequest
	 * @return HttpRequestParameters
	 */
	public function setIsMultipartRequest(bool $isMultipartRequest): HttpRequestParameters
	{
		$this->isMultipartRequest = $isMultipartRequest;
		return $this;
	}

	/**
	 * @return bool
	 */
	public function isExternalUri(): bool
	{
		return $this->isExternalUri;
	}

	/**
	 * @param bool $isExternalUri
	 * @return HttpRequestParameters
	 */
	public function setIsExternalUri(bool $isExternalUri): HttpRequestParameters
	{
		$this->isExternalUri = $isExternalUri;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getHttpProtocol(): string
	{
		return $this->httpProtocol;
	}

	/**
	 * @param string $httpProtocol
	 * @return HttpRequestParameters
	 */
	public function setHttpProtocol(string $httpProtocol): HttpRequestParameters
	{
		$this->httpProtocol = $httpProtocol;
		return $this;
	}

	/**
	 * @return HttpRequestCert
	 */
	public function getHttpRequestCert(): HttpRequestCert
	{
		return $this->httpRequestCert;
	}

	/**
	 * @param HttpRequestCert $httpRequestCert
	 * @return HttpRequestParameters
	 */
	public function setHttpRequestCert(HttpRequestCert $httpRequestCert): HttpRequestParameters
	{
		$this->httpRequestCert = $httpRequestCert;
		return $this;
	}

}
