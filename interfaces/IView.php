<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 24.5.2015.
 * Time: 22:29
 */

interface IView {
    public function renderPartial($data = null);
}