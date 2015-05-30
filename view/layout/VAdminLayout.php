<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 24.5.2015.
 * Time: 22:33
 */

class VAdminLayout implements ILayout{

    /**
     * @var IView
     */
    private $footer;

    /**
     * @var IView
     */
    private $header;

    public function setupLayout(IView $view = null, $data = null)
    {
        $this->defineFooter();
        $this->defineHeader();

        $this->header->renderPartial($data);

        $this->renderView($view, $data);

        $this->footer->renderPartial($data);
    }

    /**
     * Responsible for setting up footer of the layout.
     */
    public function defineFooter()
    {
        $this->footer = new Footer();
    }

    /**
     * Responsible for setting up header of the layout.
     */
    public function defineHeader()
    {
        $this->header = new Header();
    }

    private function renderView(IView $view, $data) {
        ?>
        <div class="page-header">
            <h1>Header of the page</h1>
        </div>

        <div class="page-content">
            <div class="admin-menu">
                <?php $this->renderMenu(); ?>
            </div>
            <main>
                <?php $view->renderPartial($data); ?>
            </main>
        </div>

        <?php
    }

    private function renderMenu(){
        ?>
            <ul>
                <li>
                    <a href="/admin/options">
                        <?=t("optionsLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/components">
                        <?=t("componentsLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/users">
                        <?=t("usersLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/builder">
                        <?=t("builderLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/category">
                        <?=t("categoriesLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/products">
                        <?=t("productsLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/storage">
                        <?=t("storageLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/media">
                        <?=t("mediaLibraryLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/pages">
                        <?=t("pagesLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/shipping-method">
                        <?=t("shippingMethodsLabel")?>
                    </a>
                </li>

                <li>
                    <a href="/admin/payment-method">
                        <?=t("paymentMethodsLabel")?>
                    </a>
                </li>
            </ul>
        <?php
    }
}