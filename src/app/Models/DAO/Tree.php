<?php
/**
 * Data access class of the Tree object
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
use Cadtreesa\Models\DAO\User;


class Tree extends Database
{
  const TABLE = "TREES";
  const EXTENDS_USER = "USERS";

  public static function register(\stdClass $data)
  {
    $r = parent::create(self::TABLE, [
      'name'         => $data->name,
      'specie'       => $data->specie,
      'family'       => $data->family,
      'cap'          => $data->cap,
      'height'       => $data->height,
      'classcup'     => $data->classcup,
      'sanity'       => $data->sanity,
      'growth'       => $data->growth,
      'sociological' => $data->sociological,
      'utilization'  => $data->utilization,
      'features'     => $data->features,
      'image'        => $data->image,
      'latitude'     => $data->latitude,
      'longitude'    => $data->longitude,
      'created'      => $data->created,
      'validated'    => $data->validated,
      'id_user'      => $data->id_user
    ]);
    if ($r->success) {
      Response::ContentLocation(base_url() . "/v1/trees/{$r->data}");
      return Response::json(201, m::get('post', 201), ["id" => $r->data]);
    }
    return Response::json(500, m::get('post', 500) . $r->error);
  }

  public static function findOne($id, $where="id", $extends = null)
  {
    $r = parent::find(self::TABLE, $where, $id);

    if ($r->success) {
      if ($r->data) {
        $tree = self::model($r->data);

        if ($extends === self::EXTENDS_USER) {

          $user = parent::query("SELECT * FROM {$extends} WHERE {$extends}.id = ?", [$tree->getUser()]);

          if ($user->success)
            $tree->setUser(User::model($user->data[0]));

        } else
          $tree->setUser(base_url() . "/v1/trees/{$tree->getUser()}/users");

        return Response::json(200, "OK", $tree);
      }
      return Response::json(404, m::get('get', 404) . "ID: {$id}");
    }
    return Response::json(500, m::get('get', 500) . $r->error);
  }

  public static function findAll($order = null, $pagination = null, $extends = null)
  {
    $count = parent::count(self::TABLE);

    $r = parent::all(self::TABLE, $order, $pagination->query);

    if ($r->success) {
      $trees = [];

      foreach ($r->data as $value)
        $trees[] = self::model($value);

      if ($extends) {
        foreach ($trees as $object) {
          $user = parent::find("USERS", "id", $object->getUser());
          $user = User::model($user->data);
          $user->setTrees(base_url() . "/v1/users/{$user->getId()}/trees");
          $object->setUser($user);
        }
      } else {
        foreach ($trees as $object) {
          $object->setUser(base_url() . "/v1/trees/{$object->getId()}/users");
        }
      }

      if ($trees) {
        return Response::json(200, "OK", [
          "metadata" => [
            "count"     => count($trees),
            "offset"    => $pagination->offset,
            "limit"     => $pagination->limit,
            "size"      => $count->data
          ],
          "results" => $trees
        ]);
      }
      return Response::json(404, m::get('get', 404));
    }
    return Response::json(500, m::get('get', 500) . $r->error);
  }

  public static function findOneByUser($id_user, $id_tree, $where="id")
  {
    $r = parent::query("SELECT * FROM " . self::TABLE . " WHERE ". self::TABLE . ".id = ? AND " . self::TABLE . ".id_user = ?", [$id_tree, $id_user]);

    if ($r->success) {
      if ($r->data) {
        $tree = self::model($r->data[0]);

        return Response::json(200, "OK", [
          "metadata" => [
            "father" => base_url() . "/v1/users/{$id_user}"
          ],
          "results" => $tree
        ]);
      }
      return Response::json(404, m::get('get', 404));
    }
    return Response::json(500, m::get('get', 500) . $r->error);
  }

  public static function findAllByUser($id, $where="id", $order, $pagination, $extends)
  {
    $count = parent::query("SELECT COUNT(*) total FROM " . self::TABLE . " WHERE " . self::TABLE . ".id_user = ?", [$id]);
    $r = parent::query("SELECT * FROM " . self::TABLE . " WHERE " . self::TABLE . ".id_user = ? {$order}{$pagination->query}", [$id]);

    if ($r->success) {
      if ($r->data) {
        $trees = [];

        foreach ($r->data as $value)
          $trees[] = self::model($value);

        return Response::json(200, "OK", [
          "metadata" => [
          "count"     => count($trees),
          "offset"    => $pagination->offset,
          "limit"     => $pagination->limit,
          "size"      => (int) $count->data[0]->total,
          "father"    => base_url() . "/v1/users/{$id}"
          ],
          "results" => $trees
        ]);
      }
      return Response::json(404, m::get('get', 404));
    }
    return Response::json(500, m::get('get', 500) . $r->error);
  }

  public static function alter(\stdClass $data, $id, $where="id")
  {    
    $r = parent::update("TREES", [
      'name'         => $data->name,
      'specie'       => $data->specie,
      'family'       => $data->family,
      'cap'          => $data->cap,
      'height'       => $data->height,
      'classcup'     => $data->classcup,
      'sanity'       => $data->sanity,
      'growth'       => $data->growth,
      'sociological' => $data->sociological,
      'utilization'  => $data->utilization,
      'features'     => $data->features,
      'image'        => $data->image,
      'latitude'     => $data->latitude,
      'longitude'    => $data->longitude,
      'validated'    => $data->validated
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
        return Response::json(404, m::get('delete', 404));
    }
    return Response::json(500, m::get('delete', 500) . $r->error);
  }

  public static function model(\stdClass $object)
  {
    $tree = new \Cadtreesa\Models\bean\Tree;
    $tree->setId(           $object->id);
    $tree->setName(         $object->name);
    $tree->setSpecie(       $object->specie);
    $tree->setFamily(       $object->family);
    $tree->setCap(          $object->cap);
    $tree->setHeight(       $object->height);
    $tree->setClasscup(     $object->classcup);
    $tree->setSanity(       $object->sanity);
    $tree->setGrowth(       $object->growth);
    $tree->setSociological( $object->sociological);
    $tree->setUtilization(  $object->utilization);
    $tree->setFeatures(     $object->features);
    $tree->setImage(        $object->image);
    $tree->setLatitude(     $object->latitude);
    $tree->setLongitude(    $object->longitude);
    $tree->setCreated(      $object->created);
    $tree->setValidated(    $object->validated);
    $tree->setUser(         $object->id_user);
    return $tree;
  }
}
