<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 11.3.2015.
 * Time: 23:04
 */

class VComponents {

    public function renderPartial(){
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
                                <input type="text" name="name" id="name" class="text-box" ng-model="component.template.value" />
                                <div class="inputError">
                                    <span ng-bind="component.template.error"></span>
                                </div>
                            </div>

                            <div class="form-text-input">
                                <label><?=t("componentDimensions")?></label>
                                <input type="text" name="width" id="width" class="small-text-box" ng-model="component.dimensions.width" />
                                x
                                <input type="text" name="height" id="height" class="small-text-box" ng-model="component.dimensions.height" />
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
                        <button type="button" class="confirm-button-green" ng-click="save()" ng-if="!editing">
                            <i class="fa fa-plus-square-o fa-lg"></i>
                            <?=t("addLabel")?>
                        </button>

                        <button type="button" class="confirm-button-blue" ng-click="update()" ng-if="editing">
                            <i class="fa fa-check-square-o fa-lg"></i>
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
                            <th><?=t("templateLabel")?></th>
                            <th><?=t("dimensionsLabel")?></th>
                            <th><?=t("decriptionLabel")?></th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr ng-repeat="component in components">
                                <td>{{ component.name }}</td>
                                <td>{{ component.template }}</td>
                                <td>{{ component.width }} x {{ component.height }}</td>
                                <td>{{ component.description }}</td>
                                <td>
                                    <span ng-click="edit(this)" class="action-button">
                                        <i class="fa fa-pencil-square-o fa-lg"></i>
                                    </span>

                                    <span ng-click="delete(this)" class="action-button">
                                        <i class="fa fa-trash fa-lg"></i>
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