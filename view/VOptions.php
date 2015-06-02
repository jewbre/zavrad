<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 2.3.2015.
 * Time: 20:24
 */

class VOptions implements IView{

    public function renderPartial($data = null){
        ?>
        <section class="main-options" ng-controller="optionsController">
            <div>
                <h3><?=t("optionsTitle")?></h3>
                <hr>
                <form>
                    <fieldset>
                        <div class="form-text-input">
                            <label for="pageTitle"> <?=t("pageTitleLabel");?> </label>
                            <input type="text" name="pageTitle" id="pageTitle" class="text-box" ng-model="options.pageTitle.value" />
                            <div class="inputError">
                                <span ng-bind="options.pageTitle.error"></span>
                            </div>
                        </div>

                        <div class="form-text-input">
                            <label for="pageDescription"> <?=t("pageDescriptionLabel");?> </label>
                            <textarea type="text" name="pageDescription" id="pageDescription" class="text-box description-box" ng-model="options.pageDescription.value"></textarea>
                            <div class="inputError">
                                <span ng-bind="options.pageDescription.error"></span>
                            </div>
                        </div>

                        <div class="form-text-input">
                            <label for="pageExcerpt"> <?=t("pageExcerptLabel");?> </label>
                            <textarea name="pageExcerpt" id="pageExcerpt" class="text-box" ng-model="options.pageExcerpt.value" ></textarea>
                            <div class="inputError">
                                <span ng-bind="options.pageExcerpt.error"></span>
                            </div>
                        </div>


                        <div class="form-text-input">
                            <label for="allowBuying" class="checkbox-label"> <?=t("allowBuyingLabel");?> </label>
                            <input type="checkbox" name="allowBuying" id="allowBuying" class="checkbox" ng-model="options.allowBuying.value" />
                        </div>


                        <div class="form-text-input">
                            <label for="backgroundColor"> <?=t("backgroundColorLabel");?> </label>
                            <input type="text" name="backgroundColor" id="backgroundColor" class="small-text-box" ng-model="options.backgroundColor.value" />
                            <div class="color-box-small" ng-style="{'background-color' : options.backgroundColor.value}"></div>
                        </div>


                        <div class="form-text-input">
                            <label for="textColor"> <?=t("textColorLabel");?> </label>
                            <input type="text" name="textColor" id="textColor" class="small-text-box" ng-model="options.textColor.value" />
                            <div class="color-box-small" ng-style="{'background-color' : options.textColor.value}"></div>
                        </div>

                    </fieldset>
                    <fieldset>
                        <button class="confirm-button-blue" ng-click="save()">
                            <i class="fa fa-spinner fa-lg" ng-if="saving"></i>
                            <?=t("saveLabel")?>
                        </button>
                    </fieldset>

                    <hr>
                    <fieldset>
                    <h2><?=t("menuLabel")?></h2>
                    <div class="form-text-input">
                        <label for="textColor" class="inline-label"> <?=t("menuItems");?> </label>
                                <span class="add-icon" ng-click="menuItemAdd()">
                                    <i class="fa fa-plus-circle fa-lg"></i>
                                </span>
                        <div class="inputError">
                            <span ng-bind="menuItems.error"></span>
                        </div>
                        <div ng-repeat="menuItem in menuItems.items">
                            <input type="text" name="menuItemValue" id="menuItemValue" class="middle-text-box" ng-model="menuItem.value" />
                            <select ng-model="menuItem.url" ng-options="page.url as page.name for page in pages">
                            </select>
                                    <span class="close-icon" ng-click="menuItemRemove(menuItem.id)">
                                        <i class="fa fa-times fa-lg"></i>
                                    </span>
                            <div class="inputError">
                                <span ng-bind="menuItem.error"></span>
                            </div>
                        </div>
                    </div>
                    </fieldset>
                    <fieldset>
                        <button class="confirm-button-blue" ng-click="saveMenu()">
                            <i class="fa fa-spinner fa-lg" ng-if="saving"></i>
                            <?=t("saveLabel")?>
                        </button>
                    </fieldset>

                    <hr>

                    <fieldset>
                        <div class="form-text-input">

                            <div class="form-text-input">
                                <label for="period"> <?=t("sliderPeriodLabel");?> </label>
                                <input type="text" name="period" id="period" class="small-text-box" ng-model="slider.period" />
                                <span>ms (1000ms = 1s, {{slider.period}}ms = {{slider.period/1000}}s)</span>
                            </div>

                            <div ng-repeat="sliderImage in slider.images track by $index">
                                <div class="slider-image-action" ng-click="removeSliderImage($index)">
                                    <i class="fa fa-times fa-lg"></i>
                                </div>
                                <div class="slider-image-action green-text" ng-click="moveSliderImageUp($index)">
                                    <i class="fa fa-caret-square-o-up fa-lg"></i>
                                </div>
                                <div class="slider-image-action red-text" ng-click="moveSliderImageDown($index)">
                                    <i class="fa fa-caret-square-o-down fa-lg"></i>
                                </div>
                                <img ng-src="<?=baseUrl("")?>{{sliderImage.url}}" class="slider-image-preview" />

                            </div>
                            <div class="components-image-holder">
                                <div ng-repeat="image in images" class="component-library-image" >
                                    <img ng-src="{{'/'+image.url}}"  ng-click="addSliderImage(image.url)"/>
                                </div>
                                <div class="show-more" ng-click="getMoreImages()">
                                    <p>Show more</p>
                                </div>
                            </div>
                    </fieldset>
                    <fieldset>
                        <button class="confirm-button-blue" ng-click="saveSlider()">
                            <i class="fa fa-spinner fa-lg" ng-if="saving"></i>
                            <?=t("saveLabel")?>
                        </button>
                    </fieldset>
                </form>
            </div>
        </section>
    <?php
    }
}