<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 29.5.2015.
 * Time: 4:25
 */

class MShippingMethod {

    public $id;
    public $name;
    public $status;

    public static function get($id)
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM shipping_method WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)){
            return self::fillFromDbData($result);
        }
        return null;
    }

    public static function getAll()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM shipping_method");
        $sql->execute();
        $data = array();
        foreach($results = $sql->fetchAll(PDO::FETCH_OBJ) as $result){
            $data[] = self::fillFromDbData($result);
        }
        return $data;
    }


    public static function getByStatus($status)
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM shipping_method WHERE status = ?");
        $sql->execute(array($status));
        $data = array();
        foreach($results = $sql->fetchAll(PDO::FETCH_OBJ) as $result){
            $data[] = self::fillFromDbData($result);
        }
        return $data;
    }

    public static function getActive()
    {
        return self::getByStatus(MStatus::ACTIVE);
    }

    public static function getInactive()
    {
        return self::getByStatus(MStatus::INACTIVE);
    }

    public function save()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO shipping_method(name, status) VALUES(?,?)");
        $result = $sql->execute(array($this->name, $this->status));
        if($result) {
            $this->id = $db->lastInsertId();
        }
        return $result;
    }

    public function update()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE shipping_method SET name = ?, status = ? WHERE id = ?");
        return $sql->execute(array($this->name, $this->status, $this->id));
    }

    public function activate()
    {
        $this->status = MStatus::ACTIVE;
        return $this->update();
    }

    public function deactivate(){
        $this->status = MStatus::INACTIVE;
        $this->update();
    }

    public function delete()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM shipping_method WHERE id = ?");
        return $sql->execute(array($this->id));
    }

    private static function fillFromDbData($data)
    {
        $msm = new MShippingMethod();
        $msm->id = $data->id;
        $msm->name = $data->name;
        $msm->status = $data->status;

        return $msm;
    }

}