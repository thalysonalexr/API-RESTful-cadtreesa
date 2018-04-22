<?php
/**
 * Retrieve data from one user per tree per GET
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Get
 */

namespace Cadtreesa\Controllers\User\Get;


use Respect\Rest\Routable;
use Cadtreesa\Models\DAO\User;
use Cadtreesa\classes\QueryParams;


class GetByTree implements Routable
{
  public function get($id)
  {
    return User::findByTree($id, "id", QueryParams::extends("TREES"));
  }
}
