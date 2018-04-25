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


class UserFieldValidator extends LogErrors implements ValidatorInterface
{
  public static function validate(\stdClass $object) {

    self::$code = 1;
    self::$message = 'Validation failed';

    if (count((array)$object) !== 1)
      self::setError(15, 'field', 'Amount of fields is invalid (implementation error)');

    if (self::$countErrors > 0)
          return ['success' => false, 'log' => self::getErrors()];

    switch (key((array)$object)) {
      case 'name':
        if (!isset($object->name))
          self::setError(1, 'name', 'Not configured name field (implementation error)');

        if (self::$countErrors > 0)
          return ['success' => false, 'log' => self::getErrors()];

        if (!v::notEmpty()->validate($object->name))
          self::setError(2, 'name', 'Name cannot be blank');

        if (!v::stringType()->validate($object->name))
          self::setError(4, 'name', 'This field require type string');
        break;

      case 'rgacpf':
        if (!isset($object->rgacpf))
          self::setError(1, 'rgacpf', 'Not configured rgacpf field (implementation error)');

        if (self::$countErrors > 0)
          return ['success' => false, 'log' => self::getErrors()];

        if (!v::notEmpty()->validate($object->rgacpf))
          self::setError(2, 'rgacpf', 'Email cannot be blank');

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
        break;

      case 'email':
        if (!isset($object->email))
          self::setError(1, 'email', 'Not configured email field (implementation error)');

        if (!v::notEmpty()->validate($object->email))
          self::setError(2, 'email', 'Subject cannot be blank');

        if (!v::email()->validate($object->email))
          self::setError(4, 'email', 'Invalid e-mail address');
        break;

      default:
        self::setError(16, 'field', 'Field not found');
        break;
    }

    return self::$countErrors > 0? ['success' => false, 'log' => self::getErrors()]: ['success' => true, 'log' => []];
  }
}
