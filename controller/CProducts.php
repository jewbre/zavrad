<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 10.4.2015.
 * Time: 1:35
 */

class CProducts extends CMain{

    public function all(){
        $params = $this->receiveAjax();
        $this->setData(MProduct::getAll(!empty($params->allData)));
        $this->output();
    }

    public function save(){
        $params = $this->receiveAjax();
        $hasErrors = false;

        if(empty($params->name->value)) {
            $params->name->error = t("productNameEmptyError");
            $params->name->hasError = true;
            $hasErrors = true;
        } else if(MProduct::nameExists($params->name->value)) {
            $params->name->error = t("productNameExistsError");
            $params->name->hasError = true;
            $hasErrors = true;
        } else {
            $params->name->error = "";
            $params->name->hasError = false;
        }

        if(is_numeric($params->price->value) && $params->price->value >= 0) {
            $params->price->error = "";
            $params->price->hasError = false;
        } else {
            $params->price->error = t("invalidPriceAmountError");
            $params->price->hasError = true;
            $hasErrors = true;
        }

        if(!$params->price->hasError) {
            if(empty($params->price->currency)){
                $params->price->error = t("selectCurrencyError");
                $params->price->hasError = true;
                $hasErrors = true;
            } else {
                $params->price->error = "";
                $params->price->hasError = false;
            }
        }

        if($hasErrors) {
            $this->setFailure($params);
            $this->output();
            exit();
        }

        $product = new MProduct();
        $product->name = $params->name->value;
        $product->code = $params->code->value;
        $product->description = $params->description->value;
        $product->excerpt = $params->excerpt->value;
        $product->status = MStatus::AVAILABLE;
        $product->save();

        $product->addPrice($params->price->value, $params->price->currency);
        $product->addCategories($params->categories);
        $product->addImages($params->images);

        $this->setData("success");
        $this->output();
    }

    public function update(){
        $params = $this->receiveAjax();
        $hasErrors = false;

        if(empty($params->name->value)) {
            $params->name->error = t("productNameEmptyError");
            $params->name->hasError = true;
            $hasErrors = true;
        } else if(MProduct::nameExists($params->name->value, $params->id)) {
            $params->name->error = t("productNameExistsError");
            $params->name->hasError = true;
            $hasErrors = true;
        } else {
            $params->name->error = "";
            $params->name->hasError = false;
        }

        if(is_numeric($params->price->value) && $params->price->value >= 0) {
            $params->price->error = "";
            $params->price->hasError = false;
        } else {
            $params->price->error = t("invalidPriceAmountError");
            $params->price->hasError = true;
            $hasErrors = true;
        }

        if(!$params->price->hasError) {
            if(empty($params->price->currency)){
                $params->price->error = t("selectCurrencyError");
                $params->price->hasError = true;
                $hasErrors = true;
            } else {
                $params->price->error = "";
                $params->price->hasError = false;
            }
        }

        if($hasErrors) {
            $this->setFailure($params);
            $this->output();
            exit();
        }

        $product = MProduct::get($params->id);
        $product->name = $params->name->value;
        $product->code = $params->code->value;
        $product->description = $params->description->value;
        $product->excerpt = $params->excerpt->value;
        $product->update();

        $price = $product->getPrice();
        if($params->price->value != $price->price || $price->currency->id != $params->price->currency) {
            $price->price = $params->price->value;
            $price->currency = $params->price->currency;
            $price->update();
        }
        $product->addCategories($params->categories);
        $product->addImages($params->images);

        $this->setData("success");
        $this->output();
    }
}