<?php
/**
 * Request password recovery by POST
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Post
 */

namespace Cadtreesa\Controllers\User\Post;


use Cadtreesa\classes\Auth;
use Cadtreesa\classes\Database;
use Cadtreesa\classes\Json;
use Cadtreesa\classes\Mail;
use Cadtreesa\classes\Message as m;
use Cadtreesa\classes\Response;
use Cadtreesa\Models\DAO\User;
use Cadtreesa\Validation\EmailValidator;
use Respect\Rest\Routable;


class PostForgotPassword implements Routable
{
  public function post()
  {
    $data = Json::verify();
    $validate = (object) EmailValidator::validate($data);

    if ($validate->success) {

      $r = Database::find('USERS', 'email', $data->email);

      if (!$r->success)
        return Response::json(500, m::get('*', 500, 'error_send'));

      if (!$r->data)
        return Response::json(404, m::get('get', 404));

      $user = $r->data;

      $options = [
        "expiration_sec" => 10800,
        "iss" => APP_ENVIRONMENT['TOKEN']['TOKEN_ISS'],
        "userdata" => [
          "id" => $user->id,
          "name" => $user->name,
          "type" => $user->type,
          "hash" => $user->hash,
        ],
      ];

      if (Mail::send($data->email,
      [
        "from" => $r->data->name,
        "to" => APP_ENVIRONMENT["MAIL"]["MAIL_TO"],
        "subject" => 'New password for Login in Cadtreesa',
        "message" => 'Access this link to change your password within 3 hours: ' .
        $data->url . '/change_password/' . Auth::encode($options),
      ])) {
        return Response::json(202, m::get('*', 202, 'forgot_password'));
      }
      return Response::json(500, m::get('*', 500, 'error_send'));
    }
    return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);
  }
}
