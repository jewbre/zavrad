<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.5.2015.
 * Time: 0:17
 */

class MCartItem {

    public $cart;
    public $product;
    public $amount;
    public $datetime;

    public static function get($cart, $product){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM cart_items WHERE cart_id = ? AND product_id = ?");
        $sql->execute(array($cart, $product));

        $data = array();
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return self::fillFromDBData($result);
        }
        return null;
    }

    public static function getFromCart($cartId){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM cart_items WHERE cart_id = ?");
        $sql->execute(array($cartId));

        $data = array();
        if($results = $sql->fetchAll(PDO::FETCH_OBJ)) {
            foreach($results as $result){
                $data[] = self::fillFromDBData($result);
            }
        }
        return $data;
    }

    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO cart_items(cart_id, product_id, amount, datetime) VALUES(?,?,?,NOW())");
        $result = $sql->execute(array($this->cart, $this->product, $this->amount));

        $mci = self::get($this->cart, $this->product);

        $this->product = $mci->product;
        $this->datetime = $mci->datetime;

        return $result;
    }

    public function update(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE cart_items SET amount = ?, datetime = NOW() WHERE cart_id = ? AND product_id = ?");
        return $sql->execute(array($this->amount, $this->cart, $this->product));
    }


    public static function emptyCart($cartId){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM cart_items WHERE cart_id = ?");
        return $sql->execute(array($cartId));
    }

    public function delete(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ?");
        return $sql->execute(array($this->cart, $this->product->id));
    }

    public function add($amount) {
        $this->amount += $amount;
        if($this->amount <= 0){
            $this->delete();
        } else {
            $this->update();
        }
    }

    public function remove($amount){
        $this->add(-$amount);
    }

    public static function fillFromDBData($data){
        $mci = new MCartItem();
        $mci->cart = $data->cart_id;
        $mci->product = MProduct::get($data->product_id);
        $mci->amount = $data->amount;
        $mci->datetime = $data->datetime;

        return $mci;
    }
}