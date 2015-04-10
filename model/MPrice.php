<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 6.4.2015.
 * Time: 21:27
 */

class MPrice {

    public $id;
    public $product;
    public $price;
    public $currency;
    public $from;
    public $until;
    public $status;

    public static function get($productId) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM price WHERE product = ? AND status = ?");
        $sql->execute(array($productId, MStatus::ACTIVE));
        if($result = $sql->fetch(PDO::FETCH_OBJ)){
            $price = MPrice::fillFromDBData($result);
            $price->currency = $price->getCurrency();
            return $price;
        }
        return null;
    }

    public function getAllPrices($productId){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM price WHERE product = ? ");
        $sql->execute(array($productId, MStatus::ACTIVE));
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)){
            $data = array();
            foreach($results as $result){
                $price = MPrice::fillFromDBData($result);
                $price->currency = $price->getCurrency();
                $data[] = $price;
            }
            return $data;
        }
        return null;
    }

    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO price(product, price, currency, `from`, status) VALUES(?,?,?,NOW(),?)");
        $result = $sql->execute(array($this->product, $this->price, $this->currency, MStatus::ACTIVE));
        $this->id = $db->lastInsertId();
        return $result;
    }

    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE price SET until = NOW(), status = ? WHERE id = ?");
        $sql->execute(array(MStatus::INACTIVE, $this->id));

        $new = new MPrice();
        $new->product = $this->product;
        $new->price = $this->price;
        $new->currency = $this->currency;
        $new->status = MStatus::ACTIVE;

        $new->save();
        return $new;
    }

    public function getCurrency(){
        return MCurrency::get($this->currency);
    }

    private static function fillFromDBData($data) {
        $price = new MPrice();
        $price->id = $data->id;
        $price->product = $data->product;
        $price->price = $data->price;
        $price->currency = $data->currency;
        $price->from = $data->from;
        $price->until = $data->until;
        $price->status = $data->status;
        return $price;
    }
}