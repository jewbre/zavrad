<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 25.5.2015.
 * Time: 3:49
 */

class ComponentFactory {
    const BASIC_LISTING_1 = "basic-listing-1";
    const BASIC_LISTING_2 = "basic-listing-2";

    const BASIC_MENU_1 = "basic-menu-1";

    const SLIDER_FIRST = "slider-1";

    const SINGLE_MODERN = "single-modern";
    /**
     * @param $data
     * @return IComponent
     */
    public function generate($data, $externalData = null) {
        $data->globalOptions = MOption::getAll();
        switch($data->template->name){
            case self::BASIC_LISTING_1 :
                return new ComponentBasicListing($data);
            case self::BASIC_LISTING_2 :
                return new ComponentModernListing($data);

            case self::BASIC_MENU_1 :
                return new ComponentBasicMenu($data);


            case self::SLIDER_FIRST :
                return new ComponentSlider($data);


            case self::SINGLE_MODERN:
                $data->productId = $externalData["routeElements"][2];
                return new ComponentSingleModern($data);
        }

        return false;
    }
}