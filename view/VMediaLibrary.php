<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 9.4.2015.
 * Time: 0:28
 */

class VMediaLibrary implements IView{

    public function renderPartial($data = null){
        ?>

        <section class="media-library" ng-controller="mediaLibrary">
            <div>
                <form id="fileUploadForm">
                    <input type="file" multiple="multiple" id="file"/>
                </form>

                <div class="media-library-image-holder">
                    <div ng-repeat="image in images" class="media-library-image" >
                        <div class="image-delete" ng-click="delete(image)">
                            <i class="fa fa-times fa-lg"></i>
                        </div>
                        <img ng-src="{{'/'+image.url}}"  ng-click="showGallery(image)"/>
                    </div>
                </div>
                <div class="show-more" ng-click="getImages()">
                    <p>
                        <?=t("showMoreLabel")?>
                    </p>
                </div>
            </div>


            <div class="gallery">
                <div class="exit-area" ng-click="hideGallery()"></div>
                <div class="gallery-holder">
                    <div class="gallery-big">
                        <div class="gallery-controls gallery-previous" ng-click="previous()">
                            <div class="ruler"></div>
                            <i class="fa fa-chevron-left fa-2x"></i>
                        </div>
                        <div class="gallery-ruler"></div>
                        <img ng-src="{{'/' + gallery.selected.url}}" class="gallery-main-image"/>
                        <div class="gallery-controls gallery-next" ng-click="next()">
                            <div class="ruler"></div>
                            <i class="fa fa-chevron-right fa-2x"></i>
                        </div>
                    </div>
                    <hr>
                    <div class="gallery-small">
                        <img ng-repeat="image in gallery.images" ng-src="{{'/' + image.url}}" ng-class="{gallerySelected:isSelected(image)}"
                            ng-click="showGallery(image)"/>
                    </div>
                </div>
            </div>
        </section>

        <?php
    }
}