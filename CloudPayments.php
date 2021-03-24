<?php

//Вводим данные для оплаты

$publicId = 'test_api_00000000000000000000001'; //Взять из личного кабинета 
$hotelName = 'Название отеля';
$pay_url = "https://somesite/CloudPayments.php"; //Адрес где лежит этот скрипт
$currency= "RUB"; //Валюта RUB/USD/EUR/GBP/KZT


// Дальше ничего не менять
$deposit = '';
$rcode   = '';
$ok_url  = '';
$ko_url  = '';
$email   = '';

$params = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $postData = file_get_contents('php://input');

    $data = urldecode($postData);

    parse_str($data, $params);

    $deposit = $params['deposit'];
    $rcode   = $params['rcode'];
    $ok_url  = $params['ok_url'];
    $ko_url  = $params['ko_url'];
    $email   = $params['email'];


    $ch = $pay_url . "?amount=" . intval($deposit) . "&invoiceId=" . $rcode  . "&returnUrl=" . $ok_url . "&failUrl=" . $ko_url . "&email=" . $email;
    

    echo $ch;

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

echo "
<!DOCTYPE html>
<html>
 <head>
  <meta charset=\"utf-8\" />
  <title>HTML5</title>
  
  <script src=\"https://widget.cloudpayments.ru/bundles/cloudpayments\"></script>
  
 </head>
 <body>

<script> 
window.onload = function () {
    var widget = new cp.CloudPayments();
       widget.pay('charge',
           { //options
               publicId: '". $publicId ."', //id из личного кабинета
               description: 'Оплата за проживание в отеле ". $hotelName . " по бронированию №" . htmlspecialchars($_GET["invoiceId"]) ."', 
               amount: " . htmlspecialchars($_GET["amount"]) .", //сумма
               currency: '". $currency ."', //валюта
               accountId: '". htmlspecialchars($_GET["email"]) ."', //идентификатор плательщика (необязательно)
               invoiceId: '". htmlspecialchars($_GET["invoiceId"]) ."', //номер заказа  (необязательно)
               skin: \"mini\", //дизайн виджета (необязательно)
               data: {
                   myProp: 'myProp value'
               }
           },
           {
               onSuccess: function (options) { // success
                document.location.replace(\"". htmlspecialchars($_GET["returnUrl"]) ."\");
               },
               onFail: function (reason, options) { // fail
                document.location.replace(\"". htmlspecialchars($_GET["failUrl"]) ."\");
                   
               },
               onComplete: function (paymentResult, options) { //Вызывается как только виджет получает от api.cloudpayments ответ с результатом транзакции.
                   //например вызов вашей аналитики Facebook Pixel
               }
           }
       )
   };


   </script>

   </body>
   </html>
";


}


?>
