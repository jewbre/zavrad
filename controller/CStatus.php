<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 7.4.2015.
 * Time: 23:25
 */

class CStatus extends CMain{

    public function regular(){
        $this->setData(MStatus::getRegularStatusSet());
        $this->output();
    }
}