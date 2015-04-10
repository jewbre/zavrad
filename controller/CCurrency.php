<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 10.4.2015.
 * Time: 1:46
 */

class CCurrency extends CMain {

    public function all(){
        $this->setData(MCurrency::getAll(true));
        $this->output();
    }
}