<?php
/**
 * Class responsible for connection with PDO object and declarations
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package classes
 */

namespace Cadtreesa\classes;


class Database
{
  /**
   * Which database to select
   *
   * @var string
   */
  private static $database = APP_ENVIRONMENT["DB"]["DB_CONNECTION"];
  /**
   * Connecting host
   *
   * @var string
   */
  private static $hostname = APP_ENVIRONMENT["DB"]["DB_HOSTNAME"];
  /**
   * Port host
   *
   * @var string
   */
  private static $port = APP_ENVIRONMENT["DB"]["DB_PORT"];
  /**
   * Name database
   *
   * @var string
   */
  private static $dbName = APP_ENVIRONMENT["DB"]["DB_DBNAME"];
  /**
   * Username database
   *
   * @var string
   */
  private static $username = APP_ENVIRONMENT["DB"]["DB_USERNAME"];
  /**
   * Password database
   *
   * @var string
   */
  private static $password = APP_ENVIRONMENT["DB"]["DB_PASSWORD"];
  /**
   * Unicode characters
   *
   * @var string $charset
   */
  private static $charset = APP_ENVIRONMENT["DB"]["DB_CHARSET"];

  /**
   * Connects to the database
   *
   * @see \PDO
   *
   * @return \PDO object Connection
   */
  private static function connect()
  {
    $pdo = new \PDO(self::$database . ":host=" . self::$hostname . ";port=" . self::$port . ";dbname=" . self::$dbName . ";charset=" . self::$charset, self::$username, self::$password);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
    return $pdo;
  }

  /**
   * Creates new records in the database
   *
   * @param string $table     table to enter data
   * @param Array  $fields    insertion parameters
   *
   * @return stdClass
   */
  public static function create($table, Array $fields)
  {
    if (!is_array($fields))
      $fields = (array) $fields;

    $sql = "INSERT INTO {$table}";
    $sql .="(".implode(",", array_keys($fields)).")";
    $sql .= "values(:".implode(",:", array_keys($fields)).")";

    try {
      $pdo = self::connect();
      $insert = $pdo->prepare($sql);
      $pdo->beginTransaction();
      $insert->execute($fields);
      $id = $pdo->lastInsertId();
      try {
        $pdo->commit();
      } catch (\Exception $e) {
        $pdo->rollBack();
      }
      return (object) [
        "success" => true,
        "data" => $id
      ];
    } catch (\Exception $e) {
      return (object) [
        "success" => false,
        "error" => $e->getMessage()
      ];
    }
  }

  /**
   * Select all records in table
   *
   * @param string $table         table for data recovery
   * @param string $order         ordenation this query
   * @param string $pagination    pagination this query
   * @param array  $fields        fields selected in query
   *
   * @return stdClass
   */
  public static function all($table, $order = null, $pagination = null, array $fields = array())
  {
    $f = $fields? implode(", ", $fields): "*";

    $sql = "SELECT {$f} FROM {$table}{$order}{$pagination}";

    try {
      $pdo = self::connect();
      $list = $pdo->query($sql);
      $list->execute();
      return (object) [
        "success" => true,
        "data" => $list->fetchAll()
      ];
    } catch (\Exception $e) {
      return (object) [
        "success" => false,
        "error" => $e->getMessage()
      ];
    }
  }

  /**
   * Count a number of registers
   *
   * @param string $table     table to count data
   *
   * @return stdClass
   */
  public static function count($table)
  {
    $sql = "SELECT COUNT(*) count FROM {$table}";

    try {
      $pdo = self::connect();
      $count = $pdo->query($sql);
      $count->execute();
      return (object) [
        "success" => true,
        "data" => (int) $count->fetch()->count
      ];
    } catch (\Exception $e) {
      return (object) [
        "success" => false,
        "error" => $e->getMessage()
      ];
    }
  }

  /**
   * Updates the records of a table
   *
   * @param string $table     table to update data
   * @param Array  $fields    insertion parameters
   * @param string $where     statement
   *
   * @return stdClass
   */
  public static function update($table, $fields, $where)
  {
    if (!is_array($fields))
      $fields = (array) $fields;

    $data = array_map(function( $field ){
      return "{$field} = :{$field}";
    }, array_keys( $fields ));

    $sql = "UPDATE {$table} SET ";
    $sql.= implode("," , $data);
    $sql.= " WHERE {$where[0]} = :{$where[0]}";

    $data = array_merge($fields, [$where[0] => $where[1]]);

    try {
      $pdo = self::connect();
      $update = $pdo->prepare($sql);
      $pdo->beginTransaction();
      $update->execute($data);
      try {
        $pdo->commit();
      } catch (\Exception $e) {
        $pdo->rollBack();
      }
      return (object) [
        "success" => true,
        "data" => $update->rowCount()
      ];
    } catch (\Exception $e) {
      return (object) [
        "success" => false,
        "error" => $e->getMessage()
      ];
    }  
  }

  /**
   * Search for a specific record
   *
   * @param string $table     table to search
   * @param string $field     parameter in where clause
   * @param string $value     value identifier
   * @param array  $params    parameters a selected fields
   *
   * @return stdClass
   */
  public static function find($table, $field, $value, array $params = array())
  {
    $p = $params? implode(", ", $params): "*";

    $sql = "SELECT {$p} FROM {$table} WHERE {$field} = :{$field}";

    try {
      $pdo = self::connect();
      $find = $pdo->prepare($sql);
      $find->bindValue($field, $value);
      $find->execute();
      return (object) [
        "success" => true,
        "data" => $find->fetch()
      ];
    } catch (\Exception $e) {
      return (object) [
        "success" => false,
        "error" => $e->getMessage()
      ];
    }
  }

  /**
   * Deletes a record from the table
   *
   * @param string $table     table to delete data
   * @param Array  $field     delete parameters
   * @param Array  $value     value identifier
   *
   * @return stdClass
   */
  public static function delete($table, $field, $value)
  {
    $sql = "DELETE FROM {$table} WHERE {$field} = :{$field}";

    try {
      $pdo = self::connect();
      $delete = $pdo->prepare($sql);
      $delete->bindValue($field, $value);
      $pdo->beginTransaction();
      $delete->execute();
      try {
        $pdo->commit();
      } catch (\Exception $e) {
        $pdo->rollBack();
      }
      return (object) [
        "success" => true,
        "data" => $delete->rowCount()
      ];
    } catch (\Exception $e) {
      return (object) [
        "success" => false,
        "error" => $e->getMessage()
      ];
    }
  }

  /**
   * Runs statements from a PDO connection
   *
   * @param string $query   Query statement to be executed
   * @param array  $params  Parameters to be linker to query
   *
   * @return stdClass
   */
  public static function query($query, $params = [])
  {
    try {
      $pdo = self::connect();
      $list = $pdo->prepare($query);
      $list->execute($params);
      if (explode(' ', $query)[0] == 'SELECT') {
        return (object) [
          "success" => true,
          "data" => $list->fetchAll()
        ];
      }
    } catch (\Exception $e) {
      return (object) [
        "success" => false,
        "error" => $e->getMessage()
      ];
    }
  }
}
