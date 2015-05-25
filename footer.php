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
        ?>
<section>
    <a href="<?= $data["route"] ?>?lang=en">
        <img src="<?= image("sprites/flags/uk-flag.png") ?>" />
    </a>

    <a href="<?= $data["route"] ?>?lang=cro">
        <img src="<?= image("sprites/flags/cro-flag.png") ?>" />
    </a>
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

    <script src="<?= baseUrl("js/controllers/registration.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/login.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/component.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/builder.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/usersListingCtrl.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/categoryListing.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/mediaLibrary.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/productsController.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/storage.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/cartService.js") ?>"></script>
    <script src="<?= baseUrl("js/controllers/pagesListing.js") ?>"></script>

    <script src="<?= baseUrl("js/controllers/test.js") ?>"></script>

</section>
</html>

<?php
    }
}
?>