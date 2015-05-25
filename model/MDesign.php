<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 27.3.2015.
 * Time: 1:55
 */

class MDesign {
    public $id;
    public $name;
    public $data;
    public $page;

    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO design(name, data, page) VALUES(?,?,?)");
        $sql->execute(
            array(
                $this->name,
                json_encode($this->data),
                $this->page,
            )
        );
    }

    public static function getByPage($id) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM design WHERE page = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            $md = new MDesign();
            $md->id = $result->id;
            $md->name = $result->name;
            $md->page = $result->page;
            $md->data = json_decode($result->data);
            return $md;
        }
        return null;
    }

    public static function get($id) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM design WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            $md = new MDesign();
            $md->id = $result->id;
            $md->name = $result->name;
            $md->page = $result->page;
            $md->data = json_decode($result->data);
            return $md;
        }
        return null;
    }

    public static function getAll(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM design");
        $sql->execute();
        $data = array();
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            foreach($results as $result) {
                $md = new MDesign();
                $md->id = $result->id;
                $md->name = $result->name;
                $md->page = $result->page;
                $md->data = json_decode($result->data);
                $data[] = $md;
            }
        }
        return $data;
    }

    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE design SET name = ?, data = ?, page = ? WHERE id = ?");
        $sql->execute(
            array(
                $this->name,
                json_encode($this->data),
                $this->page,
                $this->id,
            )
        );
    }

    public function getPage(){
        return MPage::get($this->page);
    }

    public function delete(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare(("DELETE FROM design WHERE id = ?"));
        $sql->execute(array($this->id));
    }

}