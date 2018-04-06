<?php
/**
 * Class responsible for token authorization management
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


use Cadtreesa\classes\Database;
use Cadtreesa\classes\JWTWrapper;
use Cadtreesa\classes\Message as m;
use Respect\Validation\Validator as v;


class Auth extends JWTWrapper
{
	/**
	 * Token expiration time
	 * @var
	 */
	private static $exp = APP_ENVIRONMENT["TOKEN"]["TOKEN_EXP"];
	/**
	 * Token emitter
	 * @var
	 */
	private static $iss = APP_ENVIRONMENT["TOKEN"]["TOKEN_ISS"];

	/**
	 * Allows or blocks access to the resource
	 *
	 * @param array $permission     array key value of user permissions
	 * @param mixed $self           user identifier for permission only we own resources
	 */
	public static function auth(array $permission = array("*"), $self = null)
	{
		$jwt = self::getAuthorization();

		// Atualizar o campo TIMEOUT e SIGNOUT_DT no banco de dados caso o token expire

		$data = parent::decode($jwt)->data;

		if ($data) {
			$r = Database::find('USERS', 'id', $data->id);

			// find user if registered in db
			if ($r->success) {
				if (!$r->data) {
					echo Response::json(403, m::get('*', 403, 'user_not_found'));
					die();
				}
			} else {
				echo Response::json(500, m::get('*', 500, 'error'));
				die();
			}
			// user only accesses their own information
			if (v::stringType()->validate($self)) {
				foreach ($permission as $key => $value) {
					if ($value) {
						if (!is_bool($value))
							throw new \Exception('$ Permission array values ​​must be "boolean"', 1);

						if (!v::equals($self)->validate($data->id) && v::equals($key)->validate($data->type)) {
							echo Response::json(403, m::get('*', 403, 'access'));
							die();
						}
					}
				}
			}
			// verify that the token contains the same information contained in the database
			if (!v::equals($r->data->type)->validate($data->type)) {
				echo Response::json(403, m::get('*', 403, 'user_altered'));
				die();
			}
			// allow access if you have the privilege
			if (v::contains("*")->validate($permission) || v::contains($data->type)->validate(array_keys($permission))) {
				Response::json(200, "OK");
				Response::Authorization(self::refreshToken($data));
				return;
			} else {
				echo Response::json(403, m::get('*', 403, 'access'));
				die();
			}
		}
		echo Response::json(500, m::get('*', 500, 'error_access_token')); // error in implementation
		die();
	}

	/**
	 * Create a token with data in payload
	 *
	 * @param array $data   claims | payload data
	 *
	 * @return string       Json Web Token
	 */
	public static function createToken(array $data)
	{
		return parent::encode([
			"expiration_sec" => self::$exp,
			"iss" => self::$iss,
			"userdata" => $data,
		]);
	}

	/**
	 * Creates a new token from information from an existing token
	 *
	 * @param stdClass $token   decoded token data
	 *
	 * @return string           Json Web Token
	 */
	public static function refreshToken(\stdClass $token)
	{
		$data = [
			"id" => $token->id,
			"name" => $token->name,
			"type" => $token->type,
			"hash" => $token->hash,
		];
		return self::createToken($data);
	}

	/**
	 * Get a bearer Token authorization on the apache request
	 *
	 * @return string   Json Web Token
	 */
	public static function getAuthorization()
	{
		$authorization = isset(apache_request_headers()['Authorization']) ? apache_request_headers()['Authorization'] : null;

		if (v::stringType()->notEmpty()->validate($authorization)) {
			$jwt = sscanf($authorization, "Bearer %s")[0];

			if ($jwt) { return $jwt; } else {
				echo Response::json(401, m::get('*', 401, 'token_invalid'));
				die();
			}
		} else {
			echo Response::json(401, m::get('*', 401, 'token_defined'));
			die();
		}
	}
}