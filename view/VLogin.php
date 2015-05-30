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
                    <div class="center-container">
                        <h2><?=t("loginLabel")?></h2>
                        <form>
                            <fieldset>
                                <div class="form-text-input">
                                    <h4> <?=t("emailLabel")?> </h4>
                                    <input type="text" name="email" id="email" class="text-box" ng-model="data.email.value"/>
                                </div>
                                <div class="form-text-input">
                                    <h4> <?=t("passwordLabel")?> </h4>
                                    <input type="password" name="password" id="password" class="text-box" ng-model="data.password.value"/>
                                </div>
                                <div class="inputError">
                                    <span ng-bind="data.error.value"></span>
                                </div>
                            </fieldset>
                            <button type="button" class="confirm-button-blue" ng-click="login()"><?=t("loginLabel")?></button>
                        </form>
                        <div class="sub-message">
                            <?=t("dontHaveAccount")?>
                            <a href="/registration">
                                <?=t("registerLabel")?>
                            </a>
                        </div>
                        <div class="return-link">
                            <a href="/">
                                <i class="fa fa-long-arrow-left fa-lg"></i>
                                <?=t("backToSite")?>
                            </a>
                        </div>
                    </div>
                </section>
            </div>
    <?php
    }

}