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


class EmailValidator extends LogErrors implements ValidatorInterface
{
	public static function validate(\stdClass $object) {

		self::$code = 1;
		self::$message = 'Validation failed';

		if (!isset($object->email))
			self::setError(1, 'email', 'Not configured email field (implementation error)');

		if (self::$countErrors > 0)
			return ['success' => false, 'log' => self::getErrors()];

		if (!v::notEmpty()->validate($object->email))
			self::setError(2, 'email', 'Subject cannot be blank');

		if (!v::email()->validate($object->email))
			self::setError(4, 'email', 'Invalid e-mail address');

		return self::$countErrors > 0? ['success' => false, 'log' => self::getErrors()]: ['success' => true];
    }
}