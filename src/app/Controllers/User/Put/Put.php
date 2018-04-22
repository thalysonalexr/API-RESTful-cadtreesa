<?php
/**
 * Edit user data by PUT
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Put
 */

namespace Cadtreesa\Controllers\User\Put;


use Cadtreesa\classes\Response;
use Cadtreesa\classes\Json;
use Cadtreesa\classes\Message as m;
use Cadtreesa\Validation\UserValidator;
use Cadtreesa\Models\DAO\User;
use Respect\Rest\Routable;


class Put implements Routable
{
  public function put($id = null)
  {
    $data = Json::verify();
    $validate = (object) UserValidator::validate($data);

    if ($validate->success && $id != null)
      return User::alter($data, $id);

    return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log); 
  }
}
