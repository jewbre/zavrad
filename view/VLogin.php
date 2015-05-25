<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 10.3.2015.
 * Time: 20:11
 */

class VLogin implements IView{

    public function renderPartial($data = null){
        ?>
            <div ng-controller="loginController">
                <section class="login-main">
                    <h2><?=t("loginLabel")?></h2>
                    <form>
                        <fieldset>
                            <div class="form-text-input">
                                <label for="email"> <?=t("emailLabel")?> </label>
                                <input type="text" name="email" id="email" class="text-box" ng-model="data.email.value"/>
                            </div>
                            <div class="form-text-input">
                                <label for="password"> <?=t("passwordLabel")?> </label>
                                <input type="password" name="password" id="password" class="text-box" ng-model="data.password.value"/>
                            </div>
                            <div class="inputError">
                                <span ng-bind="data.error.value"></span>
                            </div>
                        </fieldset>
                        <button type="button" class="confirm-button-blue" ng-click="login()"><?=t("loginLabel")?></button>
                    </form>
                </section>
            </div>
        <?php
    }

}