<?php
/**
 * Tokens management with firebase JWTWrapper
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


use \Firebase\JWT\JWT;


class JWTWrapper
{
  /**
   * key for encryption
   *
   * @type string
   */
  const KEY = "7Fsxc2A865V6";

  /**
   * Encode token with your settings
   * 
   * @param array $options Token configuration options
   *
   * @return string Token with signature
   */
  public static function encode(array $options)
  {    
    $issuedAt = time();
    $expire = $issuedAt + $options["expiration_sec"];

    $tokenParam = [
      'iat'  => $issuedAt,
      'iss'  => $options['iss'],
      'exp'  => $expire,
      'nbf'  => $issuedAt - 1,
      'data' => $options['userdata'],
    ];
    return JWT::encode($tokenParam, JWT::sign(hash('sha256', 'cadtreesa'), self::KEY));
  }

  /**
   * Decode token
   *
   * @param string $jwt hash with signature
   *
   * @return stdClass
   */
  public static function decode($jwt)
  {
    try {
      return JWT::decode($jwt, JWT::sign(hash('sha256', 'cadtreesa'), self::KEY), ['HS256']);
    } catch (\Exception $e) {
      echo \Cadtreesa\classes\Response::json(401, $e->getMessage());
      die();
    }
  }
}
