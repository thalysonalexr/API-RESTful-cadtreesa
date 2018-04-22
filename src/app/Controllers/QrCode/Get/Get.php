<?php
/**
 * Create a qrcode image by url
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Get
 */

namespace Cadtreesa\Controllers\QrCode\Get;


use Respect\Rest\Routable;
use Cadtreesa\Validation\URLValidator;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;


class Get implements Routable
{
  public function get()
  {
    $validate = (object) URLValidator::validate((object) $_GET);

    if ($validate->success) {
      try {
        \PHPQRCode\QRcode::png($_GET['url'], realpath( __DIR__ ) . "/tmp/qrcode.png", 'L', 10, 1);

        $img = imagecreatefrompng(realpath( __DIR__ ) . "/tmp/qrcode.png");

        imagepng($img);
        imagedestroy($img);

        Response::ImagePNG();
        Response::json(200, 'OK');
        return;
      } catch (\Exception $e) {
         Response::json(500, m::get('*', 500, 'create_qr'));
      }
    }
    return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);
  }
}
