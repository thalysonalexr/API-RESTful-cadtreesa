<?php
/**
 * Class responsible for signing in with email and password
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


use Cadtreesa\classes\Password;
use Cadtreesa\classes\Cfg;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;
use Cadtreesa\Validation\LogErrors;
use Cadtreesa\Models\DAO\User;


class Login extends User
{
  /**
   * Do login
   *
   * @param string $email 		E-mail valid
   * @param string $password 		password valid
   */
  public static function login($email, $password)
  {
    $r = parent::find(parent::TABLE, "email", $email);

    LogErrors::$code = 2;
    LogErrors::$message = 'Not authorized';

    if ($r->success) {
      if (!$r->data) {
        LogErrors::setError(1, 'email', m::get('*', 404, 'find_user'));
        return [
          "auth" => false,
          "data" => LogErrors::getErrors()
        ];
      }
      $user = $r->data;
    }

    $log = parent::create(self::LOG, [
      "id_user" => $user->id,
      "signin_dt" => date("Y-m-d H:i:s"),
      "ip" => $_SERVER["REMOTE_ADDR"],
      "browser" => $_SERVER["HTTP_USER_AGENT"]
    ]);

    if (!$log->success) {
      echo Response::json(500, m::get('*', 500, 'error'));
      die();
    }

    if (Password::verify($password, $user->password)) {
      if (parent::update(self::LOG, ["status" => 1], ["id", $log->data])->data === 0) {
        echo Response::json(500, m::get('*', 500, 'error'));
        die();
      }

      return [
        "auth" => true,
        "data" => [
          "id"   => $user->id,
          "name" => $user->name,
          "type" => $user->type,
          "hash" => $user->hash,
          "id_log" => $log->data
        ]
      ];
    }

    LogErrors::setError(2, 'password', m::get('*', 404, 'error_pass'));
    return [
      "auth" => false,
      "data" => LogErrors::getErrors()
    ];
  }
}
