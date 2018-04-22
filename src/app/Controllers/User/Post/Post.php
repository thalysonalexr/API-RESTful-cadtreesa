<?php
/**
 * Register a user by POST
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Post
 */

namespace Cadtreesa\Controllers\User\Post;


use Cadtreesa\classes\Response;
use Cadtreesa\classes\Password;
use Cadtreesa\classes\Json;
use Cadtreesa\classes\Message as m;
use Cadtreesa\Validation\UserValidator;
use Cadtreesa\Models\DAO\User;
use Respect\Rest\Routable;


class Post implements Routable
{
  public function post()
  {
    $data = Json::verify();
    $validate = (object) UserValidator::validate($data);

    if ($validate->success) {
      $data->password = Password::hash($data->password);
      $data->hash     = hash("sha256", $data->rgacpf + time()); 
      $data->type     = strlen($data->rgacpf) == 12? "STD": "TCR";
      $data->status   = $data->type == "STD"? 1: 0;
      $data->created  = date("Y-m-d H:i:s");

      return User::register($data);
    }
    return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);
  }
}
