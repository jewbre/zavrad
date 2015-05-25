<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 10.3.2015.
 * Time: 20:58
 */

class VTest implements IView{

    public function renderPartial($data = null){
        ?>
        <div ng-controller="testController">
            <div style="margin-left:150px;margin-top:150px;border:2px solid red;height:400px;position:relative;background: url('images/sprites/grid-background.png')">0
                <div class="draggable grid-element grid-rows-3 grid-cols-4">
                    D1
                </div>
                <div class="draggable grid-element grid-rows-2 grid-cols-5">
                    D2
                </div>
            </div>
        </div>
        <?php
    }

}