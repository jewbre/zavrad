<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 2.3.2015.
 * Time: 20:24
 */

class VOptions {

    public function renderPartial(){
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
                    </fieldset>
                </form>
            </div>
        </section>
    <?php
    }
}