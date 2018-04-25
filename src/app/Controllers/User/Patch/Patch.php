<?php
/**
 * Edit user data by PATCH
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Put
 */

namespace Cadtreesa\Controllers\User\Patch;


use Cadtreesa\classes\Response;
use Cadtreesa\classes\Json;
use Cadtreesa\classes\Message as m;
use Cadtreesa\Validation\UserFieldValidator;
use Cadtreesa\Models\DAO\User;
use Respect\Rest\Routable;


class Patch implements Routable
{
  public function patch($id = null)
  {
    $data = Json::verify();
    $validate = (object) UserFieldValidator::validate($data);

    if ($validate->success && $id != null)
      return User::alterOne($data, $id);

    return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);
  }
}
