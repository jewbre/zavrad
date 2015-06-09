<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 3.6.2015.
 * Time: 0:46
 */

class Layer {

    /**
     * @var Layer[]
     */
    public $layers;
    public $layerCount;

    public $children;
    public $childCount;

    public $width;
    public $height;
    public $x;
    public $y;

    public $empty;
    public $absolute;

    public $parentChildren;
    public $parentLayers;

    /**
     * @var Layer|null
     */
    public $parent = null;

    /**
     * @var bool
     */
    public $horizontalLayer;

    public function Layer($horizontal = true, $parent = null)
    {
        $this->horizontalLayer = $horizontal;
        $this->layers = array();
        $this->layerCount = 0;

        $this->children = array();
        $this->childCount = 0;

        $this->empty = false;
        $this->absolute = false;

        $this->parentChildren = -1;
        $this->parentLayers = -1;

        $this->parent = $parent;
    }


    public function sortIntoLayers()
    {
        if($this->childCount <= 1) return;

        foreach($this->children as $child){
            if($this->layerCount == 0) {

                $layer = new Layer(!$this->horizontalLayer, $this);
                $layer->x = $this->horizontalLayer ? $this->x : $child->position->x;
                $layer->y = $this->horizontalLayer ? $child->position->y : $this->y;
                $layer->width = $this->horizontalLayer ? $this->width : $child->width;
                $layer->height = $this->horizontalLayer ? $child->height : $this->height;
                $layer->parentChildren = $this->childCount;
                $layer->parentLayers = $this->layerCount + 1;
                $layer->addChild($child);
                $this->addLayer($layer);
            } else {
                $intersecting = false;
                foreach($this->layers as $layer) {
                    if($this->checkIntersection($layer, $child)) {
                        // intersection
                        // must add it to that layer
                        $layer->addChild($child);
                        $layer->updateMargins($child);
                        $intersecting = true;
                        break;
                    }
                }

                if($intersecting) {
                    // There was some adding to one layer. Check if there are some collisions with updated layers.
                    $this->checkLayerIntersections();
                } else {
                    // There was no conflicts, add new layer
                    $layer = new Layer(!$this->horizontalLayer, $this);
                    $layer->x = $this->horizontalLayer ? $this->x : $child->position->x;
                    $layer->y = $this->horizontalLayer ? $child->position->y : $this->y;
                    $layer->width = $this->horizontalLayer ? $this->width : $child->width;
                    $layer->height = $this->horizontalLayer ? $child->height : $this->height;

                    $layer->parentChildren = $this->childCount;
                    $layer->parentLayers = $this->layerCount + 1;
                    $layer->addChild($child);
                    $this->addLayer($layer);
                }

            }

        }


        // If there is a posibility where I see there is no possible layerization any more, skip it.
        // This is the situation when both I and my parent have the same amount of children (but greater than 1)
        // and both have exactly 1 layer.
        if($this->parentLayers > 0) {
            if($this->parentLayers == 1 && $this->layerCount == 1 && $this->parentChildren > 1 && $this->childCount > 1) {
                $this->absolute = true;
                return;
            }
        }

        // if there is no more need for recursion, let the children layers do their work.
        for($i = 0; $i < $this->layerCount; $i++) {
            $this->layers[$i]->sortIntoLayers();
        }
    }

    private function checkLayerIntersections()
    {
        $layers = array();
        $lCount = 0;

        foreach($this->layers as $layer){
            if($lCount == 0) {
                $layers[] = $layer;
                $lCount++;
            } else {
                $intersecting = false;
                foreach($layers as $l) {
                    if($this->layerIntersection($l, $layer)) {
                        foreach($layer->children as $child){
                            $l->addChild($child);
                            $l->updateMargins($child);
                        }
                        $intersecting = true;
                        break;
                    }
                }

                // If there was no intersections, add layer to the array.
                if(!$intersecting) {
                    $layers[] = $layer;
                    $lCount++;
                }
            }
        }

        $doAgain = false;
        if($this->layerCount != $lCount) $doAgain = true;

        $this->layers = $layers;
        $this->layerCount = $lCount;

        ////////////////////////////////////////////////////////
        //
        //  Explanation:
        //
        //  With cases like :
        //
        //  _____________         _
        //  |1          |          |
        //  |_ _ _ _ _ _|  _        > Layer 1
        //  |3_ _ _ _ _ |   |     _|
        //  |___________|    > Layer 3      _
        //  |2_ _ _ _ _ |  _|                |_ Layer 2
        //  |___________|                   _|
        //
        //  Where layers are checked in order 1->2->3, algorithm will only
        //  combine 1 and 3 into *:
        //  ____________
        //  |*          |
        //  |           |
        //  |           |
        //  |___________|
        //  |2 _ _ _ _ _|
        //  |___________|
        //
        //  This case is for horizontal check. Vertical is the same case.
        //  As seen, there we need one more check up to make this block a proper block.
        //
        //
        ///////////////////////////////////////////////////////

        if($doAgain) {
            $this->checkLayerIntersections();
        }

    }

    private function updateMargins($lastChild)
    {
        $onHorizontalLayer = !$this->horizontalLayer;
        $child = $lastChild;
        if($onHorizontalLayer) {
            if($this->y > $child->position->y) {
                $this->height += abs($this->y - $child->position->y);
                $this->y = $child->position->y;
            };

            if($this->y + $this->height < $child->position->y + $child->height){
                $this->height = $child->position->y + $child->height - $this->y;
            }
        } else {
            if($this->x > $child->position->x) {
                $this->width += abs($this->x - $child->position->x);
                $this->x = $child->position->x;
            };

            if($this->x + $this->width < $child->position->x + $child->width){
                $this->width = $child->position->x + $child->width - $this->x;
            }
        }
    }

    /**
     * @param Layer $layer
     * @param $child
     * @return bool
     */
    private function checkIntersection(Layer $layer, $child)
    {
        if($this->horizontalLayer) {
            // do horizontal check up
            if($layer->y < ($child->position->y + $child->height) && ($layer->y + $layer->height) > $child->position->y) {
                return true;
            } else {
                return false;
            }

        } else {
            // do vertical check up
            if($layer->x < ($child->position->x + $child->width) && ($layer->x + $layer->width) > $child->position->x) {
                return true;
            } else {
                return false;
            }
        }
    }

    private function layerIntersection(Layer $first, Layer $second)
    {
        if($this->horizontalLayer) {
            // do horizontal check up
            if($first->y < ($second->y + $second->height) && ($first->y + $first->height) > $second->y) {
                return true;
            } else {
                return false;
            }

        } else {
            // do vertical check up
            if($first->x < ($second->x + $second->width) && ($first->x + $first->width) > $second->x) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function addChild($child)
    {
        $this->children[] = $child;
        $this->childCount++;
    }

    public function addLayer(Layer $layer)
    {
        $this->layers[] = $layer;
        $this->layerCount++;
    }

    public function drawLayers($externalData)
    {
        $style = "";
        if($this->parent != null) {
            if($this->horizontalLayer) {
                $style = 'style="width: '.($this->width / $this->parent->width * 100).'%"';
            } else {
                $style = 'style="min-height: '.($this->height / $this->parent->height * 100).'%"';
            }
        } else {
            if($this->horizontalLayer) {
                $style = 'style="width: 100%"';
            }
        }

        echo $this->horizontalLayer ? '<div class="vertical-layer" '.$style.'>' : '<div class="horizontal-layer" '.$style.'>';

        if($this->childCount == 1){
            $componentFactory = new ComponentFactory();

            $comp = $componentFactory->generate($this->children[0], $externalData);

            if($comp){
                $comp->render();
            }
        } else {

            foreach($this->layers as $layer){
                $layer->drawLayers($externalData);
            }
        }

        echo '</div>';
    }
}







