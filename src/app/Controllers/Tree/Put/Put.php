<?php
/**
 * Edit a tree by PUT
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\Tree\Put
 */

namespace Cadtreesa\Controllers\Tree\Put;


use Respect\Rest\Routable;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;
use Cadtreesa\classes\Json;
use Cadtreesa\Validation\TreeValidator;
use Cadtreesa\Models\DAO\Tree;


class Put implements Routable
{
	public function put($id = null)
	{
        $data = Json::verify();
        $validate = (object) TreeValidator::validate($data);

        if ($validate->success && $id != null)
            return Tree::alter($data, $id);

        return Response::json(400, m::get('*', 400, 'invalid_input'), $validate->log);        
    }
}