<?php
/**
 * Class responsible for validating data entries in JSON format
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers
 */

namespace Cadtreesa\classes;


use Cadtreesa\classes\Message as m;
use Respect\Validation\Validator;


class Json
{
  public static function verify()
  {
    $data = file_get_contents('php://input');

    if (Validator::json()->validate($data) && isset(apache_request_headers()['Content-Type']) && Validator::equals(apache_request_headers()['Content-Type'])->validate('application/json'))
      return (object) json_decode($data, true);

    echo Response::json(415, m::get('*', 415, 'unsupported_media'));
    die();
  }
}
