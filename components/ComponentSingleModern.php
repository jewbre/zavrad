<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 28.5.2015.
 * Time: 20:58
 */

class ComponentSingleModern implements IComponent {

    private $style;
    private $data;

    public function ComponentSingleModern($data) {
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
        $this->data["cart-enabled"] = isset($data->globalOptions->allowBuying) ? $data->globalOptions->allowBuying : false;
        $this->data["c-width"] = $data->width;
        $this->data["c-height"] = $data->height;
        $this->data["c-position-x"] = $data->position->x;
        $this->data["c-position-y"] = $data->position->y;
        $this->data["product-id"] = $data->productId;
    }

    public function render()
    {

        $this->renderStyle();

        ?>
        <div class="single-modern
        component
        c-width-<?=$this->data["c-width"]?>
        c-height-<?=$this->data["c-height"]?>
        c-position-x<?=$this->data["c-position-x"]?>
        c-position-y<?=$this->data["c-position-y"]?>"
             ng-controller="singleModernCtrl"
            ng-init="pId = <?=$this->data["product-id"]?>"
            >
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
            .single-modern {
                background-color: <?=$this->style["background-color"]?>;
                color: <?=$this->style["color"]?>;
            }
        </style>
    <?php
    }

    public function renderComponent()
    {
        ?>
        <div class="product-images-holder">
            <div class="product-images">
                <div class="images-holder">
                    <div ng-repeat="image in getImages() track by $index"
                         ng-style="{'background-image':'url(/'+image.original.url+')'}"
                         ng-class="{'show':showImage($index),'hide':hideImage($index)}"
                         style="background-color: <?=$this->style["background-color"]?>"
                         class="product-image"
                        >
                    </div>
                </div>
                <div class="image-overlay">
                    <div class="half-overlay" ng-click="nextImage()"></div>
                    <div class="half-overlay" ng-click="previousImage()"></div>
                </div>
            </div>

            <div class="product-details">
                <div class="product-title">
                    <h2>{{ getName() }}</h2>
                </div>
                <hr>
                <div class="product-details">
                    <div class="excerpt">
                        {{ getExcerpt() }}
                    </div>
                    <div class="price">
                        <div class="half left">
                            <i class="fa fa-bookmark-o"></i>
                            <span>
                                {{ getPrice().price }} {{ getPrice().currency.single }}
                            </span>
                        </div>

                        <?php
                            if($this->data["cart-enabled"]){
                                ?>
                                <div class="half right">
                                <button class="cart-button">
                                    <i class="fa fa-shopping-cart"></i>
                                </button>
                                </div>
                                <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="product-description">
                {{ getDescription() }}
            </div>

        </div>
    <?php
    }
}