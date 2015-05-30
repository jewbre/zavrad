<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 7.3.2015.
 * Time: 13:27
 */

class VRegistration implements IView{

    public function renderPartial($data = null){
        ?>
        <div ng-controller="registrationController">
            <section class="registration-main">
                <div class="center-container">
                    <h3>{{ successMessage }}</h3>
                    <form>
                        <fieldset>
                            <div class="form-text-input">
                                <h4><?=t("emailLabel");?> </h4>
                                <input type="text" name="email" id="email" class="text-box" ng-class="{errorBorder: data.email.hasError}" ng-model="data.email.value" />
                                <div class="inputError">
                                    <span ng-bind="data.email.error"></span>
                                </div>
                            </div>


                            <div class="form-text-input">
                                <h4> <?=t("passwordLabel");?> </h4>
                                <input type="password" name="password" id="password" class="text-box" ng-class="{errorBorder: data.password.hasError}" ng-model="data.password.value" />
                                <div class="inputError">
                                    <span ng-bind="data.password.error"></span>
                                </div>
                            </div>


                            <div class="form-text-input">
                                <h4> <?=t("passwordRepeatLabel");?> </h4>
                                <input type="password" name="password-repeat" id="password-repeat" class="text-box" ng-class="{errorBorder: data.passwordRepeat.hasError}" ng-model="data.passwordRepeat.value" />
                                <div class="inputError">
                                    <span ng-bind="data.passwordRepeat.error"></span>
                                </div>
                            </div>
                        </fieldset>
                            <div>
                                <button type="button" class="confirm-button-white" ng-click="register()">
                                    <span class="icon-arrow-right-red"></span>
                                    <?=t("registerLabel")?>
                                </button>
                            </div>
                    </form>
                    <div class="sub-message">
                        <?=t("alreadyHaveAccount")?>
                        <a href="/login">
                            <?=t("loginLabel")?>
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