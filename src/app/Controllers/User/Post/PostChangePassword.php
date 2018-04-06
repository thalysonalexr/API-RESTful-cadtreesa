<?php
/**
 * Change user password by POST
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Post
 */

namespace Cadtreesa\Controllers\User\Post;


use Cadtreesa\classes\JWTWrapper;
use Cadtreesa\classes\Json;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;
use Cadtreesa\classes\Password;
use Cadtreesa\Models\DAO\User;
use Cadtreesa\Validation\PasswordValidator;
use Respect\Rest\Routable;


class PostChangePassword implements Routable
{
	public function post()
	{
		if (isset($_GET['token']) && !empty($_GET['token'])) {

			$token = JWTWrapper::decode($_GET['token']);

			if ($token) {
				$data = Json::verify();
				$validate = (object) PasswordValidator::validate($data);
			
				if ($validate->success) {
					$data->password = Password::hash($data->password);
					return User::changePassword($token->data->id, $data->password);
				}
				return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);
			}
			return Response::json(500, m::get('*', 500, 'error'));
		}
		return Response::json(404, m::get('*', 404, 'not_found'));
	}
}