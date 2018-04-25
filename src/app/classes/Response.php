<?php
/**
 *
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues/
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


class Response
{
  public static function OK()
  {
    header ('HTTP/1.1 200 OK');
    header ("Expires: ".gmdate("D, d M Y H:i:s", time())." GMT");
    header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
    header ("Cache-Control: no-cache, must-revalidate");
    header ("Pragma: no-cache");
    return 'OK';
  }

  public static function Created()
  {
    header ('HTTP/1.1 201 Created');
    return 'Created';
  }

  public static function Accepted()
  {
    header ('HTTP/1.1 202 Accepted');
    return 'Accepted';
  }

  public static function No_Content()
  {
    header ('HTTP/1.1 204 No Content');
    return 'No Content';
  }

  public static function Reset_Content()
  {
    header ('HTTP/1.1 205 Reset Content');
    return 'Reset Content';
  }

  public static function Moved_Permanently()
  {
    header('HTTP/1.1 301 Moved Permanently');
    return 'Moved Permanently';
  }

  public static function Bad_Request()
  {
    header('HTTP/1.1 400 Bad Request');
    return 'Bad Request';
  }

  public static function Unauthorized()
  {
    header('HTTP/1.1 401 Unauthorized');
    return 'Unauthorized';
  }

  public static function Forbidden()
  {
    header('HTTP/1.1 403 Forbidden');
    return Forbidden;
  }

  public static function Not_Found()
  {
    header('HTTP/1.1 404 Not Found');
    return 'Not Found';
  }

  public static function UnsupportedMediaType()
  {
    header('HTTP/1.1 415 Unsupported Media Type');
    return 'Unsupported Media Type';
  }

  public static function Internal_Server_Error()
  {
    header('HTTP/1.1 500 Internal Server Error');
    return 'Internal Server Error';
  }

  public static function png()
  {
    header('Content-Type: image/png');
  }

  public static function ContentLocation($url)
  {
    header('Content-Location: ' . $url);
  }

  public static function Entity($id)
  {
    header('Entity: '. $id);
  }

  public static function ContentLength($data)
  {
    header('Content-Lenght: ' . strlen($data));
  }

  public static function Authorization($token)
  {
    header('Authorization: Bearer ' . $token);
  }

  public static function ImagePNG()
  {
    header('Content-Type: image/png');
  }

  public static function CustomHeader($name, $value)
  {
    header('X-' . $name . ': ' . $value);
  }

  public static function json($status=200, $message = null, $data = null)
  {
    header('Content-Type: application/json; charset=utf-8');

    if ($data) {
      $response = $data;
      self::OK();
    } else {
      $response = [
        "code"    => $status,
        "message" => $message
      ];
    }

    if ($status !== 200) {
      switch ($status) {
        case 201:
          if ($data)
            self::Created();
          else
            $response["description"] = self::Created();
          break;
        case 202:
          $response["description"] = self::Accepted();
          break;
        case 204:
          $response["description"] = self::No_Content();
          break;
        case 205:
          $response["description"] = self::Reset_Content();
          break;
        case 301:
          $response["description"] = self::Moved_Permanently();
          break;
        case 400:
          if ($data)
            self::Bad_Request();
          else
            $response["description"] = self::Bad_Request();
          break;
        case 401:
          if ($data)
            self::Unauthorized();
          else
            $response["description"] = self::Unauthorized();
          break;
        case 403:
          $response["description"] = self::Forbidden();
          break;
        case 404:
          $response["description"] = self::Not_Found();
          break;
        case 415:
          $response["description"] = self::UnsupportedMediaType();
          break;
        case 500:
          $response["description"] = self::Internal_Server_Error();
          break;
      }
    }

    $pretty = isset($_GET['pretty']) && $_GET['pretty'] === 'true'? JSON_PRETTY_PRINT: null;

    $response = json_encode($response, $pretty);

    self::ContentLength($response);

    return $response;
  }
}
