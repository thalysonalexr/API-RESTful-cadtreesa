<?php
/**
 * Redeem all trees records by GET
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


class GetAll implements Routable
{
	public function get()
	{
		return Tree::findAll(
			QueryParams::order(["id", "name", "specie", "created"]),
			QueryParams::pagination(),
			QueryParams::extends("USERS")
		);
	}
}