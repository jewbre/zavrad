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
        $this->data["images"] = $data->template->sliderImages->images;
        $this->data["c-width"] = $data->width;
        $this->data["c-height"] = $data->height;
        $this->data["c-position-x"] = $data->position->x;
        $this->data["c-position-y"] = $data->position->y;
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
        // nothing to style internali
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
    }
}