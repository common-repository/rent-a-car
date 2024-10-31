<?php
/*
 * This file handles the functions related to payment.
 */
/**
 * This function handles the payments
 *
 */
if ($_REQUEST['cr_ajax_action'] === 'cr_payment_option') {
    add_action('init', 'cr_payment_option');
}

function cr_payment_option() {
    $cr_payment_option = $_POST['payment_selected'];
    $cr_discount_value = isset($_POST['discount']) ? $_POST['discount'] : FALSE;
    $cr_shipping_value = isset($_POST['shipping']) ? $_POST['shipping'] : FALSE;
    list($cr_total, $cr_shipping_weight, $products, $number_of_items_in_cart) = cr_pnj_calculate_cart_price();
    if ($products) {
        list($invoice, $bfname, $blname, $bcity, $baddress, $bstate, $bzip, $bcountry, $bemail) = cr_on_payment_save($cr_total, $cr_shipping_value, $products, $cr_discount_value, $cr_payment_option);
        switch ($cr_payment_option) {
            case 'alertpay':
                $output = cr_alertpay_payment($cr_total, $cr_shipping_value, $cr_discount_value, $invoice, $bfname, $blname, $bcity, $baddress, $bstate, $bzip, $bcountry, $bemail);
                break;
            case 'bank':
                $output = cr_other_payment($invoice);
                break;
            case 'cash':
                $output = cr_other_payment($invoice);
                break;
            case 'mobile':
                $output = cr_other_payment($invoice);
                break;
            case 'delivery':
                $output = cr_other_payment($invoice);
                break;
            default:
                break;
        }
    } else {
        $output = __('There are no products in your cart.', "dp-lang");
        $output = str_replace(Array("\n", "\r"), Array("\\n", "\\r"), addslashes($output));
        echo "jQuery('div.cr-checkout').html('$output');";
        exit ();
    }
    $output = str_replace(Array("\n", "\r"), Array("\\n", "\\r"), addslashes($output));
    echo "jQuery('div#cr_hidden_payment_form').html('$output');";
    cr_pnj_calculate_cart_price(TRUE);
    $products = $_SESSION['cr_products'];
    foreach ($products as $key => $item) {
        unset($products[$key]);
    }
    $_SESSION['cr_products'] = $products;
    unset($_SESSION['cr_shiping_price']);
    echo "jQuery('#cr_payment_form').submit();";
    exit ();
}


/**
 * This function generates AlertPay form
 *
 */
function cr_alertpay_payment($cr_total = FALSE, $cr_shipping_value = FALSE, $cr_discount_value = FALSE, $invoice = FALSE, $bfname = FALSE, $blname = FALSE, $bcity = FALSE, $baddress = FALSE, $bstate = FALSE, $bzip = FALSE, $bcountry = FALSE, $bemail = FALSE) {
    $output = '';
    if ($cr_total) {
        $dp_shopping_cart_settings = get_option('dp_shopping_cart_settings');
        $total_tax = 0.00;
        $total_discount = 0.00;
        $total_shipping = 0.00;
        if ($dp_shopping_cart_settings['discount_enable'] === 'true' && $cr_discount_value) {
            $total_discount = $cr_total * $cr_discount_value / 100;
        }
        if ($dp_shopping_cart_settings['tax'] > 0) {
            $tax_rate = $dp_shopping_cart_settings['tax'];
            $total_tax = ($cr_total - $total_discount) * $tax_rate / 100;
        }
        if ($cr_shipping_value) {
            $total_shipping = $cr_shipping_value;
        }
//        $cr_total = number_format($cr_total+$total_tax+$total_shipping-$total_discount,2);
        $cr_total = number_format($cr_total, 2, '.', '');
        $total_shipping = number_format($total_shipping, 2, '.', '');
        $total_tax = number_format($total_tax, 2, '.', '');
        $total_discount = number_format($total_discount, 2, '.', '');
        $return_path = $dp_shopping_cart_settings['thank_you'];
        $check_return_path = explode('?', $return_path);
        if (count($check_return_path) > 1) {
            $return_path .= '&id=' . $invoice;
        } else {
            $return_path .= '?id=' . $invoice;
        }
        $conversion_rate = 1;
        if ($dp_shopping_cart_settings['alertpay_currency'] != $dp_shopping_cart_settings['dp_shop_currency']) {
            $curr = new DP_CURRENCYCONVERTER();
            $conversion_rate = $curr->convert(1, $dp_shopping_cart_settings['alertpay_currency'], $dp_shopping_cart_settings['dp_shop_currency']);
        }
        $output = '<form name="cr_alertpay_form" id="cr_payment_form"  method="post" action="https://www.alertpay.com/PayProcess.aspx" >
                        <input type="hidden" name="ap_merchant" value="' . $dp_shopping_cart_settings['alertpay_id'] . '" />
                        <input type="hidden" name="ap_purchasetype" value="item-goods" />
                        <input type="hidden" name="ap_currency" value="' . $dp_shopping_cart_settings['alertpay_currency'] . '" />
                        <input type="hidden" name="ap_itemname" value="Your Order No.: ' . $invoice . '" />
                        <input type="hidden" name="ap_amount" value="' . number_format($conversion_rate * $cr_total, 2, '.', '') . '" />
                        <input type="hidden" name="ap_shippingcharges" value="' . number_format($conversion_rate * $total_shipping, 2, '.', '') . '" />
                        <input type="hidden" name="ap_taxamount" value="' . number_format($conversion_rate * $total_tax, 2, '.', '') . '" />
                        <input type="hidden" name="ap_discountamount" value="' . number_format($conversion_rate * $total_discount, 2, '.', '') . '" />
                        <input type="hidden" name="ap_returnurl" value="' . $return_path . '" />
                        <input type="hidden" name="ap_cancelurl" value="' . $return_path . '&status=cancel"/>
                        <input type="hidden" name="ap_fname" value="' . $bfname . '" />
                        <input type="hidden" name="ap_lname" value="' . $blname . '" />
                        <input type="hidden" name="ap_contactemail" value="' . $bemail . '" />
                        <input type="hidden" name="ap_addressline1" value="' . $baddress . '" />
                        <input type="hidden" name="ap_city" value="' . $bcity . '" />
                        <input type="hidden" name="ap_stateprovince" value="QC" />
                        <input type="hidden" name="ap_zippostalcode" value="' . $bzip . '" />
                        <input type="hidden" name="ap_country" value="' . $bcountry . '" />
                  </form>';
    }
    return $output;
}

/**
 * This function generates form for the other payment form
 *
 */
function cr_other_payment($invoice = FALSE) {
    $output = '';
    $dp_shopping_cart_settings = get_option('dp_shopping_cart_settings');
    $return_path = $dp_shopping_cart_settings['thank_you'];
    $check_return_path = explode('?', $return_path);
    if (count($check_return_path) > 1) {
        $return_path .= '&id=' . $invoice;
    } else {
        $return_path .= '?id=' . $invoice;
    }
    $output = '<form name="cr_other_form" id="cr_payment_form" action="' . $return_path . '" method="post">
                    <input type="hidden" name="just_for_the_sake_of_it" value="hmm" />
                </form>';
    return $output;
}
?>