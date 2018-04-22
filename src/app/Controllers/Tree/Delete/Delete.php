<?php
/**
 * Delete tree records by DELETE
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\Tree\Delete
 */

namespace Cadtreesa\Controllers\Tree\Delete;


use Cadtreesa\Models\DAO\Tree;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;
use Respect\Rest\Routable;


class Delete implements Routable
{
  public function delete($id = null)
  {
    if ($id != null)
      return Tree::remove($id);

    return Response::json(400, m::get('*', 400, 'invalid_input'));
  }
}
