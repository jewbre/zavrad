<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 3.5.2015.
 * Time: 0:36
 */

class MPage {

    public $id;
    public $name;
    public $url;

    public static function get($id) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM page WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return self::fillFromDBData($result);
        }
        return null;
    }

    public static function getByUrl($url) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM page WHERE url = ?");
        $sql->execute(array($url));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return self::fillFromDBData($result);
        }
        return null;
    }

    public static function getAll(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM page");
        $sql->execute();
        $data = array();
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            foreach($results as $result) {
                $data[] = self::fillFromDBData($result);
            }
        }
        return $data;
    }

    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO page(name, url) VALUES(?,?)");
        $result = $sql->execute(array($this->name, $this->url));
        if($result) {
            $this->id = $db->lastInsertId();
            return true;
        }
        return false;
    }

    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE page SET name = ?, url = ? WHERE id = ?");
        return $sql->execute(array($this->name, $this->url, $this->id));
    }

    public function delete(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM page WHERE id = ?");
        return $sql->execute(array($this->id));
    }

    private static function fillFromDBData($data){
        $p = new MPage();
        $p->id = $data->id;
        $p->name = $data->name;
        $p->url = $data->url;
        return $p;
    }

}