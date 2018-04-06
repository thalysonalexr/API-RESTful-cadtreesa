<?php
/**
 * Class User data model
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Models\bean
 */

namespace Cadtreesa\Models\bean;


class User implements \JsonSerializable
{
    private $id;
    private $name;
    private $rgacpf;
    private $email;
    private $password;
    private $hash;
    private $type;
    private $status;
    private $created;
    private $trees;


    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        return $this->id = $value;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($value) {
        $this->name = $value;
    }

    public function getRgacpf() {
        return $this->rgacpf;
    }

    public function setRgacpf($value) {
        $this->rgacpf = $value;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($value) {
        $this->email = $value;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($value) {
        $this->password = $value;
    }

    public function getHash() {
        return $this->hash;
    }

    public function setHash($value) {
        $this->hash = $value;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($value) {
        $this->type = $value;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($value) {
        $this->status = $value;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($value) {
        $this->created = $value;
    }

    public function getTrees() {
        return $this->trees;
    }

    public function setTrees($value) {
        $this->trees = $value;
    }

    /**
     * method to transform object into array for json
     *
     * @return array object array of this class
     */
    public function jsonSerialize() {
        return
        [
            'id'        => (int) $this->getId(),
            'name'      => $this->getName(),
            'rgacpf'    => $this->getRgacpf(),
            'email'     => $this->getEmail(),
            'password'  => $this->getPassword(),
            'hash'      => $this->getHash(),
            'type'      => $this->getType(),
            'status'    => $this->getStatus(),
            'created'   => $this->getCreated(),
            'trees'     => $this->getTrees()
        ];
    }
}
