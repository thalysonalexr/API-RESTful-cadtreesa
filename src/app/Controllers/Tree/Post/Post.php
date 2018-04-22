<?php
/**
 * Register a new tree by POST
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues/
 *
 * @version 1.0
 * @package Controllers\Tree\Post
 */

namespace Cadtreesa\Controllers\Tree\Post;


use Cadtreesa\classes\Auth;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Json;
use Cadtreesa\classes\Message as m;
use Cadtreesa\Validation\TreeValidator;
use Cadtreesa\Models\DAO\Tree;
use Respect\Rest\Routable;


class Post implements Routable
{
  public function post()
  {
    $data = Json::verify();
    $validate = (object) TreeValidator::validate($data);

    if ($validate->success) {
      $data->created = date("Y-m-d H:i:s");
      $data->validated = 0;
      $data->id_user = Auth::decode(Auth::getAuthorization())->data->id;
      return Tree::register($data);
    }
    return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);
  }
}