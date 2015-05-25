<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 2.5.2015.
 * Time: 11:30
 */

class MStorageInOut {

    private $id;
    private $storage_card;
    public $type;
    public $amount;
    public $price;
    private $order = null;
    public $datetime;

    public static function get($id){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM storage_inout WHERE id = ?");
        $sql->execute(array($id));
        if($result = $sql->fetch(PDO::FETCH_OBJ)) {
            return self::fillFromDBData($result);
        }
        return null;
    }

    public static function getForStorageCard($id){
        $db = MDBConnection::getConnection();
        $sql = $db->prepare("SELECT * FROM storage_inout WHERE storage_card_id = ?");
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
        $sql = $db->prepare("INSERT INTO storage_inout(storage_card_id, type_id, amount, price, order_id, datetime) VALUES(?,?,?,?,?,NOW())");
        $args = array(
            $this->getStorageCard()->id,
            $this->getType()->id,
            $this->amount,
            $this->getPrice()->id,
        );

        $order = $this->getOrder();
        $args[] = $order == null ? "" : $order->id;

        $result = $sql->execute($args);
        if($result) {
            $sio = self::get($db->lastInsertId());
            $this->id = $sio->id;
            $this->datetime = $sio->datetime;
        }

        return $result;
    }

    public function inOut() {

        if($this->getType()->isIn()) {
            // do in
        } else if($this->getType()->isOut()) {
            // do out
        } else if($this->getType()->isPriceChange()){
            // do price change
        }
    }

    public function saveIn(){
        $this->type = MTypeInOut::getByType(MTypeInOut::TYPE_IN);
        $this->save();
    }

    public function saveOut(){
        $this->type = MTypeInOut::getByType(MTypeInOut::TYPE_OUT);
        $this->save();
    }

    public function saveChanges(){
        $this->type = MTypeInOut::getByType(MTypeInOut::TYPE_PRICE_CHANGE);
        $this->order = null;
        $this->save();
    }
    /**
     * Returns type for provided InOut item.
     * @return MTypeInOut|null
     */
    public function getType(){
        if($this->type instanceof MTypeInOut) {
            return $this->type;
        }
        if(intval($this->type)) {
            $this->type = MTypeInOut::get($this->type);
        } else {
            $this->type = MTypeInOut::getByType($this->type);
        }
        return $this->type;
    }

    /**
     * Returns storage card for provided InOut item.
     * @return MStorageCard|null
     */
    public function getStorageCard(){
        if($this->storage_card instanceof MStorageCard) {
            return $this->storage_card;
        }
        $this->storage_card = MStorageCard::get($this->storage_card);
        return $this->storage_card;
    }

    /**
     * Returns price for provided InOut item.
     * @return MPrice|null
     */
    public function getPrice(){
        if($this->price instanceof MPrice) {
            return $this->price;
        }
        $this->price = MPrice::get($this->price);
        return $this->price;
    }

    /**
     * Returns order id.
     * @return null
     */
    public function getOrder(){
        if($this->order == null) return null;
        return null;
//        if($this->order instanceof MOrder) {
//            return $this->order;
//        }
//        $this->order = MOrder::get($this->order);
//        return $this->order;
    }

    public function setStorageCard($card) {
        $this->storage_card = $card;
    }

    public function setPrice($price) {
        $this->price = $price;
    }


    private static function fillFromDBData($data){
        $sio = new MStorageInOut();
        $sio->id = $data->id;
        $sio->storage_card = $data->storage_card_id;
        $sio->type = $data->type_id;
        $sio->amount = $data->amount;
        $sio->price = $data->price;
        $sio->order = $data->order_id;
        $sio->datetime = $data->datetime;
        return $sio;
    }
}