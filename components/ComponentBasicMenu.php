<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 27.5.2015.
 * Time: 23:45
 */

class ComponentBasicMenu implements IComponent{

    private $style;
    private $data;

    public function ComponentBasicMenu($data) {
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
        $this->data["menu-items"] = $data->template->menuItems->items;

    }

    public function render()
    {

        $this->renderStyle();

        ?>
        <div class="basic-menu
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
            .basic-menu {
                background-color: <?=$this->style["background-color"]?>;
                color: <?=$this->style["color"]?>;
            }
        </style>
    <?php
    }

    public function renderComponent()
    {
        ?>
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
    <?php
    }
}