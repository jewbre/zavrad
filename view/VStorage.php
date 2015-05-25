<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 4.5.2015.
 * Time: 22:33
 */

class VStorage implements IView{

    public function renderPartial($data = null) {
        ?>
        <section class="main-options" ng-controller="storageController">
<!--            Adding section-->
            <div>
                <form>
                    <fieldset>
                        <div class="form-text-input">
                            <label for="code"> <?=t("codeLabel");?> </label>
                            <input type="text" name="code" id="code" class="text-box" ng-model="service.card.code" />
                        </div>
                        <div class="form-text-input">
                            <label for="amount"> <?=t("amountLabel");?> </label>
                            <input type="text" name="amount" id="amount" class="text-box" ng-model="service.card.amount" />
                        </div>
                    </fieldset>
                    <button type="button" class="confirm-button-blue" ng-click="service.save()">
                        <span class="icon-arrow-right-red"></span>
                        <?=t("saveLabel")?>
                    </button>
                </form>
                <div class="inputError">
                    <span ng-bind="service.error"></span>
                </div>
            </div>
<!--            Display section -->
            <div>
                <select ng-options="product.id as product.name for product in service.products" ng-model="service.currentProduct" ng-change="service.productCards()">
                    <option value="">-- Select product</option>
                </select>
                <table class="grey-table">
                    <thead>
                        <th>
                            Code
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            Date opened
                        </th>
                        <th>
                            Date closed
                        </th>
                    </thead>
                    <tbody>
                        <tr ng-repeat="card in service.cards" ng-click="service.cardDetails(card.id)">
                            <td>
                                {{ card.code }}
                            </td>
                            <td>
                                {{ card.amount }}
                            </td>
                            <td>
                                {{ card.opened }}
                            </td>
                            <td>
                                {{ card.closed }}
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table class="grey-table">
                    <thead>
                        <th>
                            Type
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            Single item
                        </th>
                        <th>
                            Total
                        </th>
                        <th>
                            Date
                        </th>
                    </thead>
                    <tbody>
                        <tr ng-repeat="inout in service.inouts">
                            <td>
                                {{ inout.type.name }}
                            </td>
                            <td>
                                {{ inout.amount }}
                            </td>
                            <td>
                                {{ inout.price.price }} {{ inout.price.currency.single }}
                            </td>
                            <td>
                                {{ total(inout.id) }}
                            </td>
                            <td>
                                {{ inout.datetime }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <?php
    }
}