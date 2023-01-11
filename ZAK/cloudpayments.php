<?php
error_reporting(0);
//Вводим данные для оплаты

$publicId = 'pk_42228bfbe1b35f73d3059b4ef2278'; //Взять из личного кабинета
$hotelName = 'Название отеля';
$pay_url = "https://wupay.app/v1/test/cloudpayments.php"; //Адрес где лежит этот скрипт
$currency= "RUB"; //Валюта RUB/USD/EUR/GBP/KZT


// Дальше ничего не менять
$amount = '';
$transaction_id   = '';
$return_ok  = '';
$return_ko  = '';
$email   = '';

$params = array();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $amount = $_POST['amount'];
    $currency   = $_POST['currency'];
    $epid  = $_POST['epid'];
    $reservation_id  = $_POST['reservation_id'];
    $return_ok   = $_POST['return_ok'];
    $return_ko   = $_POST['return_ko'];
    $reservation_info   = json_decode($_POST['reservation_info']);
    $email = $reservation_info -> {'customer'} -> {'email'};

    $ch = $pay_url . "?amount=" . round($amount, 2) . "&invoiceId=" . $reservation_id . "&returnUrl=" . $return_ok . "&failUrl=" . $return_ko . "&email=" . $email;

    $echo_array = array ( 'status' => 'ok', 'link' => $ch );
   echo json_encode($echo_array);

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

    echo "
<!DOCTYPE html>
<html>
 <head>
  <meta charset=\"utf-8\" />
  <title>ORDER</title>
  
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
