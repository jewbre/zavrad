<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 25.5.2015.
 * Time: 16:06
 */

class ComponentSlider implements IComponent {

    private $style;
    private $data;

    public function ComponentSlider($data){
        $this->style = array();
        $this->data = array();

        $this->parseData($data);
    }

    public function parseData($data)
    {
        $this->data["images"] = $data->slider->images;
        $this->data["period"] = $data->slider->period;
        $this->data["menu-items"] = $data->menuItems->items;
    }

    public function render()
    {

        $this->renderStyle();

        ?>
        <div class="header" xmlns="http://www.w3.org/1999/html">
        <div class="basic-slider" ng-controller="sliderCtrl"
        ng-init="size=<?=count($this->data["images"])?>; period=<?=$this->data["period"]?>">
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
        .basic-menu {
            background-color: #b7b7b7;
        }
        </style>
        <?php
    }

    public function renderComponent()
    {
        $i = 0;
        $size = count($this->data["images"])-1;
        foreach($this->data["images"] as $image){
            ?>
            <div class="slider-item"
                ng-class="{'active-item':amIActive(<?=$i?>),'next-item':amINext(<?=$i?>),'prev-item':amIPrev(<?=$i?>)}"
                style="background-image:url('<?=baseUrl($image->url)?>')">
            </div>
            <?php
            $i++;
        }
        ?>
        <div class="basic-menu">
            <div class="menu-items">
                <div class="ruler"></div>
                <?php
                foreach($this->data["menu-items"] as $menuItem){
                    ?>
                    <a href="<?=$menuItem->url?>" class="menu-item">
                        <?=$menuItem->value?>
                    </a>
                <?php
                }
                ?>
            </div>
            <div class="user-actions">
                <?php
                    if(CLogin::isLoggedIn()) {
                        ?>
                        <a href="/user">
                            <i class="fa fa-user fa-lg"></i>
                        </a>
                        <a href="/cart">
                            <i class="fa fa-shopping-cart fa-lg"></i>
                        </a>
                        <?php
                        if(CLogin::getLoggedIn()->isAdmin()) {
                            ?>
                            <a href="/admin">
                                <i class="fa fa-cog fa-lg"></i>
                            </a>
                        <?php
                        }
                        ?>
                        <a href="/logout">
                            <i class="fa fa-power-off fa-lg"></i>
                        </a>

                    <?php
                    } else {
                        ?>
                        <a href="/registration">
                            <?=t("registerLabel")?>
                        </a>
                        <a href="/login">
                            <?=t("loginLabel")?>
                        </a>
                    <?php
                    }
                ?>
            </div>
        </div>
    </div>
        <?php
    }
}