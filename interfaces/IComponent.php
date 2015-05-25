<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 25.5.2015.
 * Time: 0:43
 */

interface IComponent {
    public function parseData($data);
    public function render();
    public function renderStyle();
    public function renderComponent();

}