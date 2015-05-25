<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 25.3.2015.
 * Time: 22:11
 */

class VUsers implements IView{

    public function renderPartial($data = null) {
        ?>
        <section class="users-cms-main">
            <div ng-controller="userListingCtrl">
                <div class="new-form-add" ng-if="!editing">
                    <div>
                        <form>
                            <fieldset>
                                <div class="form-text-input">
                                    <label for="email"> <?=t("emailLabel");?> </label>
                                    <input type="text" name="email" id="email" class="text-box" ng-class="{errorBorder: data.email.hasError}" ng-model="data.email.value" />
                                    <div class="inputError">
                                        <span ng-bind="data.email.error"></span>
                                    </div>
                                </div>


                                <div class="form-text-input">
                                    <label for="password"> <?=t("passwordLabel");?> </label>
                                    <input type="password" name="password" id="password" class="text-box" ng-class="{errorBorder: data.password.hasError}" ng-model="data.password.value" />
                                    <div class="inputError">
                                        <span ng-bind="data.password.error"></span>
                                    </div>
                                </div>


                                <div class="form-text-input">
                                    <label for="authority"> <?=t("authorityLabel");?> </label>
                                    <select ng-model="data.authority.value" ng-options="authority.value as authority.name for authority in authorities">

                                    </select>
                                    <div class="inputError">
                                        <span ng-bind="data.authority.error"></span>
                                    </div>
                                </div>

                            </fieldset>
                            <div>
                                <button type="button" class="confirm-button-green" ng-click="addNewUser()">
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
                                    <label for="email"> <?=t("emailLabel");?> </label>
                                    <input type="text" name="email" id="email" class="text-box" ng-class="{errorBorder: data.email.hasError}" ng-model="data.email.value" disabled/>
                                    <div class="inputError">
                                        <span ng-bind="data.email.error"></span>
                                    </div>
                                </div>


                                <div class="form-text-input">
                                    <label for="password"> <?=t("passwordLabel");?> </label>
                                    <input type="password" name="password" id="password" class="text-box" ng-class="{errorBorder: data.password.hasError}" ng-model="data.password.value" />
                                    <div class="inputError">
                                        <span ng-bind="data.password.error"></span>
                                    </div>
                                </div>


                                <div class="form-text-input">
                                    <label for="authority"> <?=t("authorityLabel");?> </label>
                                    <select ng-model="data.authority.value" ng-options="authority.value as authority.name for authority in authorities">

                                    </select>
                                    <div class="inputError">
                                        <span ng-bind="data.authority.error"></span>
                                    </div>
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
                                <?=t("emailLabel") ?>
                            </th>
                            <th>
                                <?=t("authorityLabel") ?>
                            </th>
                            <th></th>
                        </thead>
                        <tbody>
                            <tr ng-repeat="user in users">
                                <td>
                                    {{ user.id }}
                                </td>
                                <td>
                                    {{ user.email }}
                                </td>
                                <td>
                                    {{ user.authority }}
                                </td>
                                <td>

                                    <div>
                                        <i class="fa fa-pencil-square-o fa-lg" ng-click="edit(user)"></i>
                                        <i class="fa fa-times fa-lg" ng-click="delete(user)"></i>
                                    </div>
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