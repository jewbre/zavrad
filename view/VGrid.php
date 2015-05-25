<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 14.3.2015.
 * Time: 17:45
 */

class VGrid implements IView {

    public function renderPartial($data = null){
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

            <div class="builder-action-buttons">
                <div class="design-list">
                    <div class="single-design-item" ng-repeat="design in designs">
                        <div class="single-design-item-name">
                            {{ design.name }}
                        </div>
                        <div class="single-design-item-actions">
                            <i class="fa fa-pencil-square-o fa-lg" ng-click="load(design)"></i>
                            <i class="fa fa-times fa-lg" ng-click="deleteDesign(design)"></i>
                        </div>
                    </div>
                </div>
                <div class="form-text-input">
                    <input type="text" name="design-name" id="design-name" class="text-box" placeholder="<?=t("designNameLabel")?>" ng-model="designName"/>
                    <select ng-options="page.id as page.name for page in pages" ng-model="designPage"></select>
                </div>
                <button class="confirm-button-green" ng-click="save()" ng-disabled="count <= 1"><?=t("saveLabel");?></button>
                <button class="cancel-button-red" ng-click="reset()"><?=t("resetLabel");?></button>
            </div>
        </section>
        <?php
    }

}