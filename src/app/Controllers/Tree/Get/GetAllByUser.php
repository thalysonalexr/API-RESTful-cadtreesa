<?php
/**
 * Redeem all tree records per user by GET
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


class GetAllByUser implements Routable
{
	public function get($id)
	{ 
        return Tree::findAllByUser(
            $id, "id",
            QueryParams::order(["id", "name", "specie", "created"]),
            QueryParams::pagination(),
            QueryParams::extends("USERS")
        );
    }
}