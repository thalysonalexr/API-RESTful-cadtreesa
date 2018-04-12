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


class MailValidator extends LogErrors implements ValidatorInterface
{
	public static function validate(\stdClass $object) {

		self::$code = 1;
		self::$message = 'Validation failed';

		if (!isset($object->name))
			self::setError(1, 'name', 'Not configured name field (implementation error)');

		if (!isset($object->email))
			self::setError(1, 'email', 'Not configured email field (implementation error)');

		if (!isset($object->subject))
			self::setError(1, 'subject', 'Not configured subject field (implementation error)');

		if (!isset($object->message))
			self::setError(1, 'message', 'Not configured message field (implementation error)');

		if (self::$countErrors > 0)
			return ['success' => false, 'log' => self::getErrors()];
		
		if (!v::notEmpty()->validate($object->name))
			self::setError(2, 'name', 'Name cannot be blank');

		if (!v::notEmpty()->validate($object->email))
			self::setError(2, 'email', 'Email cannot be blank');

		if (!v::notEmpty()->validate($object->subject))
			self::setError(2, 'subject', 'Subject cannot be blank');

		if (!v::notEmpty()->validate($object->message))
			self::setError(2, 'message', 'Message cannot be blank');

		if (!v::stringType()->validate($object->name))
			self::setError(4, 'name', 'This field require type string');

		if (!v::email()->validate($object->email))
			self::setError(3, 'email', 'Invalid e-mail address');

		if (!v::stringType()->validate($object->subject))
			self::setError(4, 'subject', 'This field require type string');

		if (!v::stringType()->validate($object->message))
			self::setError(4, 'message', 'This field require type string');

		if (!v::length(0, 255)->validate($object->name))
			self::setError(5, 'name', 'This field require length 0 a 255 characters');

		if (!v::length(0, 100)->validate($object->email))
			self::setError(5, 'email', 'This field require length 0 a 100 characters');

		if (!v::length(0, 255)->validate($object->subject))
			self::setError(5, 'subject', 'This field require length 0 a 255 characters');

		if (!v::length(0, 1500)->validate($object->message))
			self::setError(5, 'message', 'This field require length 0 a 1500 characters');

		return self::$countErrors > 0? ['success' => false, 'log' => self::getErrors()]: ['success' => true];
    }
}