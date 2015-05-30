<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 30.5.2015.
 * Time: 18:37
 */

class VPaymentMethods implements IView{

    public function renderPartial($data = null) {
        ?>
        <section ng-controller="paymentMethodController">
            <div class="add-products">
                <div class="products-form">
                    <form>
                        <fieldset>
                            <div class="form-text-input">
                                <label for="name"> <?=t("nameLabel");?> </label>
                                <input type="text" name="name" id="name" class="text-box" ng-model="data.name.value" />
                                <div class="inputError">
                                    <span ng-bind="data.name.error"></span>
                                </div>

                                <div class="form-text-input">
                                    <label for="authority"> <?=t("statusLabel");?> </label>
                                    <select ng-model="data.status.value" ng-options="status.id as status.name for status in statuses">
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <div ng-if="editing">
                            <button type="button" class="confirm-button-blue" ng-click="update()">
                                <span class="icon-arrow-right-red"></span>
                                <?=t("updateLabel")?>
                            </button>

                            <button type="button" class="cancel-button-red" ng-click="cancel()">
                                <span class="icon-arrow-right-red"></span>
                                <?=t("cancelLabel")?>
                            </button>
                        </div>
                        <div ng-if="!editing">
                            <button type="button" class="confirm-button-green" ng-click="save()">
                                <span class="icon-arrow-right-red"></span>
                                <?=t("addLabel")?>
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
                    </thead>
                    <tbody>
                    <tr ng-repeat="paymentMethod in paymentMethods">
                        <td>
                            {{ paymentMethod.id }}
                        </td>
                        <td>
                            <i class="fa fa-pencil-square-o fa-lg" ng-click="edit(paymentMethod)"></i>
                            <i class="fa fa-times fa-lg" ng-click="delete(paymentMethod)"></i>
                            {{ paymentMethod.name }}
                        </td>
                        <td>
                            {{ paymentMethod.status.name }}
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </section>
    <?php
    }

}