<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 6.4.2015.
 * Time: 20:33
 */

class MCurrency {

    public $id;
    public $code;
    public $name;
    public $single;
    public $status;

    public static function get($id){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM currency WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return MCurrency::fillFromDBData($result);
        }
        return null;
    }

    public static function getAll($safe = false){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM currency");
        $sql->execute();
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            $data = array();
            foreach($results as $result) {
                $data[] = MCurrency::fillFromDBData($result, $safe);
            }
            return $data;
        }
        return null;
    }

    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO currency(code, name, single, status)");
        $result = $sql->execute(array($this->code, $this->name, $this->single, $this->status));
        $this->id = $db->lastInsertId();
        return $result;
    }

    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE currency SET code = ?, name = ?, single = ?, status = ? WHERE id = ?");
        return $sql->execute(array($this->code, $this->name, $this->single, $this->status, $this->id));
    }

    public function enable(){
        $this->changeStatus(MStatus::ACTIVE);
    }

    public function disable(){
        $this->changeStatus(MStatus::INACTIVE);
    }

    public function isEnabled(){
        return $this->status == MStatus::ACTIVE;
    }

    public function isDisabled(){
        return !$this->isEnabled();
    }

    public function getStatus(){
        return MStatus::get($this->status);
    }
    private function changeStatus($status){
        $this->status = $status;
        $this->update();

    }

    private static function fillFromDBData($data, $safe = false){
        $currency = new MCurrency();
        $currency->id = $data->id;
        $currency->code = $data->code;
        $currency->name = $data->name;
        $currency->single = $safe ? utf8_encode($data->single) : $data->single;
        $currency->status = $data->status;
        return $currency;
    }
}