<?php
/**
 * Delete user registry for DELETE
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Delete
 */

namespace Cadtreesa\Controllers\User\Delete;


use Respect\Rest\Routable;
use Cadtreesa\Models\DAO\User;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;
use Cadtreesa\classes\QueryParams;


class Delete implements Routable
{
	public function delete($id = null)
	{
		if ($id != null)
        	return User::remove($id);
    	return Response::json(400, m::get('*', 400, 'invalid_input'));
    }
}