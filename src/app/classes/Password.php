<?php
/**
 * Management passwords with PHP_HASH
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues/
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


class Password
{
  /**
   * Encrypts a password with password_hash
   *
   * @param string $password password
   *
   * @return string
   */
  public static function hash($password)
  {
    $options = [
      'cost' => 12,
    ];

    return password_hash($password, PASSWORD_DEFAULT, $options);
  }

  /**
   * Verify password with hash generated in password_hash
   *
   * @param string $password password
   * @param string $hash 	   hash
   *
   * @return string
   */
  public static function verify($password, $hash)
  {
    return password_verify($password, $hash);
  }
}