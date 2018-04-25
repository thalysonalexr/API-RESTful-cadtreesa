<?php
/**
 * Custom HTTP header for trees
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Get
 */

namespace Cadtreesa\Controllers\Tree\Head;


use Cadtreesa\classes\Response;
use Cadtreesa\classes\Database;
use Respect\Rest\Routable;


class Head implements Routable
{
  public function head()
  {
    $countTotal = Database::count('TREES');
    $validated = Database::query('SELECT COUNT(*) AS total FROM TREES WHERE TREES.validated = ?', [1]);

    if ($countTotal->success && $validated->success) {
      Response::CustomHeader('Total-Count', $countTotal->data);
      Response::CustomHeader('Total-Count-Validated', $validated->data[0]->total);
      return Response::json(204, 'OK');
    }
    return Response::json(500, m::get('*', 500, 'error'));
  }
}
