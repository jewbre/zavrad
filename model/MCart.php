<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.5.2015.
 * Time: 0:07
 */

class MCart {

    public $hash;
    public $id;
    public $items;

    public function MCart(){
        $this->items = array();
    }

    public static function get($id) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM cart WHERE id = ?");
        $sql->execute(array($id));

        if($result = $sql->fetch(PDO::FETCH_OBJ)){
            $c = new MCart();
            $c->id = $result->id;
            $c->hash = $result->user_hash;
            return $c;
        }
        return null;
    }

    public static function getByHash($hash) {
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM cart WHERE user_hash = ?");
        $sql->execute(array($hash));

        if($result = $sql->fetch(PDO::FETCH_OBJ)){
            $c = new MCart();
            $c->id = $result->id;
            $c->hash = $result->user_hash;
            return $c;
        }
        return null;
    }

    public function save(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("INSERT INTO cart(user_hash) VALUES(?)");
        $result = $sql->execute(array($this->hash));

        $this->id = $db->lastInsertId();

        return $result;
    }

    public function getItems(){
        $this->items = MCartItem::getFromCart($this->id);
        return $this->items;
    }

    public function addItem($productId, $amount){
        $ci = MCartItem::get($this->id, $productId);
        if($ci != null) {
            $ci->add($amount);
        } else {
            $ci = new MCartItem();
            $ci->cart = $this->id;
            $ci->product = $productId;
            $ci->amount = $amount;
            $ci->save();
        }
        $this->getItems();
    }

    public function removeItem($productId, $amount){
        $ci = MCartItem::get($this->id, $productId);
        if($ci != null) {
            $ci->remove($amount);
        }
        $this->getItems();
    }
    public function emptyCart(){
        MCartItem::emptyCart($this->id);
    }

    private static function createHashForUser($user_id){
        return crypt($user_id . "cart", "$6$" . $user_id);
    }

    public static function getUserCart(){
        if(CLogin::isLoggedIn()) {
            $user = CLogin::getLoggedIn();
            $cart = self::getByHash(self::createHashForUser($user->_id));
            if($cart != null){
                return $cart;
            }

            $hash = self::createHashForUser($user->_id);
        } else {
            if(isset($_SESSION["cart-hash"])) {
                return self::getByHash($_SESSION["cart-hash"]);
            }

            $hash = self::createHashForUser(rand() . time() . rand() );
        }

        $cart = new MCart();
        $cart->hash = $hash;
        $cart->save();

        return $cart;
    }
}