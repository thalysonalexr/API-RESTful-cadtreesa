<?php
/**
 * Custom HTTP header for users
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Get
 */

namespace Cadtreesa\Controllers\User\Head;


use Cadtreesa\classes\Response;
use Cadtreesa\classes\Database;
use Cadtreesa\classes\Message as m;
use Respect\Rest\Routable;


class Head implements Routable
{
  public function head()
  {
    $response = Database::count('USERS');

    if ($response->success) {
      Response::CustomHeader('Total-Count', $response->data);
      return Response::json(204, 'OK');
    }
    return Response::json(500, m::get('*', 500, 'error'));
  }
}
