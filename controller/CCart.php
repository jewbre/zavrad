<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 15.5.2015.
 * Time: 0:52
 */

class CCart extends CMain{

    public function get(){
        $this->setData(MCart::getUserCart());

        $this->output();
    }

    public function add(){
        $params = $this->receiveAjax();

        $cart = MCart::getUserCart();
        $cart->addItem($params->product, $params->amount);

        $this->get();
    }

    public function remove(){
        $params = $this->receiveAjax();

        $cart = MCart::getUserCart();
        $cart->removeItem($params->product, $params->amount);

        $this->get();
    }
}