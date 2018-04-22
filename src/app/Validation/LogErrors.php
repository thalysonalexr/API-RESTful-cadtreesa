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


class LogErrors implements \JsonSerializable
{
  public static $code;
  public static $message;
  public static $errors = [];
  public static $countErrors = 0;

  public static function setError($code, $field, $message) {
    self::$errors[] = [
      'code' => $code,
      'field' => $field,
      'message' => $message
    ];
    self::$countErrors++;
  }

  public static function getErrors() {
    return [
      'code' => self::$code,
      'message' => self::$message,
      'errors' => self::$errors
    ];
  }

  public function jsonSerialize() {
    return [
      'code' => self::$code,
      'message' => self::$message,
      'errors' => self::$errors
    ];
  }
}
