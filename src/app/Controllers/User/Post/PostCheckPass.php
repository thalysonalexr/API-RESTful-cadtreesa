<?php
/**
 * Check the password user
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Post
 */

namespace Cadtreesa\Controllers\User\Post;


use Cadtreesa\classes\Auth;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Password;
use Cadtreesa\classes\Json;
use Cadtreesa\classes\Message as m;
use Cadtreesa\classes\Database;
use Cadtreesa\classes\JWTWrapper;
use Cadtreesa\Validation\PasswordValidator;
use Respect\Rest\Routable;


class PostCheckPass implements Routable
{
  public function post()
  {
    $data = Json::verify();
    $validate = (object) PasswordValidator::validate($data);

    if ($validate->success) {

      $id = JWTWrapper::decode(Auth::getAuthorization())->data->id;

      $r = Database::find('USERS', 'id', $id);

      if (Password::verify($data->password, $r->data->password))
        return Response::json(200, 'OK', ['check' => true]);

      return Response::json(401, 'unauthorized', ['check' => false]);
    }
    return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);
  }
}
