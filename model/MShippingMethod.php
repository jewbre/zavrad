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
        $sql = $db->prepare("SELECT * FROM shipping_method WHERE id = ? AND NOT status = ?");
        $sql->execute(array($id, MStatus::DELETED));
        if($result = $sql->fetch(PDO::FETCH_OBJ)){
            return self::fillFromDbData($result);
        }
        return null;
    }

    public static function getAll()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM shipping_method WHERE NOT status = ?");
        $sql->execute(array(MStatus::DELETED));
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

    public static function getDeleted()
    {
        return self::getByStatus(MStatus::DELETED);
    }

    public function save()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO shipping_method(name, status) VALUES(?,?)");
        $result = $sql->execute(array($this->name, $this->getStatus()->id));
        if($result) {
            $this->id = $db->lastInsertId();
        }
        return $result;
    }

    public function update()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE shipping_method SET name = ?, status = ? WHERE id = ?");
        return $sql->execute(array($this->name, $this->getStatus()->id, $this->id));
    }

    public function activate()
    {
        $this->status = MStatus::get(MStatus::ACTIVE);
        return $this->update();
    }

    public function deactivate(){
        $this->status = MStatus::get(MStatus::INACTIVE);
        $this->update();
    }

    /**
     * @return MStatus
     */
    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = MStatus::get($value);
    }
    public function delete()
    {
        $this->setStatus(MStatus::DELETED);
        return $this->update();
    }

    private static function fillFromDbData($data)
    {
        $msm = new MShippingMethod();
        $msm->id = $data->id;
        $msm->name = $data->name;
        $msm->setStatus($data->status);

        return $msm;
    }

}