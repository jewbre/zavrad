<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 7.4.2015.
 * Time: 23:12
 */

class VCategory {

    public function renderPartial($data = null) {
        ?>
        <section class="category-list-main" ng-controller="categoryListing">
            <div class="new-form-add" ng-if="!editing">
                <div>
                    <form>
                        <fieldset>
                            <div class="form-text-input">
                                <label for="email"> <?=t("nameLabel");?> </label>
                                <input type="text" name="name" id="name" class="text-box" ng-model="data.name" />
                            </div>

                            <div class="form-text-input">
                                <label for="authority"> <?=t("statusLabel");?> </label>
                                <select ng-model="data.status" ng-options="status.id as status.name for status in statuses">
                                </select>
                            </div>

                        </fieldset>
                        <div>
                            <button type="button" class="confirm-button-green" ng-click="add()">
                                <span class="icon-arrow-right-red"></span>
                                <?=t("addLabel")?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="new-form-edit" ng-if="editing">
                <div>
                    <form>
                        <fieldset>
                            <div class="form-text-input">
                                <label for="email"> <?=t("nameLabel");?> </label>
                                <input type="text" name="name" id="name" class="text-box" ng-model="data.name" />
                            </div>

                            <div class="form-text-input">
                                <label for="authority"> <?=t("statusLabel");?> </label>
                                <select ng-model="data.status" ng-options="status.id as status.name for status in statuses">
                                </select>
                            </div>

                        </fieldset>
                        <div>
                            <button type="button" class="confirm-button-blue" ng-click="update()">
                                <span class="icon-arrow-right-red"></span>
                                <?=t("updateLabel")?>
                            </button>

                            <button type="button" class="cancel-button-red" ng-click="cancel()">
                                <span class="icon-arrow-right-red"></span>
                                <?=t("cancelLabel")?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div>

                <table class="grey-table">
                    <thead>
                    <th>
                        <?=t("IDLabel") ?>
                    </th>
                    <th>
                        <?=t("nameLabel") ?>
                    </th>
                    <th>
                        <?=t("statusLabel") ?>
                    </th>
                    <th></th>
                    </thead>
                    <tbody>
                    <tr ng-repeat="category in categories">
                        <td>
                            {{ category.id }}
                        </td>
                        <td>
                            {{ category.name }}
                        </td>
                        <td>
                            {{ category.status }} - {{ statusDescription(category.status) }}
                        </td>
                        <td>

                            <div>
                                <i class="fa fa-pencil-square-o fa-lg" ng-click="edit(category)"></i>
                                <i class="fa fa-times fa-lg" ng-click="delete(category)"></i>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </section>
        <?php
    }
}