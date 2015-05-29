<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 10.4.2015.
 * Time: 0:33
 */

class VProducts implements IView{

    public function renderPartial($data = null) {
        ?>
            <section ng-controller="productsController">
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
                                </div>

                                <div class="form-text-input">
                                    <label for="code"> <?=t("codeLabel");?> </label>
                                    <input type="text" name="code" id="code" class="text-box" ng-model="data.code.value" />
                                    <div class="inputError">
                                        <span ng-bind="data.code.error"></span>
                                    </div>
                                </div>

                                <div class="form-text-input">
                                    <label for="price"> <?=t("priceLabel");?> </label>
                                    <input type="text" name="price" id="price" class="small-text-box" ng-model="data.price.value" />
                                    <select ng-model="data.price.currency" ng-options="currency.id as currency.code + ' - ' + currency.name  for currency in currencies">
                                        <option value=""><?=t("selectCurrencyLabel")?></option>
                                    </select>
                                    <div class="inputError">
                                        <span ng-bind="data.price.error"></span>
                                    </div>
                                </div>

                                <div class="form-text-input">
                                    <label for="description"> <?=t("descriptionLabel");?> </label>
                                    <textarea name="description" id="description" class="text-box description-box" ng-model="data.description.value"></textarea>
                                    <div class="inputError">
                                        <span ng-bind="data.description.error"></span>
                                    </div>
                                </div>

                                <div class="form-text-input">
                                    <label for="excerpt"> <?=t("excerptLabel");?> </label>
                                    <textarea name="excerpt" id="excerpt" class="text-box" ng-model="data.excerpt.value" ></textarea>
                                    <div class="inputError">
                                        <span ng-bind="data.excerpt.error"></span>
                                    </div>
                                </div>

                                <div class="form-text-input">
                                    <label for="categories"> <?=t("categoryLabel");?> </label>
                                    <select ng-model="data.categories" ng-options="category.id as category.name for category in categories" multiple="multiple">
                                    </select>
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
                    <div class="products-images">
                        <form id="fileUploadForm">
                            <input type="file" multiple="multiple" id="file"/>
                        </form>
                        <hr>
                        <div class="products-image-holder">
                            <div ng-repeat="image in images" class="products-image" ng-class="{gallerySelected:isSelected(image)}" ng-click="toggleSelect(image)">
                                <img ng-src="{{'/'+image.url}}" />
                            </div>
                        </div>
                        <div class="show-more" ng-click="getImages()">
                            <p>
                                <?=t("showMoreLabel")?>
                            </p>
                        </div>
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
                            <?=t("codeLabel") ?>
                        </th>
                        <th>
                            <?=t("priceLabel") ?>
                        </th>
                        <th>
                            <?=t("descriptionLabel") ?>
                        </th>
                        </thead>
                        <tbody>
                        <tr ng-repeat="product in products">
                            <td>
                                {{ product.id }}
                            </td>
                            <td>
                                <i class="fa fa-pencil-square-o fa-lg" ng-click="edit(product)"></i>
                                <i class="fa fa-times fa-lg" ng-click="delete(product)"></i>
                                {{ product.name }}
                            </td>
                            <td>
                                {{ product.code }}
                            </td>
                            <td>
                                {{ product.price.price }} {{ product.price.currency.single }}
                            </td>
                            <td>
                                {{ product.description }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </section>
        <?php
    }
}