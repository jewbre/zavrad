<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 1.3.2015.
 * Time: 18:31
 */

class Footer{

    public function renderPartial($data = null)
    {
        $languages = array("en", "cro");

        ?>
<section class="language-options" style="width:<?=count($languages)*30?>px">

    <?php
            foreach($languages as $lang) {
                ?>
                <a href="<?= $data["route"] ?>?lang=<?=$lang?>" <?= isCurrentLanguage($lang) ? 'class="active"' : '' ?>>
                    <img src="<?= image("sprites/flags/".$lang."-flag.png") ?>"/>
                </a>
            <?php
            }
                ?>
</section>

</body>

<section>
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
    <script src="<?= baseUrl("js/basic/angular.min.js") ?>"></script>
    <script src="<?= baseUrl("js/basic/common.js")?>"></script>



    <script src="<?= baseUrl("js/controllers/main.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/head.js") ?>"></script>

    <script src="<?= baseUrl("js/services/imageUpload.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/cartService.js") ?>"></script>
    <script src="<?= baseUrl("js/services/productListingService.js") ?>"></script>
    <script src="<?= baseUrl("js/services/imagesService.js") ?>"></script>
    <script src="<?= baseUrl("js/services/singleProductService.js") ?>"></script>

    <script src="<?= baseUrl("js/controllers/registration.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/login.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/component.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/builder.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/usersListingCtrl.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/categoryListing.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/mediaLibrary.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/productsController.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/storage.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/pagesListing.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/options.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/shippingMethod.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/paymentMethod.js") ?>"></script>

    <script src="<?= baseUrl("js/controllers/test.js") ?>"></script>

<!--    Components scripts-->
    <script src="<?= baseUrl("js/components/basicListingCtrl.js") ?>"></script>
    <script src="<?= baseUrl("js/components/sliderCtrl.js") ?>"></script>
    <script src="<?= baseUrl("js/components/singleModernCtrl.js") ?>"></script>
    <script src="<?= baseUrl("js/components/basicCartCtrl.js") ?>"></script>

</section>
</html>

<?php
    }
}
?>