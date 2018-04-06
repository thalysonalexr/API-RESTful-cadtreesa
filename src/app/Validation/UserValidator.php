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


class UserValidator extends LogErrors implements ValidatorInterface
{
	public static function validate(\stdClass $object) {

		self::$code = 1;
		self::$message = 'Validation failed';

		if (!isset($object->name))
			self::setError(1, 'name', 'Not configured name field');

		if (!isset($object->rgacpf))
			self::setError(1, 'rgacpf', 'Not configured rgacpf field');

		if (!isset($object->email))
			self::setError(1, 'email', 'Not configured email field');

		if (!isset($object->password))
			self::setError(1, 'password', 'Not configured password field');

		if (!v::notEmpty()->validate($object->name))
			self::setError(2, 'name', 'Name cannot be blank');

		if (!v::notEmpty()->validate($object->rgacpf))
			self::setError(2, 'rgacpf', 'Email cannot be blank');

		if (!v::notEmpty()->validate($object->email))
			self::setError(2, 'email', 'Subject cannot be blank');

		if (!v::notEmpty()->validate($object->password))
			self::setError(2, 'password', 'Message cannot be blank');

		if (!v::stringType()->validate($object->name))
			self::setError(4, 'name', 'This field require type string');

		if (!v::email()->validate($object->email))
			self::setError(4, 'email', 'Invalid e-mail address');

		if (!v::length(5, 255)->validate($object->password))
			self::setError(5, 'password', 'This field require length 5 a 255 characters');

		if (strlen($object->rgacpf) === 11) {
			if (!v::cpf()->validate($object->rgacpf)) {
				self::setError(6, 'rgacpf', 'Invalid CPF');
			}
		} elseif (strlen($object->rgacpf) === 12) {
			$value = filter_var($object->rgacpf, FILTER_SANITIZE_NUMBER_INT);
			if (!v::intType()->positive()->validate((int)$value)) {
				self::setError(7, 'rgacpf', 'Invalid RGA');
			}
		} else {
			self::setError(8, 'rgacpf', 'This field require RGA or CPF');
		}

		return self::$countErrors > 0? ['success' => false, 'log' => self::getErrors()]: ['success' => true];
    }
}