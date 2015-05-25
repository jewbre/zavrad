<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 25.5.2015.
 * Time: 4:15
 */

class VDisplayLayout implements ILayout{

    /**
     * @var IView
     */
    private $footer;

    /**
     * @var IView
     */
    private $header;

    /**
     * @var MDesign
     */
    private $design;

    public function VDisplayLayout(MDesign $design){
        $this->design = $design;
        $this->defineHeader();
        $this->defineFooter();
    }

    public function setupLayout(IView $view = null, $data = null)
    {
        $this->header->renderPartial($data);
       ?>
            <div class="component-container">

                <?php $this->generatePlayground(); ?>

            </div>
        <?php
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

    private function generatePlayground(){

        $componentFactory = new ComponentFactory();

        foreach($this->design->data as $name => $data){
            $comp = $componentFactory->generate($data);

            if($comp){
                $comp->render();
            }
        }
    }
}