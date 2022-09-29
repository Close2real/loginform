<?php

namespace App\Utils\Exception;

use Exception;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;

Trait InvalidForm
{
	/**
	 * @Type("Symfony\Component\Validator\ConstraintViolationList")
	 * @var ConstraintViolationList|null
	 */
	private $violations;

	public function getViolations(): ?ConstraintViolationList
	{
		return $this->violations;
	}

	/**
	 * @throws Exception
	 */
	public function getFormattedErrors(): array
	{
		if ( $this->violations === null ) {
			return [];
		}

		$errors = [];

		foreach ($this->violations->getIterator() as $violation) {
			/** @var ConstraintViolationInterface $violation */

			$errors[$violation->getPropertyPath()] = $violation->getMessage();
		}

		return $errors;
	}
}