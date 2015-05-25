<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 3.5.2015.
 * Time: 0:08
 */

class ComponentBasicListing implements IComponent{

    private $style;
    private $data;

    public function ComponentBasicListing($data) {
        $this->style = array();
        $this->data = array();

        $this->parseData($data);
    }

    public function parseData($data)
    {
        // Style data
        $this->style["background-color"] = $data->template->backgroundColor->value;
        $this->style["color"] = $data->template->textColor->value;

        // Additional data
        $this->data["cart-enabled"] = isset($data->cartEnabled) ? $data->cartEnabled : false;
        $this->data["c-width"] = $data->width;
        $this->data["c-height"] = $data->height;
        $this->data["c-position-x"] = $data->position->x;
        $this->data["c-position-y"] = $data->position->y;
    }

    public function render()
    {

        $this->renderStyle();

        ?>
        <div class="basic-listing
        component
        c-width-<?=$this->data["c-width"]?>
        c-height-<?=$this->data["c-height"]?>
        c-position-x<?=$this->data["c-position-x"]?>
        c-position-y<?=$this->data["c-position-y"]?>">
        <?php
            $this->renderComponent();
        ?>
        </div>
        <?php
    }

    public function renderStyle()
    {
        ?>
        <style>
            .basic-listing {
                background-color: <?=$this->style["background-color"]?>;
                color: <?=$this->style["color"]?>;
                border:1px solid black;
            }
        </style>
        <?php
    }

    public function renderComponent()
    {
        ?>
            <div class="flip-container product-basic" ng-repeat="product in pagedProducts()">
                <div class="flipper">
                    <div class="front" ng-style="{'background-image':'url('+product.images[0].url+')'}">
                        <div class="main-description">
                            {{ product.name }}
                        </div>
                    </div>
                    <div class="back">
                        <div class="main-description">
                            {{ product.description }}
                        </div>
                    </div>
                </div>
            </div>
        <?php
    }
}