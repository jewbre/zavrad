<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 29.5.2015.
 * Time: 3:40
 */

class MShippingAddress {

    public $id;
    public $user_id;
    public $recipient;
    public $address;
    public $address_extra;
    public $city;
    public $country;
    public $postal_code;
    public $status;

    public static function get($id)
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM shipping_address WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)){
            return self::fillFromDbData($result);
        }
        return null;
    }


    public static function getUserAddresses($user_id)
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM shipping_address WHERE user_id = ?");
        $sql->execute(array($user_id));
        $data = array();
        foreach($result = $sql->fetchAll(PDO::FETCH_OBJ) as $result){
            $data[] = self::fillFromDbData($result);
        }
        return $data;
    }

    public function save()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO shipping_address(user_id, recipient, address, address_extra, city, country, postal_code, status) VALUES(?,?,?,?,?,?,?)");
        $result = $sql->execute(array($this->user_id, $this->recipient, $this->address, $this->address_extra, $this->city, $this->country, $this->postal_code, MStatus::ACTIVE));

        if($result) {
            $this->id = $db->lastInsertId();
        }

        return $result;
    }

    public function update()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE shipping_address SET recipient = ?, address = ?, address_extra = ?, city = ?, country = ?, postal_code = ?, status = ? WHERE id = ?");
        return $sql->execute(array($this->recipient, $this->address, $this->address_extra, $this->city, $this->country, $this->postal_code, $this->status, $this->id));
    }

    public function deactivate()
    {
        $this->status = MStatus::INACTIVE;
        return $this->update();
    }

    public function delete()
    {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM shipping_address WHERE id = ?");
        return $sql->execute(array($this->id));
    }

    public function getStatus()
    {
        return MStatus::get($this->status);
    }

    private static function fillFromDbData($data)
    {
        $msa = new MShippingAddress();
        $msa->id = $data->id;
        $msa->user_id = $data->user_id;
        $msa->recipient = $data->recipient;
        $msa->address = $data->address;
        $msa->address_extra = $data->address_extra;
        $msa->city = $data->city;
        $msa->country = $data->country;
        $msa->postal_code = $data->postal_code;
        $msa->status = $data->status;
        return $msa;
    }

}