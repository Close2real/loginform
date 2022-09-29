<?php

namespace App\Utils\Request;

use App\Utils\Constants;
use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerInterface;

class Parameters
{
	/**
	 * @param SerializerInterface $serializer
	 * @param bool $keepNullValues
	 * @param bool $removeZeroIntegers
	 * @param bool $removeEmptyStrings
	 * @return array|null
	 */
	public function serializeToArray(SerializerInterface $serializer, bool $keepNullValues = false, bool $removeZeroIntegers = false, bool $removeEmptyStrings = false): ?array
	{
		$context = $keepNullValues ? (new SerializationContext())->setSerializeNull(true) : null;

		$result = $serializer->toArray($this, $context);

		/**
		 * remove 0 values
		 */
		if ($removeZeroIntegers) {
			$result = array_filter($result, function ($value) {
				return $value !== 0;
			});
		}

		/**
		 * remove empty string ""
		 */
		if ($removeEmptyStrings) {
			$result = array_filter($result, function ($value) {
				return $value !== "";
			});
		}

		foreach ($result as $paramName => $paramValue) {
		    $paramValue = str_replace([' 00:00:00', ' 23:59:59'], ['', ''], $paramValue);
			if ( in_array($paramName, Constants::ADD_FIRST_DAY_TIME) ) {
				$result[$paramName] = "$paramValue " . Constants::FIRST_DAY_TIME;
			}
			if ( in_array($paramName, Constants::ADD_LAST_DAY_TIME) ) {
				$result[$paramName] = "$paramValue " . Constants::LAST_DAY_TIME;
			}
		}

		/**
		 * trim & return
		 */
		return array_map(function ($item) {
			if (is_string($item)) {
				return trim($item);
			}
			return $item;
		}, $result);

	}

	/**
	 * @param SerializerInterface $serializer
	 * @return string
	 */
	public function toJSON(SerializerInterface $serializer): string
	{
		$serialized = $serializer->serialize($this, Constants::ARRAY_TYPE);
		return $serializer->deserialize($serialized, Constants::ARRAY_TYPE, Constants::JSON_TYPE);
	}
}