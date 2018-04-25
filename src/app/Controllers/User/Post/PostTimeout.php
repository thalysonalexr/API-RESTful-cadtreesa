<?php
/**
 * Time out of user by POST
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Post
 */

namespace Cadtreesa\Controllers\User\Post;


use Cadtreesa\classes\Json;
use Cadtreesa\classes\Database;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;
use Respect\Rest\Routable;


class PostTimeout implements Routable
{
  public function post()
  {
    $data = Json::verify();
    
    $r = Database::update('LOG', [
      'signout_dt' => date("Y-m-d H:i:s"),
      'timeout' => 1
    ], ['id', $data->id]);

    return $r->success ? Response::json(204, ["id" => $id]): Response::json(500, m::get('put', 500) . $r->error);
  }
}
