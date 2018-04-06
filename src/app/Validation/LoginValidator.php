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


class LoginValidator extends LogErrors implements ValidatorInterface
{
	public static function validate(\stdClass $object) {

		self::$code = 1;
		self::$message = 'Validation failed';

		if (!isset($object->email))
			 self::setError(1, 'email', 'Not configured email field');

		if (!isset($object->password))
			self::setError(1, 'password', 'Not configured password field');

		if (!v::notEmpty()->validate($object->email))
			self::setError(2, 'email', 'Email cannot be blank');

		if (!v::notEmpty()->validate($object->password))
			self::setError(2, 'password', 'Password cannot be blank');

		if (!v::email()->validate($object->email))
			self::setError(3, 'email', 'Invalid e-mail address');

		if (!v::stringType()->validate($object->password))
			self::setError(4, 'password', 'This field require type string');

		if (!v::length(1, 100)->validate($object->email))
			self::setError(5, 'email', 'This field require length 1 a 100 characters');

		if (!v::length(1, 255)->validate($object->password))
			self::setError(5, 'password', 'This field require length 1 a 255 characters');

		return self::$countErrors > 0? ['success' => false, 'log' => self::getErrors()]: ['success' => true];
    }
}