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
use Cadtreesa\classes\Database;
use Cadtreesa\Validation\LogErrors;
use Cadtreesa\Validation\UserValidator;
use Cadtreesa\Models\DAO\User;
use Respect\Rest\Routable;


class Post implements Routable
{
  public function post()
  {
    $data = Json::verify();
    $validate = (object) UserValidator::validate($data);

    LogErrors::$code = 1;
    LogErrors::$message = 'Validation failed';

    // Fields Unique Keys | rgacpf | email

    if (Database::find('USERS', 'rgacpf', $data->rgacpf)->data)
      LogErrors::setError(12, 'rgacpf', 'The rgacpf field is already registered');

    if (Database::find('USERS', 'email', $data->email)->data)
      LogErrors::setError(13, 'email', 'The email field is already registered');

    if (LogErrors::$countErrors > 0)
      $validate->log = array_merge($validate->log, LogErrors::getErrors());

    if ($validate->success && LogErrors::$countErrors <= 0) {
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
