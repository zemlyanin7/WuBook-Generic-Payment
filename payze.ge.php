<?php

//Вводим данные для оплаты
$apiKey = "B3078DCD11CF4A5CBA0B79D53E246A6D";
$apiSecret = "C7FB94C4754B4730840BF9B948C858A5";
$pay_url = "https://payze.io/api/v1";  //Боевой адрес
$currency = "USD"; //

// Дальше ничего не менять

$deposit =  round($_POST['deposit'], 2);
$rcode   = $_POST['rcode'];
$ok_url  = $_POST['async_ok_url'];
$ko_url  = $_POST['ko_url'];
$email = $_POST['email'];
//$reservation_info   = json_decode($_POST['reservation_info']);
//$email = $reservation_info -> {'customer'} -> {'email'};
$description = 'Reservation ' . $rcode;

$data = array(
    "method" => "justPay",
    "apiKey" => $apiKey,
    "apiSecret" => $apiSecret,
    "data" => array(
        "amount" => $deposit,
        "currency" => $currency,
        "callback" => $ok_url,
        "callbackError" => $ko_url,
        "preauthorize" => false,
        "lang" => "EN",
        "hookUrl" => "https://wupay.app/v1",
        "info" => array(
            "description" => $description,
            "image" => "https://wubook.net/skins/default/img/wubook.png",
            "name" => $description,
        ),
        "hookRefund" => false,
    ),
);

$postdata = json_encode($data);

$ch = curl_init($pay_url );
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept : application/json'));
$res = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curl_info = curl_getinfo($ch);
curl_close($ch);
$header_size = $curl_info['header_size'];
$body = substr($res, $header_size);

$body = json_decode($body, JSON_OBJECT_AS_ARRAY);

if ($httpcode === 200) {
    /* Успех: */
    /* Перенаправление клиента на страницу оплаты */

    echo $body["response"] ["transactionUrl"];
} else {
    /* Возникла ошибка: */

    echo  $body['message'] ;
}
?>
