<?php
/**
 * Redeem data tree from a record by GET
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\Tree\Get
 */

namespace Cadtreesa\Controllers\Tree\Get;


use Respect\Rest\Routable;
use Cadtreesa\Models\DAO\Tree;
use Cadtreesa\classes\QueryParams;


class Get implements Routable
{
  public function get($id)
  {
    return Tree::findOne($id, "id", QueryParams::extends("USERS"));
  }
}
