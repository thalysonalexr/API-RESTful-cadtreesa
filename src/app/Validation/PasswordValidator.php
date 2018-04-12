<?php
/**
 *
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues/
 *
 * @version 1.0
 * @package Validation
 */

namespace Cadtreesa\Validation;


use Cadtreesa\Validation\LogErrors;
use Respect\Validation\Validator as v;


class PasswordValidator extends LogErrors implements ValidatorInterface
{
	public static function validate(\stdClass $object) {

		self::$code = 1;
		self::$message = 'Validation failed';

		if (!isset($object->password))
			self::setError(1, 'password', 'Not configured password field (implementation error)');

		if (self::$countErrors > 0)
			return ['success' => false, 'log' => self::getErrors()];

		if (!v::notEmpty()->validate($object->password))
			self::setError(2, 'password', 'Message cannot be blank');

		if (!v::length(5, 255)->validate($object->password))
			self::setError(5, 'password', 'This field require length 5 a 255 characters');

		return self::$countErrors > 0? ['success' => false, 'log' => self::getErrors()]: ['success' => true];
    }
}