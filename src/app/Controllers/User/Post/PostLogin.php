<?php
/**
 * Sign in by user by POST
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Post
 */

namespace Cadtreesa\Controllers\User\Post;


use Cadtreesa\classes\Auth;
use Cadtreesa\classes\Login;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;
use Cadtreesa\classes\Json;
use Cadtreesa\Validation\LoginValidator;
use Respect\Rest\Routable;
use Respect\Validation\Validator;


class PostLogin implements Routable
{
    public function post()
    {
        $data = Json::verify();
        $validate = (object) LoginValidator::validate($data);

        if ($validate->success) {

            $auth = (object) Login::login($data->email, $data->password);

            if ($auth->auth) {

                $token = Auth::createToken([
                    "id"   => $auth->data["id"],
                    "name" => $auth->data["name"],
                    "type" => $auth->data["type"],
                    "hash" => $auth->data["hash"],
                    "id_log" => $auth->data["id_log"]
                ]);

                Response::Authorization($token);

                return Response::json(200, "OK", [
                    "login" => true,
                    "access_token" => $token
                ]);
            }
            return Response::json(401, m::get('*', 401, 'unauthorized'));
        }
        return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);
    }
}