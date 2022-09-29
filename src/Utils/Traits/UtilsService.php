<?php

namespace App\Utils\Traits;

use App\Security\User;
use App\Utils\Constants;
use App\Utils\Exception\InvalidUsernameException;
use App\Utils\Objects\Pagination\Pagination;
use App\Utils\Objects\User\Mock\UserExtraData;
use App\Utils\Response\_Client\ClientResponse;
use App\Utils\Response\User\MockUserResponse;
use App\Utils\Services\SystemLog\LogServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Twig\Environment;

trait UtilsService
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var ParameterBagInterface
     */
    protected $parameters;

    /**
     * @var LogServiceInterface
     */
    protected $logger;

    /**
     * @var ValidatorInterface
     */
    protected $validator = null;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Security
     */
    protected $security;

    /**
     * @var Environment
     */
    protected $twig;

    /**
     * @param MockUserResponse $mockUserResponse
     * @return User
     * @throws Exception
     */
    protected function createLoggedUser(MockUserResponse $mockUserResponse): User
    {
        $assignedRole = self::mapMockUserRoles($mockUserResponse->getUserExtraData());

        if (!in_array($assignedRole, Constants::ALLOWED_AUTH_ROLES)) {
            throw new InvalidUsernameException("Utente non riconosciuto");
        }

        return new User(
            $mockUserResponse->getUserData()->getUsername(),
            $mockUserResponse->getUserData()->getName(),
            $mockUserResponse->getUserData()->getSurname(),
            $assignedRole
        );
    }

    /**
     * @throws Exception
     */
    protected function mapMockUserRoles(?ArrayCollection $userExtraData = null): string
    {

        if ($userExtraData === null || $userExtraData->isEmpty()) {
            return Constants::ROLE_USER;
        }

        $javaRoleMappings = Constants::JAVA_ROLES_MAPPING;

        $javaRole = null;

        foreach ($userExtraData->getIterator() as $extraData) {
            /** @var $extraData UserExtraData */
            if (strtoupper($extraData->getName()) === 'ROLE' && isset($javaRoleMappings[$extraData->getValue()])) {
                $javaRole = $javaRoleMappings[$extraData->getValue()];
                break;
            }
        }

        if (is_null($javaRole)) {
            return Constants::ROLE_USER;
        }

        return $javaRole;
    }

    /**
     * @param array $parameters
     * @return array|null
     */
    protected function toArray(array $parameters): ?array
    {
        return $this->serializer->toArray($parameters);
    }

    /**
     * @param $parameters
     * @return string
     */
    protected function objectToJSON($parameters): string
    {
        return $this->serializer->serialize($parameters, Constants::JSON_TYPE);
    }

    /**
     * @param $parameters
     * @param string $type
     * @return mixed
     */
    protected function parseObjectToType($parameters, string $type = Constants::ARRAY_TYPE)
    {
        $serialized = $this->serializer->serialize($parameters, Constants::JSON_TYPE);
        return $this->serializer->deserialize($serialized, $type, Constants::JSON_TYPE);
    }

    /**
     * @param $content
     * @param string $type
     * @return mixed
     */
    protected function parseStringToType($content, string $type)
    {
        return $this->serializer->deserialize((string)$content, $type, Constants::JSON_TYPE);
    }

    /**
     * @param mixed $payload
     * @param int $statusCode
     * @param bool $hasError
     * @param string|null $errorMessage
     * @param Pagination|null $pagination
     * @param string|null $locale
     * @return object
     */
    protected function buildClientResponse($payload = null, int $statusCode = Constants::HTTP_OK, bool $hasError = false, ?string $errorMessage = null, Pagination $pagination = null, ?string $locale = Constants::DEFAULT_APPLICATION_LANGUAGE): object
    {
        $clientResponse = (new ClientResponse())
            ->setData($payload)
            ->setCode($statusCode)
            ->setHasError($hasError)
            ->setErrorMessage($errorMessage)
            ->setLocale($locale);

        if ($pagination !== null) {
            $clientResponse->setPagination($pagination);
        }

        $serialized = $this->serializer->serialize($clientResponse, Constants::JSON_TYPE);

        return json_decode($serialized);
    }

    protected function buildClientPaginatedResponse($payload = null, Pagination $pagination = null, int $statusCode = Constants::HTTP_OK, bool $hasError = false, ?string $errorMessage = null, ?string $locale = Constants::DEFAULT_APPLICATION_LANGUAGE): object
    {
        return $this->buildClientResponse($payload, $statusCode, $hasError, $errorMessage, $pagination, $locale);
    }

    /**
     * @param int $statusCode
     * @param string|null $errorMessage
     * @param null $payload
     * @param string|null $locale
     * @return object
     */
    protected function buildClientResponseOnError(int $statusCode = Constants::HTTP_BAD_REQUEST, ?string $errorMessage = null, $payload = null, ?string $locale = Constants::DEFAULT_APPLICATION_LANGUAGE): object
    {
        return $this->buildClientResponse($payload, $statusCode, true, $errorMessage, null, $locale);
    }

    /**
     * @return SerializerInterface
     */
    public function getSerializer(): SerializerInterface
    {
        return $this->serializer;
    }

    /**
     * @required
     * @param SerializerInterface $serializer
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * @return ParameterBagInterface
     */
    public function getParameters(): ParameterBagInterface
    {
        return $this->parameters;
    }

    /**
     * @required
     * @param ParameterBagInterface $parameters
     */
    public function setParameters(ParameterBagInterface $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * @return LogServiceInterface
     */
    public function getLogger(): LogServiceInterface
    {
        return $this->logger;
    }

    /**
     * @required
     * @param LogServiceInterface $logger
     */
    public function setLogger(LogServiceInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return ValidatorInterface|null
     */
    public function getValidator(): ?ValidatorInterface
    {
        return $this->validator;
    }

    /**
     * @required
     * @param ValidatorInterface|null $validator
     */
    public function setValidator(?ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @return RouterInterface
     */
    public function getRouter(): RouterInterface
    {
        return $this->router;
    }

    /**
     * @required
     * @param RouterInterface $router
     */
    public function setRouter(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return Environment
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }

    /**
     * @required
     * @param Environment $twig
     */
    public function setTwig(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return Security
     */
    public function getSecurity(): Security
    {
        return $this->security;
    }

    /**
     * @required
     * @param Security $security
     */
    public function setSecurity(Security $security)
    {
        $this->security = $security;
    }

}