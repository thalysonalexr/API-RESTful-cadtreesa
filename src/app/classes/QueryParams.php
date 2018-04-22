<?php
/**
 * Class responsible for params in GET requests
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


use Respect\Validation\Validator;


class QueryParams
{
  /**
   * Creates a sql sort order by field
   *
   * @param array $fields 	fields in table
   *
   * @return string
   */
  public static function order($fields)
  {
    $order = self::set("order");

    $order = Validator::contains($order)->validate($fields)? $order: null;

    return $order? " ORDER BY {$order}": null;
  }

  /**
   * Creates a sql pagination by limit and offset
   *
   * @return stdClass
   */
  public static function pagination()
  {
    $limit = (int) self::set("limit");
    $offset = (int) self::set("offset");

    $limit = Validator::intType()->notEmpty()->positive()->validate($limit)? $limit: false;
    $offset = Validator::intType()->notEmpty()->positive()->validate($offset)? $offset: 0;

    $pagination = "";
    $pagination .= $limit? " LIMIT {$limit}": null;
    $pagination .= ($limit && $offset)? " OFFSET {$offset}": null;

    return (object) [
      "limit" => $limit,
      "offset" => $offset,
      "query" => $pagination
    ];
  }

  /**
   * Check whether to extend a table
   *
   * @param string $table 	table extend
   *
   * @return string
   */
  public static function extends($table)
  {
    $extends = strtoupper(self::set("extends"));

    $extends = Validator::equals($extends)->validate($table) ? $extends: null;

    return $extends;
  }

  /**
   * Returns a url parameter if it exists
   *
   * @param string $key 	key for param
   *
   * @return string
   */
  private static function set($key)
  {
    return (isset($_GET[$key]) && !empty($_GET[$key])) ? $_GET[$key]: null; 
  }
}
