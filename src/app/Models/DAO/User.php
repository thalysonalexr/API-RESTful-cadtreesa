<?php
/**
 * Data access class of the User object
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues/
 *
 * @version 1.0
 * @package Models\DAO
 */

namespace Cadtreesa\Models\DAO;


use Cadtreesa\classes\Database;
use Cadtreesa\classes\Response;
use Cadtreesa\classes\Message as m;
use Cadtreesa\classes\Password;
use Cadtreesa\Models\DAO\Tree;


class User extends Database
{
  const TABLE = "USERS";
  const LOG = "LOG";
  const EXTENDS_TREES = "TREES";

  public static function register(\stdClass $data)
  {
    $r = parent::create(self::TABLE, [
      "name"      => $data->name,
      "rgacpf"    => $data->rgacpf,
      "email"     => $data->email,
      "password"  => $data->password,
      "hash"      => $data->hash,
      "type"      => $data->type,
      "status"    => $data->status,
      "created"   => $data->created
    ]);
    if ($r->success) {
      Response::ContentLocation(base_url() . "/v1/users/{$r->data}");
      return Response::json(201, m::get('post', 201), ["id" => $r->data]);
    }
    return Response::json(500, m::get('post', 500) . $r->error);        
  }

  public static function findOne($id, $where="id", $extends = null)
  {
    $r = parent::find(self::TABLE, $where, $id);

    if ($r->success) {
      if ($r->data) {

        $user = self::model($r->data);

        if ($extends === self::EXTENDS_TREES) {

          $trees = parent::query("SELECT * FROM TREES WHERE TREES.id_user = ?", [$user->getId()]);
          $registers = [];

          if ($trees->success) {
            foreach ($trees->data as $value)
              $registers[] = Tree::model($value);

            $user->setTrees($registers);
          }

        } else
          $user->setTrees(base_url() . "/v1/users/{$user->getId()}/trees");

        return Response::json(200, "OK", $user);
      }
      return Response::json(404, m::get('get', 404));
    } 
    return Response::json(500, m::get('get', 500) . $r->error);
  }

  public static function findAll($order = null, $pagination = null, $extends = null)
  {
    $count = parent::count(self::TABLE);

    $r = parent::all(self::TABLE, $order, $pagination->query);

    if ($r->success) {
      $users = [];

      foreach ($r->data as $value)
        $users[] = self::model($value);

      if ($extends === self::EXTENDS_TREES) {
        foreach ($users as $object) {
          $trees = parent::query("SELECT * FROM {$extends} WHERE {$extends}.id_user = ?", [$object->getId()]);
          $registers = [];

          if ($trees->success) {
            foreach ($trees->data as $value)
              $registers[] = Tree::model($value);

            $object->setTrees($registers);
          }
        }
      } else {
        foreach ($users as $object)
          $object->setTrees(base_url() . "/v1/users/{$object->getId()}/trees");
      }

      if ($users) {
        return Response::json(200, "OK", [
          "metadata" => [
            "count"     => count($users),
            "offset"    => $pagination->offset,
            "limit"     => $pagination->limit,
            "size"      => $count->data
          ],
          "results" => $users
        ]);
      }
      return Response::json(404, m::get('get', 404));
    }
    return Response::json(500, m::get('get', 500) . $r->error);
  }

  public static function findByTree($id, $where="id", $extends = null)
  {
    $r = parent::query("SELECT * FROM " . self::TABLE . " WHERE id = (SELECT id_user FROM TREES WHERE id = ?)", [$id]);

    if ($r->success) {
      if ($r->data) {
        $user = self::model($r->data[0]);

        if ($extends === self::EXTENDS_TREES) {

          $trees = parent::query("SELECT * FROM TREES WHERE TREES.id_user = ?", [$user->getId()]);
          $registers = [];

          if ($trees->success) {
            foreach ($trees->data as $value)
              $registers[] = Tree::model($value);

            $user->setTrees($registers);
          }

        } else
        $user->setTrees(base_url() . "/v1/users/{$user->getId()}/trees");

        return Response::json(200, "OK", $user);
      }
      return Response::json(404, m::get('get', 404) . "ID: {$id}");
    }
    return Response::json(500, m::get('get', 500) . $r->error);
  }

  public static function alter(\stdClass $data, $id, $where="id")
  {    
    $r = parent::update(self::TABLE, [
      "name"      => $data->name, 
      "rgacpf"    => $data->rgacpf,
      "email"     => $data->email
    ], [$where, $id]);

    if ($r->success) {
      if ($r->data === 1) {
        return Response::json(200, m::get('put', 200), ["id" => $id]);
      } elseif ($r->data === 0) {
        return Response::json(200, m::get('*', 200, 'not_altered'));
      }
      return Response::json(404, m::get('get', 404));
    }
    return $r->success ? : Response::json(500, m::get('put', 500) . $r->error);
  }

  public static function remove($id, $where="id")
  {
    $r = parent::delete(self::TABLE, $where, $id);

    if ($r->success) {
      if ($r->data === 1) {
        Response::Entity($id);
        return Response::json(204, ["id" => $id]);
      }
      elseif ($r->data === 0)
        return Response::json(404, m::get('get', 404));
    }
    return Response::json(500, m::get('delete', 500) . $r->error);
  }

  public static function changePassword($id, $password, $where='id')
  {
    $r = parent::update(self::TABLE, ["password" => $password], [$where, $id]);
    return $r->success ? Response::json(204, [$r->data]): Response::json(500, m::get('put', 500) . $r->error);
  }

  public static function model(\stdClass $object) {
    $user = new \Cadtreesa\Models\bean\User;
    $user->setId(       $object->id);
    $user->setName(     $object->name);
    $user->setRgacpf(   $object->rgacpf);
    $user->setEmail(    $object->email);
    $user->setPassword( $object->password);
    $user->setHash(     $object->hash);
    $user->setType(     $object->type);
    $user->setStatus(   $object->status);
    $user->setCreated(  $object->created);
    return $user;
  }
}
