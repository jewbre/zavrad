<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 25.5.2015.
 * Time: 3:49
 */

class ComponentFactory {
    const BASIC_LISTING_1 = "basic-listing-1";
    const BASIC_MENU_1 = "basic-menu-1";
    const SLIDER_FIRST = "slider-1";

    /**
     * @param $data
     * @return IComponent
     */
    public function generate($data) {
        switch($data->template->name){
            case self::BASIC_LISTING_1 :
                return new ComponentBasicListing($data);
            case self::SLIDER_FIRST :
                return new ComponentSlider($data);
        }

        return false;
    }
}