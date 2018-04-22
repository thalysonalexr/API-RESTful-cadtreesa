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


class URLValidator extends LogErrors implements ValidatorInterface
{
  public static function validate(\stdClass $object) {

    self::$code = 1;
    self::$message = 'Validation failed';

    if (!isset($object->url))
      self::setError(1, 'query parameter {url}', 'Not configured parameter url (implementation error)');

    if (self::$countErrors > 0)
      return ['success' => false, 'log' => self::getErrors()];

    if (!filter_var($object->url, FILTER_VALIDATE_URL))
      self::setError(14, 'query parameter {url}', 'This URL is invalid');

    return self::$countErrors > 0? ['success' => false, 'log' => self::getErrors()]: ['success' => true];
  }
}
