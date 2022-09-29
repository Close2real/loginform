<?php

namespace App\Utils\Traits;

use App\Utils\Constants;
use App\Utils\Exception\ServiceError;
use App\Utils\Request\HttpRequest\HttpRequestParameters;
use App\Utils\Response\_Api\ApiErrorResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use Psr\Http\Message\ResponseInterface;
use Exception;

trait HttpUtils
{
    use UtilsService;

    /**
     * @var ClientInterface
     */
    protected $httpClient;

    /**
     * @param ClientInterface $guzzleHttp
     */
    public function __construct(
        ClientInterface       $guzzleHttp
    )
    {
        $this->httpClient = $guzzleHttp;

        self::configure();
    }

    protected function configure()
    {
//        $this->apiBase = $this->parameters->get('base_api');
//        $this->wso2Base = $this->parameters->get('base_wso2');
//        $this->esbSj3Base = $this->parameters->get('base_sj3_esb');
//        $this->serviceSj3Base = $this->parameters->get('base_sj3_service');
//        $this->jobId = $this->parameters->get('job_id');
//        $this->projectId = $this->parameters->get('project_id');
//        $this->clientId = $this->parameters->get('cd_client');
    }

	/**
	 * Throws ServiceError if the api response cannot be parsed and returns a GenericResponse instead
	 * @param mixed $response
	 * @param int|string|null $customCode
	 * @return void
	 * @throws ServiceError
	 */
	protected function validateApiResponse($response, $customCode = null)
	{
		if ($response instanceof ApiErrorResponse) {
			throw new ServiceError($response->getMessage(), $customCode, $response->getCode() ?? $response->getHttpStatusCode());
		}
	}

    /**
     * @param HttpRequestParameters $httpRequest
     * @return Exception|RequestException|Response|ResponseInterface|null
     * @throws GuzzleException
     */
    protected function get(HttpRequestParameters $httpRequest): ?Response
    {
        $httpRequest->setHttpMethod(Constants::HTTP_GET);
        $httpRequest->setParameters(null);

        return $this->executeHttpRequest($httpRequest);
    }

    /**
     * @param HttpRequestParameters $httpRequest
     * @return Exception|RequestException|Response|ResponseInterface|null
     * @throws GuzzleException
     */
    protected function post(HttpRequestParameters $httpRequest): ?Response
    {
        $httpRequest->setHttpMethod(Constants::HTTP_POST);

        return $this->executeHttpRequest($httpRequest);
    }

    /**
     * @param HttpRequestParameters $httpRequest
     * @return Exception|RequestException|Response|ResponseInterface|null
     * @throws GuzzleException
     */
    protected function put(HttpRequestParameters $httpRequest): ?Response
    {
        $httpRequest->setHttpMethod(Constants::HTTP_PUT);

        return $this->executeHttpRequest($httpRequest);
    }

    /**
     * @param HttpRequestParameters $httpRequest
     * @return Exception|RequestException|Response|ResponseInterface|null
     * @throws GuzzleException
     */
    protected function patch(HttpRequestParameters $httpRequest): ?Response
    {
        $httpRequest->setHttpMethod(Constants::HTTP_PATCH);

        return $this->executeHttpRequest($httpRequest);
    }

    /**
     * @param HttpRequestParameters $httpRequest
     * @return Exception|RequestException|Response|ResponseInterface|null
     * @throws GuzzleException
     */
    protected function delete(HttpRequestParameters $httpRequest): ?Response
    {
        $httpRequest->setHttpMethod(Constants::HTTP_DELETE);

        return $this->executeHttpRequest($httpRequest);
    }

    /**
     * @param HttpRequestParameters $httpRequest
     * @return Exception|RequestException|ResponseInterface|null
     * @throws GuzzleException
     * @throws Exception
     */
    private function executeHttpRequest(HttpRequestParameters $httpRequest): ?Response
    {
        try {
            $httpRequest->setUri(trim($httpRequest->getUri()));
            $httpRequest->getHeaders()->set('Content-Type', 'application/json');
            $httpRequest->getHeaders()->set(
                Constants::APPLICATION_LANGUAGE_PARAMETER_NAME,
                ($_COOKIE[Constants::APPLICATION_LANGUAGE_COOKIE_NAME] ?? Constants::DEFAULT_APPLICATION_LANGUAGE)
            );

            if (false === $httpRequest->isExternalUri())
                $httpRequest->setUri($this->apiBase . $httpRequest->getUri());

            $this->logger->logInfo(
                sprintf(
                    "REQUEST - %s | METHOD - %s | PARAMETERS - %s | HEADERS - %s",
                    $httpRequest->getUri(),
                    $httpRequest->getHttpMethod(),
                    $this->parseParameters($httpRequest->getParameters()),
                    $this->parseParameters($httpRequest->getHeaders()->toArray())
                )
            );

            $request = new Request(
                $httpRequest->getHttpMethod(),
                $httpRequest->getUri(),
                $httpRequest->getHeaders()->toArray(),
                $this->parseParameters($httpRequest->getParameters(), $httpRequest->getHttpMethod())
            );

            if (!is_null($httpRequest->getHttpRequestCert()->getCertificate())) {
                $requestOptions = [RequestOptions::CERT => [
                    $httpRequest->getHttpRequestCert()->getCertificate(),
                    $httpRequest->getHttpRequestCert()->getPassword()
                ]
                ];

                $response = $this->httpClient->send($request, $requestOptions);
            } else {
                $response = $this->httpClient->send($request);
            }

            $this->logger->logInfo(
                sprintf(
                    "RESPONSE - %s - %s",
                    $response->getStatusCode(),
                    $response->getBody()->getContents()
                )
            );

            return $response;

        } catch (RequestException $e) {

            $this->logger->logServiceError($e);

            return $this->exceptionTypeResponse($e);

        }
    }

    /**
     * @param array|object|mixed $parameters
     * @param null $method
     * @return string|null
     */
    private function parseParameters($parameters, $method = null): ?string
    {
        if (is_string($parameters)) {
            return $parameters;
        }

        if (!is_null($method) && $method !== Constants::HTTP_GET && empty($parameters)) {
            return '{}';
        }

        return !is_null($parameters) ? $this->serializer->serialize($parameters, Constants::JSON_TYPE) : null;
    }

    /**
     * @param string $string
     * @return bool
     */
    private function isJson(string $string): bool
    {
        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * @param Response|null $response
     * @param string $type
     * @param bool $isStandardResponse
     * @param bool $parseNonStandardResponse
     * @return ApiErrorResponse|mixed|null
     */
    protected function parseResponse(?Response $response, string $type, ?bool $isStandardResponse = true, bool $parseNonStandardResponse = true)
    {
        $dataSerialized = null;

        /**
         * empty or non valid json response, return ApiErrorResponse
         */
        if (is_null($response) || !$this->isJson((string)$response->getBody())) {
            return (new ApiErrorResponse())
                ->setHttpStatusCode($response->getStatusCode())
                ->setCode(Constants::HTTP_ACCEPTED)
                ->setMessage("General errors : The Response is null or the request body/content hasn't a valid JSON.");
        }

        /**
         * http status code different from 200, return ApiErrorResponse
         */
        if ($response->getStatusCode() !== Constants::HTTP_OK) {
            try {

                /** @var ApiErrorResponse $errorResponse */
                $errorResponse = $this->serializer->deserialize((string)$response->getBody(), ApiErrorResponse::getClassName(), Constants::JSON_TYPE);
                $errorResponse->setHttpStatusCode($response->getStatusCode());

                return $errorResponse;
            } catch (Exception $e) {
                $this->logger->logError($e->getMessage());
            }
        }

        $responseAsObject = json_decode((string)$response->getBody());

        if (!$isStandardResponse && !$parseNonStandardResponse) {
            return $responseAsObject;
        }

        if ($isStandardResponse && $responseAsObject->code !== Constants::HTTP_OK) {
            return (new ApiErrorResponse())
                ->setHttpStatusCode($response->getStatusCode())
                ->setMessage($responseAsObject->message ?? '')
                ->setCode($responseAsObject->code ?? Constants::HTTP_SERVER_ERROR);
        }

        try {
            $dataSerialized = $this->serializer->deserialize((string)$response->getBody(), $type, Constants::JSON_TYPE);
        } catch (Exception $e) {
            $this->logger->logError($e->getMessage());
        }

        return $dataSerialized;
    }
}
