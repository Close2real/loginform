<?php

namespace App\Utils\Exception;

use App\Utils\Constants;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Validator\ConstraintViolationList;
use Throwable;

class InvalidLoginRequestException extends AuthenticationException
{
	use InvalidForm;

	/**
	 * @inheritDoc
	 */
	public function __construct(?ConstraintViolationList $violations = null, ?string $message = "Form non valido", int $code = Constants::FORM_VALIDATION_ERROR_CODE, ?Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);

		$this->violations = $violations;
	}
}