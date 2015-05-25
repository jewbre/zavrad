<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 24.5.2015.
 * Time: 22:11
 */

class VPages implements IView{


    public function renderPartial($data = null) {
        ?>
        <section class="category-list-main" ng-controller="pagesListing">
            <div class="new-form-add" ng-if="!editing">
                <div>
                    <form>
                        <fieldset>
                            <div class="form-text-input">
                                <label for="name"> <?=t("nameLabel");?> </label>
                                <input type="text" name="name" id="name" class="text-box" ng-model="data.name" />
                            </div>

                            <div class="form-text-input">
                                <label for="name"> <?=t("URLLabel");?> </label>
                                <input type="text" name="name" id="name" class="text-box" ng-model="data.url" />
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
                                <label for="name"> <?=t("URLLabel");?> </label>
                                <input type="text" name="name" id="name" class="text-box" ng-model="data.url" />
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
                        <?=t("URLLabel") ?>
                    </th>
                    <th></th>
                    </thead>
                    <tbody>
                    <tr ng-repeat="page in pages">
                        <td>
                            {{ page.id }}
                        </td>
                        <td>
                            {{ page.name }}
                        </td>
                        <td>
                            {{ page.url }}
                        </td>
                        <td>

                            <div>
                                <i class="fa fa-pencil-square-o fa-lg" ng-click="edit(page)"></i>
                                <i class="fa fa-times fa-lg" ng-click="delete(page)"></i>
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