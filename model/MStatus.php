<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 6.4.2015.
 * Time: 20:11
 */

class MStatus {

    const ACTIVE = 100;
    const INACTIVE = 101;

    const AVAILABLE = 200;
    const UNAVAILABLE = 201;
    const DISABLED = 202;
    const DELETED = 203;

    public $id;
    public $name;

    public static function get($id) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM status WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return MStatus::fillFromDBData($result);
        }
        return null;
    }

    public function isActive(){
        return $this->id == MStatus::ACTIVE;
    }

    public function isInactive(){
        return $this->id == MStatus::INACTIVE;
    }

    public function isAvailable(){
        return $this->id == MStatus::AVAILABLE;
    }

    public function isUnavailable(){
        return $this->id == MStatus::UNAVAILABLE;
    }

    public function isDisabled(){
        return $this->id == MStatus::DISABLED;
    }

    public function isDeleted(){
        return $this->id == MStatus::DELETED;
    }

    private static function fillFromDBData($data) {
        $status = new MStatus();
        $status->id = intval($data->id);
        $status->name = $data->name;
        return $status;
    }

    public static function getRegularStatusSet() {
        return MStatus::getStatusSet(100, 200);
    }

    public static function getPostStatusSet() {
        return MStatus::getStatusSet(200, 300);
    }

    public static function getStatusSet($bottom = 0, $top = 1000){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM status WHERE id >= ? AND id < ?");
        $sql->execute(array($bottom, $top));
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            $data = array();
            foreach($results as $result) {
                $data[] = MStatus::fillFromDBData($result);
            }
            return $data;
        }
        return null;
    }



}