<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 18:31
 */

class Header implements IView
{

    public function renderPartial($data = null)
    {
        $options = isset($data->globalOptions) ? $data->globalOptions : MOption::getAll();

        $headerData = new stdClass();
        $headerData->slider = $options->slider->value;
        $headerData->menuItems = $options->menuItems->value;
        ?>

        <!DOCTYPE html>
        <html ng-app="webshop-app">
        <head lang="en">
            <meta charset="UTF-8">
            <title><?=$options->pageTitle->value?></title>

            <link href='http://fonts.googleapis.com/css?family=Lora' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
            <link href='<?= baseUrl("css/main.css") ?>' rel='stylesheet' type='text/css'>
            <link href='<?= baseUrl("css/style.css") ?>' rel='stylesheet' type='text/css'>
            <link href='<?= baseUrl("css/components-style.css") ?>' rel='stylesheet' type='text/css'>

            <?php
            if($data["routeElements"][1] != "admin") {
                ?>
                <style>
                    html, body {
                        background-color: <?=$options->backgroundColor->value?>;
                        color: <?=$options->textColor->value?>;
                    }
                </style>
            <?php
            }
            ?>
        </head>
        <body>

        <?php
            if($data["renderHeader"]) {
                $header = new ComponentSlider($headerData);
                $header->render();
            }
        ?>

        <div style="position:relative">

    <?php }
}?>