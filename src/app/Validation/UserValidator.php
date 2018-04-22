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
use Cadtreesa\classes\Database;
use Respect\Validation\Validator as v;


class UserValidator extends LogErrors implements ValidatorInterface
{
  public static function validate(\stdClass $object) {

    self::$code = 1;
    self::$message = 'Validation failed';

    if (!isset($object->name))
      self::setError(1, 'name', 'Not configured name field (implementation error)');

    if (!isset($object->rgacpf))
      self::setError(1, 'rgacpf', 'Not configured rgacpf field (implementation error)');

    if (!isset($object->email))
      self::setError(1, 'email', 'Not configured email field (implementation error)');

    if (self::$countErrors > 0)
      return ['success' => false, 'log' => self::getErrors()];

    if (!v::notEmpty()->validate($object->name))
      self::setError(2, 'name', 'Name cannot be blank');

    if (!v::notEmpty()->validate($object->rgacpf))
      self::setError(2, 'rgacpf', 'Email cannot be blank');

    if (!v::notEmpty()->validate($object->email))
      self::setError(2, 'email', 'Subject cannot be blank');

    if (!v::stringType()->validate($object->name))
      self::setError(4, 'name', 'This field require type string');

    if (!v::email()->validate($object->email))
      self::setError(4, 'email', 'Invalid e-mail address');

    if (strlen($object->rgacpf) === 11) {
      if (!v::cpf()->validate($object->rgacpf)) {
        self::setError(6, 'rgacpf', 'Invalid CPF');
      }
    } elseif (strlen($object->rgacpf) === 12) {
      $object->rgacpf = filter_var($object->rgacpf, FILTER_SANITIZE_NUMBER_INT);
      if (!v::intType()->positive()->validate((int)$object->rgacpf) || strlen($object->rgacpf) != 12) {
        self::setError(7, 'rgacpf', 'Invalid RGA');
      }
    } else {
      self::setError(8, 'rgacpf', 'This field require RGA or CPF');
    }

    // Fields Unique Keys | rgacpf | email

    if (Database::find('USERS', 'rgacpf', $object->rgacpf)->data)
      self::setError(12, 'rgacpf', 'The rgacpf field is already registered');

    if (Database::find('USERS', 'email', $object->email)->data)
      self::setError(13, 'email', 'The email field is already registered');

    return self::$countErrors > 0? ['success' => false, 'log' => self::getErrors()]: ['success' => true];
  }
}
