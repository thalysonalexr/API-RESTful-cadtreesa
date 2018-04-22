<?php
/**
 * Redeem a tree record per user by GET
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


class GetOneByUser implements Routable
{
  public function get($id_user, $id_tree)
  {
    return Tree::findOneByUser($id_user, $id_tree);
  }
}
