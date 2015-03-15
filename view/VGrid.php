<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 14.3.2015.
 * Time: 17:45
 */

class VGrid {

    public function renderPartial(){
        ?>
        <section class="grid-main" ng-controller="builderController">
            <div class="component-models-holder">
                <div class="controls previous" ng-click="listModels('left')">
                    <div class="ruler"></div>
                    <i class="fa fa-chevron-left fa-2x"></i>
                </div>
                <div class="controls next" ng-click="listModels('right')">
                    <div class="ruler"></div>
                    <i class="fa fa-chevron-right fa-2x"></i>
                </div>
                <div class="wrapper" data-id="wrapper">
                    <div class="component-model" ng-repeat="component in components">

                        <div class="component-model-add" ng-click="addNewComponent(this)">
                            <img src="<?=image("sprites/add-icon.png")?>"/>
                        </div>
                        <div class="component-model-name">
                            {{ component.name }}
                        </div>

                        <div class="component-model-dimensions">
                            {{ component.width }} x {{ component.height }}
                        </div>

                        <div class="ruler"></div>
                        <div ng-class="['small-grid-cols-'+component.width, 'small-grid-rows-'+component.height]"
                            class="component-model-small">
                        </div>
                    </div>
                </div>
            </div>

            <div class="the-grid" data-id="theGrid">
                <div class="window-ruler">
                    <span class="center-text">
                        <?=t("windowPageRuler")?>
                    </span>
                </div>
            </div>
        </section>
        <?php
    }

}