<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 19:14
 */

class COptions {

    public $options = array();

    public function get(){
        MOption::getAll();
    }
}