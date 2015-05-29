<?php
/**
 * Created by PhpStorm.
 * User: Vilim Stubičan
 * Date: 29.5.2015.
 * Time: 4:56
 */

class PaymentFactory {

    public function handlePayment(MPaymentMethod $pm){

        switch($pm->name){
            case "PayPal" :
                $this->doPaymentGateway($pm);
                break;
        }

    }

    public function doPaymentGateway(MPaymentMethod $pm)
    {
        // for future implementation where gateways will be introduced
    }
}