<?php
error_reporting(0);
//Вводим данные для оплаты
$apiKey = "API";
$apiSecret = "SECRET";
$pay_url = "https://payze.io/api/v1";  //Боевой адрес
$currency = "USD"; //
$link_to_logo = "https://wubook.net/skins/default/img/wubook.png";

// Дальше ничего не менять

$amount =  round($_POST['amount'], 2);
$rcode   = $_POST['reservation_id'];
$ok_url  = $_POST['return_ok'];
$ko_url  = $_POST['return_ko'];
$reservation_info   = json_decode($_POST['reservation_info']);
$email = $reservation_info -> {'customer'} -> {'email'};
$description = 'Reservation ' . $rcode;

$data = array(
    "method" => "justPay",
    "apiKey" => $apiKey,
    "apiSecret" => $apiSecret,
    "data" => array(
        "amount" => $amount,
        "currency" => $currency,
        "callback" => $ok_url,
        "callbackError" => $ko_url,
        "preauthorize" => false,
        "lang" => "EN",
        "hookUrl" => "https://wupay.app/v1",
        "info" => array(
            "description" => $description,
            "image" => $link_to_logo,
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

    $echo_array = array ( 'status' => 'ok', 'link' => $body["response"] ["transactionUrl"] );
    echo json_encode($echo_array);
} else {
    /* Возникла ошибка: */

    $echo_array = array ( 'status' => 'ko', 'reason' => $body['message'] );
    echo json_encode($echo_array);
}
?>
