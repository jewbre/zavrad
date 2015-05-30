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

        // Style data
        $this->style["background-color"] = $data->template->backgroundColor->value;
        $this->style["color"] = $data->template->textColor->value;


        $this->data["images"] = $data->template->sliderImages->images;
        $this->data["c-width"] = $data->width;
        $this->data["c-height"] = $data->height;
        $this->data["c-position-x"] = $data->position->x;
        $this->data["c-position-y"] = $data->position->y;
        $this->data["menu-items"] = $data->template->menuItems->items;
    }

    public function render()
    {

        $this->renderStyle();

        ?>
        <div class="basic-slider
        component
        c-width-<?=$this->data["c-width"]?>
        c-height-<?=$this->data["c-height"]?>
        c-position-x<?=$this->data["c-position-x"]?>
        c-position-y<?=$this->data["c-position-y"]?>"
        ng-controller="sliderCtrl"
        ng-init="size=<?=count($this->data["images"])?>"    >
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
                    background-color: <?=$this->style["background-color"]?>;
                    color: <?=$this->style["color"]?>;
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
        <?php
    }
}