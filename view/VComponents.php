<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 11.3.2015.
 * Time: 23:04
 */

class VComponents implements IView{

    public function renderPartial($data = null){
        ?>
        <section class="components-main" ng-controller="componentsController">
            <div>
                <div>
                    <h2><?=t("componentsLabel")?></h2>
                </div>
                <div class="form-holder">
                    <form>
                        <fieldset>
                            <div class="form-text-input">
                                <label for="name"><?=t("componentName")?></label>
                                <input type="text" name="name" id="name" class="text-box" ng-model="component.name.value" />
                                <div class="inputError">
                                    <span ng-bind="component.name.error"></span>
                                </div>
                            </div>

                            <div class="form-text-input">
                                <label for="name"><?=t("componentTemplate")?></label>
                                <select ng-model="selected.template" ng-options="template.name for template in templates" ng-disabled="editing">
                                    <option value="" disabled><?=t("selectTemplateLabel")?></option>
                                </select>
                                <div class="inputError">
                                    <span ng-bind="component.template.error"></span>
                                </div>
                            </div>

                            <div class="form-text-input">
                                <label><?=t("componentDimensions")?></label>
                                <input type="text" name="width" id="width" class="small-text-box" ng-model="component.dimensions.width" placeholder="<?=t("widthLabel")?>"/>
                                x
                                <input type="text" name="height" id="height" class="small-text-box" ng-model="component.dimensions.height" placeholder="<?=t("heightLabel")?>"/>
                                <div class="inputError">
                                    <span ng-bind="component.dimensions.error"></span>
                                </div>
                            </div>

                            <div class="form-text-input">
                                <label for="description"> <?=t("componentDescription");?> </label>
                                <textarea name="description" id="description" class="text-box description-box" ng-model="component.description.value"></textarea>
                                <div class="inputError">
                                    <span ng-bind="component.description.error"></span>
                                </div>
                            </div>
                        </fieldset>
                        <hr>
                        <fieldset>
                            <div class="form-text-input" ng-if="hasOption('backgroundColor')">
                                <label for="backgroundColor"> <?=t("backgroundColorLabel");?> </label>
                                <input type="text" name="backgroundColor" id="backgroundColor" class="small-text-box" ng-model="component.template.backgroundColor.value" />
                                <div class="color-box-small" ng-style="{'background-color' : component.template.backgroundColor.value}"></div>
                                <div class="inputError">
                                    <span ng-bind="component.template.backgroundColor.error"></span>
                                </div>
                            </div>


                            <div class="form-text-input" ng-if="hasOption('textColor')">
                                <label for="textColor"> <?=t("textColorLabel");?> </label>
                                <input type="text" name="textColor" id="textColor" class="small-text-box" ng-model="component.template.textColor.value" />
                                <div class="color-box-small" ng-style="{'background-color' : component.template.textColor.value}"></div>
                                <div class="inputError">
                                    <span ng-bind="component.template.textColor.error"></span>
                                </div>
                            </div>

                            <div class="form-text-input" ng-if="hasOption('menuItems')">
                                <label for="textColor" class="inline-label"> <?=t("menuItems");?> </label>
                                <span class="add-icon" ng-click="menuItemAdd()">
                                    <i class="fa fa-plus-circle fa-lg"></i>
                                </span>
                                <div class="inputError">
                                    <span ng-bind="component.template.menuItems.error"></span>
                                </div>
                                <div ng-repeat="menuItem in component.template.menuItems.items">
                                    <input type="text" name="menuItemValue" id="menuItemValue" class="middle-text-box" ng-model="menuItem.value" />
                                    <select ng-model="menuItem.url" ng-options="page.url as page.name for page in pages">
                                        <option value="" disabled><?=t("selectTemplateLabel")?></option>
                                    </select>
                                    <span class="close-icon" ng-click="menuItemRemove(menuItem.id)">
                                        <i class="fa fa-times fa-lg"></i>
                                    </span>
                                    <div class="inputError">
                                        <span ng-bind="menuItem.error"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-text-input" ng-if="hasOption('sliderImages')">
                                <div ng-repeat="sliderImage in component.template.sliderImages.images track by $index">
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
                                    <div class="show-more" ng-click="getMoreImages()">Show more</div>
                                </div>
                            </div>

                        </fieldset>
                        <button type="button" class="confirm-button-green" ng-click="save()" ng-if="!editing">
                            <i class="fa fa-spinner fa-lg" ng-if="saving"></i>
                            <i class="fa fa-plus-square-o fa-lg" ng-if="!saving"></i>
                            <?=t("addLabel")?>
                        </button>

                        <button type="button" class="confirm-button-blue" ng-click="update()" ng-if="editing">
                            <i class="fa fa-spinner fa-lg" ng-if="saving"></i>
                            <i class="fa fa-plus-square-o fa-lg" ng-if="!saving"></i>
                            <?=t("updateLabel")?>
                        </button>

                        <button type="button" class="cancel-button-red" ng-click="cancel()" ng-if="editing">
                            <i class="fa fa-times fa-lg"></i>
                            <?=t("cancelLabel")?>
                        </button>
                    </form>
                </div>
                <div class="listing-holder">
                    <table class="listing-table">
                        <thead>
                            <th><?=t("nameLabel")?></th>
                            <th><?=t("dimensionsLabel")?></th>
                            <th><?=t("decriptionLabel")?></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr ng-repeat="component in components">
                                <td>{{ component.name }}</td>
                                <td>{{ component.width }} x {{ component.height }}</td>
                                <td>{{ component.description }}</td>
                                <td>
                                    <span ng-click="edit(this)" class="action-button" ng-if="!deleting">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </span>

                                    <span ng-click="delete(this)" class="action-button" ng-if="!deleting">
                                        <i class="fa fa-trash fa-lg"></i>
                                    </span>

                                    <span class="action-button" ng-if="deleting">
                                        <i class="fa fa-spinner fa-lg"></i>
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        <?php
    }

}