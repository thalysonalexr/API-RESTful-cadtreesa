<?php
/**
 * Redeem all user data by GET
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Controllers\User\Get
 */

namespace Cadtreesa\Controllers\User\Get;


use Respect\Rest\Routable;
use Cadtreesa\Models\DAO\User;
use Cadtreesa\classes\QueryParams;


class GetAll implements Routable
{
	public function get()
	{
        return User::findAll(
            QueryParams::order(["id", "name", "created"]),
            QueryParams::pagination(),
            QueryParams::extends("TREES")
        );
    }
}