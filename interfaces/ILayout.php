<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 24.5.2015.
 * Time: 22:33
 */

interface ILayout {

    public function setupLayout(IView $view = null, $data = null);

    /**
     * Responsible for setting up footer of the layout.
     */
    public function defineFooter();

    /**
     * Responsible for setting up header of the layout.
     */
    public function defineHeader();

}