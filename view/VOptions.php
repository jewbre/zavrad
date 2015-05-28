<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 2.3.2015.
 * Time: 20:24
 */

class VOptions implements IView{

    public function renderPartial($data = null){
        ?>
        <section class="main-options" ng-controller="optionsController">
            <div>
                <h3><?=t("optionsTitle")?></h3>
                <hr>
                <form>
                    <fieldset>
                        <div class="form-text-input">
                            <label for="pageTitle"> <?=t("pageTitleLabel");?> </label>
                            <input type="text" name="pageTitle" id="pageTitle" class="text-box" ng-model="options.pageTitle.value" />
                            <div class="inputError">
                                <span ng-bind="options.pageTitle.error"></span>
                            </div>
                        </div>

                        <div class="form-text-input">
                            <label for="pageDescription"> <?=t("pageDescriptionLabel");?> </label>
                            <textarea type="text" name="pageDescription" id="pageDescription" class="text-box description-box" ng-model="options.pageDescription.value"></textarea>
                            <div class="inputError">
                                <span ng-bind="options.pageDescription.error"></span>
                            </div>
                        </div>

                        <div class="form-text-input">
                            <label for="pageExcerpt"> <?=t("pageExcerptLabel");?> </label>
                            <textarea name="pageExcerpt" id="pageExcerpt" class="text-box" ng-model="options.pageExcerpt.value" ></textarea>
                            <div class="inputError">
                                <span ng-bind="options.pageExcerpt.error"></span>
                            </div>
                        </div>


                        <div class="form-text-input">
                            <label for="allowBuying" class="checkbox-label"> <?=t("allowBuyingLabel");?> </label>
                            <input type="checkbox" name="allowBuying" id="allowBuying" class="checkbox" ng-model="options.allowBuying.value" />
                        </div>


                        <div class="form-text-input">
                            <label for="backgroundColor"> <?=t("backgroundColorLabel");?> </label>
                            <input type="text" name="backgroundColor" id="backgroundColor" class="small-text-box" ng-model="options.backgroundColor.value" />
                            <div class="color-box-small" ng-style="{'background-color' : options.backgroundColor.value}"></div>
                        </div>


                        <div class="form-text-input">
                            <label for="textColor"> <?=t("textColorLabel");?> </label>
                            <input type="text" name="textColor" id="textColor" class="small-text-box" ng-model="options.textColor.value" />
                            <div class="color-box-small" ng-style="{'background-color' : options.textColor.value}"></div>
                        </div>

                    </fieldset>
                    <fieldset>
                        <button class="confirm-button-blue" ng-click="save()">
                            <i class="fa fa-spinner fa-lg" ng-if="saving"></i>
                            <?=t("saveLabel")?>
                        </button>
                    </fieldset>
                </form>
            </div>
        </section>
    <?php
    }
}