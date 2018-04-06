<?php
/**
 * Class Tree data model
 *
 * @author Thalyson Alexandre Rodrigues de Sousa <tha.motog@gmail.com>
 * @link https://github.com/thalysonrodrigues
 *
 * @version 1.0
 * @package Models\bean
 */

namespace Cadtreesa\Models\bean;


class Tree implements \JsonSerializable
{
    private $id;
    private $name;
    private $specie;
    private $family;
    private $cap;
    private $height;
    private $classcup;
    private $sanity;
    private $growth;
    private $sociological;
    private $utilization;
    private $features;
    private $image;
    private $latitude;
    private $longitude;
    private $created;
    private $validated;
    private $user;


    public function getId() {
        return $this->id;
    }

    public function setId($value) {
        $this->id = $value;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($value) {
        $this->name = $value;
    }

    public function getSpecie() {
        return $this->specie;
    }

    public function setSpecie($value) {
        $this->specie = $value;
    }

    public function getFamily() {
        return $this->family;
    }

    public function setFamily($value) {
        $this->family = $value;
    }

    public function getCap() {
        return $this->cap;
    }

    public function setCap($value) {
        $this->cap = $value;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($value) {
        $this->height = $value;
    }

    public function getClasscup() {
        return $this->classcup;
    }

    public function setClasscup($value) {
        $this->classcup = $value;
    }

    public function getSanity() {
        return $this->sanity;
    }

    public function setSanity($value) {
        $this->sanity = $value;
    }

    public function getGrowth() {
        return $this->growth;
    }

    public function setGrowth($value) {
        $this->growth = $value;
    }

    public function getSociological() {
        return $this->sociological;
    }

    public function setSociological($value) {
        $this->sociological = $value;
    }

    public function getUtilization() {
        return $this->utilization;
    }

    public function setUtilization($value) {
        $this->utilization = $value;
    }

    public function getFeatures() {
        return $this->features;
    }

    public function setFeatures($value) {
        $this->features = $value;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($value) {
        $this->image = $value;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude($value) {
        $this->latitude = $value;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude($value) {
        $this->longitude = $value;
    }

    public function getCreated() {
        return $this->created;
    }

    public function setCreated($value) {
        $this->created = $value;
    }

    public function getValidated() {
        return $this->validated;
    }

    public function setValidated($value) {
        $this->validated = $value;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($value) {
        $this->user = $value;
    }

    /**
     * method to transform object into array for json
     *
     * @return array object array of this class
     */
    public function jsonSerialize() {
        return
        [
            'id'           => (int) $this->getId(),
            'name'         => $this->getName(),
            'specie'       => $this->getSpecie(),
            'family'       => $this->getFamily(),
            'cap'          => $this->getCap(),
            'height'       => $this->getHeight(),
            'classcup'     => $this->getClasscup(),
            'sanity'       => $this->getSanity(),
            'growth'       => $this->getGrowth(),
            'sociological' => $this->getSociological(),
            'utilization'  => $this->getUtilization(),
            'features'     => $this->getFeatures(),
            'image'        => $this->getImage(),
            'latitude'     => $this->getLatitude(),
            'longitude'    => $this->getLongitude(),
            'created'      => $this->getCreated(),
            'validated'    => $this->getValidated(),
            'user'       => $this->getUser()
        ];
    }
}
