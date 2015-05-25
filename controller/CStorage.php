<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 4.5.2015.
 * Time: 22:52
 */

class CStorage extends CMain{

    public function cards() {
        $params = $this->receiveAjax();
        $this->setData(MStorageCard::getByProductId($params->product));

        $this->output();
    }

    public function newCard(){
        $params = $this->receiveAjax();
        $card = new MStorageCard();
        $card->code = $params->card->code;
        $card->amount = $params->card->amount;
        $card->product = $params->product;
        $card->save();

        $this->setData(MStorageCard::getByProductId($params->product));
        $this->output();
    }

    public function getInOut(){
        $params = $this->receiveAjax();
        $inOuts = MStorageInOut::getForStorageCard($params->id);
        for($i = 0; $i< count($inOuts);$i++) {
            $inOuts[$i]->getType();
            $inOuts[$i]->getPrice();
        }
        $this->setData($inOuts);
        $this->output();
    }
}