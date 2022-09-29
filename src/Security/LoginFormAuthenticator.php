<?php

namespace App\Security;

use App\Utils\Constants;
use App\Utils\Exception\InvalidLoginRequestException;
use App\Utils\Exception\InvalidUsernameException;
use App\Utils\Objects\User\LoginRequest;
use App\Security\User;
use App\Utils\Request\Auth\LoginParameters;
use App\Utils\Services\Auth\AuthServiceInterface;
use App\Utils\Services\User\UserServiceInterface;
use App\Utils\Traits\UtilsService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Throwable;
use Exception;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use UtilsService;

    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app.login';

    /**
     * @var AuthServiceInterface
     */
    private $authService;

    /**
     * @var UserServiceInterface
     */
    private $userService;

    /**
     * @param AuthServiceInterface $authService
     * @param UserServiceInterface $userService
     */
    public function __construct(private UrlGeneratorInterface $urlGenerator, AuthServiceInterface $authService, UserServiceInterface $userService)
    {
        $this->authService = $authService;
        $this->userService = $userService;
    }

    public function authenticate(Request $request): Passport
    {
        /** @var LoginRequest $requestParameters */
        $requestParameters = self::parseObjectToType($request->request->all(), LoginRequest::class);
        $validationViolations = $this->validator->validate($requestParameters);
        if ($validationViolations->count() > 0) {
            throw new InvalidLoginRequestException($validationViolations);
        }
        $userBadge = new UserBadge($requestParameters->getUsername(), function ($userIdentifier) {
            return self::fetchUser($userIdentifier);
        });

        $credentialsBadge = new CustomCredentials(function ($credentials, User $user) {
            return self::checkCredentials($credentials, $user);
        }, $requestParameters->getPassword());
        return new Passport(
            new UserBadge("abcd@efgh.lv", function (string $userIdentifier) {
                return new User('abc','efg','hij','ROLE_USER', 'abcdefg');
            }),
            new CustomCredentials(function() {return true;},'abcdefg')
        );
        return new Passport($userBadge, $credentialsBadge);
    }

    public function supports(Request $request): bool
    {
        return ($request->attributes->get('_route') === self::LOGIN_ROUTE && $request->isMethod('POST'));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new JsonResponse(self::buildClientResponse($token->getUser()));
    }

    /**
     * @throws Exception
     */
    private function fetchUser(string $username): User
    {
        try {
            $userResponse = $this->userService->getMockUser($username);

            return self::createLoggedUser($userResponse);

        } catch (Throwable $exception) {
            throw new InvalidUsernameException("Utente non trovato", Constants::HTTP_NOT_FOUND);
        }
    }

    private function checkCredentials(string $credentials, User $user): bool
    {
        try {

            $parameters = (new LoginParameters())
                ->setUsername($user->getUserIdentifier())
                ->setPassword($credentials);

            $this->authService->validateCredentials($parameters);

            return true;

        } catch (Throwable $exception) {
            throw new BadCredentialsException("Credenziali errate.", Constants::HTTP_NOT_FOUND);
        }
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        if ( $exception instanceof InvalidLoginRequestException ) {
            return new JsonResponse(
                self::buildClientResponseOnError($exception->getCode(), $exception->getMessage(), $exception->getFormattedErrors()),
                Constants::HTTP_BAD_REQUEST
            );
        }

        if ($exception instanceof InvalidUsernameException || $exception instanceof BadCredentialsException) {
            $response = self::buildClientResponseOnError($exception->getCode(), "Credenziali errate.");
            return new JsonResponse($response, Constants::HTTP_BAD_REQUEST);
        }

        $response = self::buildClientResponseOnError($exception->getCode(), "Errore durante la login, riprovare.");
        return new JsonResponse($response, Constants::HTTP_SERVER_ERROR);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}
