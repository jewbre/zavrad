<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 2.5.2015.
 * Time: 10:59
 */

class MStorageCard {

    public $id;
    public $product;
    public $code;
    public $amount;
    public $opened;
    public $closed;

    public static function get($id){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM storage_card WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return self::fillFromDBData($result);
        }
        return null;
    }

    /**
     * @param $id
     * @param bool $ignoreFull
     * @return MStorageCard[]
     */
    public static function getByProductId($id, $ignoreFull = false){
        $db = MDBConnection::getConnection();
        if($ignoreFull) {
            $query = "SELECT * FROM storage_card WHERE product_id = ? AND closed IS NULL ORDER BY id ASC";
        } else {
            $query = "SELECT * FROM storage_card WHERE product_id = ? ORDER BY id ASC";
        }
        $sql = $db->prepare($query);
        $sql->execute(array($id));
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
        $sql = $db->prepare("INSERT INTO storage_card(product_id, code, amount, opened) VALUES(?,?,?,NOW())");
        $result = $sql->execute(array(intval($this->product), $this->code, intval($this->amount)));
        if($result) {
            $sc = self::get($db->lastInsertId());
            $this->id = $sc->id;
            $this->opened = $sc->opened;
            $this->closed = $sc->closed;
            $this->doIn();
            return true;
        }
        return false;
    }

    private function doIn(){
        $sio = new MStorageInOut();
        $sio->setStorageCard($this);
        $sio->amount = $this->amount;
        $sio->setPrice(MPrice::get($this->product));
        $sio->saveIn();
    }

    public function doPriceChange(MPrice $old, MPrice $new)
    {
        $diff = intval($new->price) - intval($old->price);
        $mio = new MStorageInOut();
        $mio->setStorageCard($this);
        $mio->amount = $diff * $this->remaining();
        $mio->setPrice($new);
        $mio->type = MTypeInOut::TYPE_PRICE_CHANGE;
        $mio->save();
    }



    public function closeCard(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("UPDATE storage_card SET closed = NOW() WHERE id = ?");
        return $sql->execute(array($this->product));
    }

    private static function fillFromDBData($data){
        $sc = new MStorageCard();
        $sc->id = $data->id;
        $sc->product = $data->product_id;
        $sc->code = $data->code;
        $sc->amount = $data->amount;
        $sc->opened = $data->opened;
        $sc->closed = $data->closed;
        return $sc;
    }

    public static function getRemaining($productId){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT SUM(amount) as total FROM storage_inout WHERE storage_card_id IN (SELECT id FROM storage_card WHERE product_id = ?) AND type_id = ?");
        $sql->execute(array($productId, MTypeInOut::TYPE_IN));
        $totalIn = $sql->fetch(PDO::FETCH_OBJ)->total;

        $sql->execute(array($productId, MTypeInOut::TYPE_OUT));
        $totalOut = $sql->fetch(PDO::FETCH_OBJ)->total;
        return $totalIn - $totalOut;
    }

    public function remaining(){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT SUM(amount) as total FROM storage_inout WHERE storage_card_id = ? AND type_id = ?");
        $sql->execute(array($this->id, MTypeInOut::TYPE_OUT));
        return $this->amount - intval($sql->fetch(PDO::FETCH_OBJ)->total);
    }

    public static function removeAmount($productId, $amount) {
        $cards = self::getByProductId($productId);

        foreach($cards as $card) {

        }

    }
}