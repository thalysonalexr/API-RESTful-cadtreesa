<?php
/**
 * Implements the method validate
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Validation
 */

namespace Cadtreesa\Validation;


interface ValidatorInterface
{
	public static function validate(\stdClass $object);
}