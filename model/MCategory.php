<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 6.4.2015.
 * Time: 20:22
 */

class MCategory {
    public $id;
    public $name;
    public $status;

    /**
     * @param $id
     * @return null|MCategory
     */
    public static function get($id) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM category WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return MCategory::fillFromDBData($result);
        }
        return null;
    }

    public static function getAll() {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM category WHERE NOT status = ?");
        $sql->execute(array(MStatus::DELETED));
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            $data = array();
            foreach($results as $result) {
                $data[] = MCategory::fillFromDBData($result);
            }
            return $data;
        }
        return null;
    }

    public static function getAllActive(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM category WHERE status = ?");
        $sql->execute(array(MStatus::ACTIVE));
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            $data = array();
            foreach($results as $result) {
                $data[] = MCategory::fillFromDBData($result);
            }
            return $data;
        }
        return null;
    }

    public function save() {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO category(name, status) VALUES(?,?)");
        $result = $sql->execute(array($this->name, $this->status));
        $this->id = $db->lastInsertId();
        return $result;
    }

    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE category SET name = ?, status = ? WHERE id = ?");
        return $sql->execute(array($this->name, $this->status, $this->id));
    }

    public function delete(){
        $this->status = MStatus::DELETED;
        return $this->update();
    }

    public function getStatus() {
        return MStatus::get($this->status);
    }

    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

    private static function fillFromDBData($data) {
        $category = new MCategory();
        $category->id = intval($data->id);
        $category->name = $data->name;
        $category->status = intval($data->status);
        return $category;
    }



}