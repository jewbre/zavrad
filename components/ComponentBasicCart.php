<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 29.5.2015.
 * Time: 2:05
 */

class ComponentBasicCart implements IComponent{

    private $style;
    private $data;

    public function ComponentBasicCart($data) {
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
        $this->data["c-width"] = $data->width;
        $this->data["c-height"] = $data->height;
        $this->data["c-position-x"] = $data->position->x;
        $this->data["c-position-y"] = $data->position->y;
    }

    public function render()
    {

        $this->renderStyle();

        ?>
        <div class="basic-cart
        component
        c-width-<?=$this->data["c-width"]?>
        c-height-<?=$this->data["c-height"]?>
        c-position-x<?=$this->data["c-position-x"]?>
        c-position-y<?=$this->data["c-position-y"]?>"
             ng-controller="basicCartCtrl"
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
            .basic-cart {
                background-color: <?=$this->style["background-color"]?>;
                color: <?=$this->style["color"]?>;
            }
        </style>
    <?php
    }

    public function renderComponent()
    {
        ?>
        <div class="cart-content">

            <div class="title">
                <h2><?=t("cartLabel")?></h2>
            </div>
            <hr>
            <table class="cart-table">
                <thead>
                <tr>
                    <th>

                    </th>
                    <th>
                        <?=t("productLabel");?>
                    </th>
                    <th>
                        <?=t("amountLabel");?>
                    </th>
                    <th>
                        <?=t("singlePriceLabel");?>
                    </th>
                    <th>
                        <?=t("totalLabel")?>
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="item in getCartItems() track by $index">
                    <td>
                        {{ $index + 1}}.
                    </td>
                    <td>
                        <i class="fa fa-times" ng-click="removeItems(item)"></i>
                        <a ng-href="/products/{{item.product.id}}">
                            {{ item.product.name }}
                        </a>
                    </td>
                    <td>
                        {{ item.amount}}
                        <i class="fa fa-plus-square" ng-click="addItem(item)"></i>
                        <i class="fa fa-minus-square" ng-click="removeItem(item)"></i>
                    </td>
                    <td>
                        {{ item.product.price.price }} {{ item.product.price.currency.single }}
                    </td>
                    <td>
                        {{ item.product.price.price * item.amount}} {{ item.product.price.currency.single }}
                    </td>
                </tr>
                <tr>
                    <td colspan="4">

                    </td>
                    <td>
                        {{ getTotal() }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    <?php
    }
}