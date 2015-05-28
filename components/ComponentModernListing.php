<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 27.5.2015.
 * Time: 22:19
 */

class ComponentModernListing implements IComponent {


    private $style;
    private $data;

    public function ComponentModernListing($data) {
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
        <div class="modern-listing
        component
        c-width-<?=$this->data["c-width"]?>
        c-height-<?=$this->data["c-height"]?>
        c-position-x<?=$this->data["c-position-x"]?>
        c-position-y<?=$this->data["c-position-y"]?>"
             ng-controller="basicListingCtrl">
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
            .modern-listing {
                background-color: <?=$this->style["background-color"]?>;
                color: <?=$this->style["color"]?>;
            }
        </style>
    <?php
    }

    public function renderComponent()
    {
        ?>
        <div class="products-container">
            <a ng-repeat="product in products" ng-style="{'background-image':'url('+product.images[0].url+')'}" class="product-container" ng-href="/products/{{product.id}}">
                    <div class="product-overlay">
                        <div class="ruler"></div>
                        <div class="product-data">
                            <div class="product-title">
                                {{ product.name }}
                            </div>
                            <div class="product-details">
                                <div class="product-description">
                                    {{ product.excerpt }}
                                </div>
                                <div class="details two">
                                    <div>
                                        <i class="fa fa-bookmark-o"></i>
                                        <span>
                                            {{ product.price.price }} {{ product.price.currency.single }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </a>
        </div>
    <?php
    }
}