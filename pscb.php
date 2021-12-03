<?php

# Активируйте прием платежей через форму в Кабинете мерчанта (“Профиль” - “Прием платежей c HTML-формы”).

$script_url = "http://SOME-ADDRESS/pscb.php"; //Адрес где лежит этот скрипт

#  Ваш адрес для запросов:
$request_addr = "";


// Дальше ничего не менять

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $params = array();

    $postData = file_get_contents('php://input');

    $data = urldecode($postData);

    parse_str($data, $params);

    $urlstring = $script_url ."?". http_build_query($params);

    echo $urlstring;

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {

  echo "
  <!DOCTYPE html>
  <html>
   <head>
    <meta charset=\"utf-8\" />
    <link rel=\"stylesheet\" href=\"https://docs.pscb.ru/oos/examples/pscb-payform.css\">
    
    <title>Платеж</title>
   </head>
   <body>

  <div class=\"pscb-payform-container\">
<form class=\"pscb-payform\" action=\"" .$request_addr ."\" method=\"post\">
<h1>Оплата онлайн</h1>

    <!-- Обязательные параметры -->
    <input name=\"marketPlace\" type=\"hidden\" value=\"" .$marketPlace ."\" />
    <label for=\"amount\">Сумма платежа</label><input id=\"amount\" name=\"amount\" type=\"text\" placeholder=\"\" value=\" " . htmlspecialchars($_GET["deposit"]) ."\" readonly /><br>
    <label for=\"customerAccount\">ФИО плательщика</label><input id=\"customerAccount\" name=\"customerAccount\" placeholder=\"\" value=\"". htmlspecialchars($_GET["first_name"]). " " . htmlspecialchars($_GET["last_name"]) ."\" readonly /><br>
    <!-- /Обязательные параметры -->

    <!-- Необязательные параметры -->
    <input id=\"orderId\" name=\"orderId\" type=\"hidden\" value=\" " . htmlspecialchars($_GET["rcode"]) ."\"/>
    <input id=\"showOrderID\" name=\"showOrderId\" type=\"hidden\" value=\"\"/>
    <input id=\"details\" name=\"details\" type=\"hidden\" value=\"\"/>
    <input id=\"successUrl\" name=\"successUrl\" type=\"hidden\" value=\" " . htmlspecialchars($_GET["ok_url"]) ." \"/>
    <input id=\"failUrl\" name=\"failUrl\" type=\"hidden\" value=\" " . htmlspecialchars($_GET["ko_url"]) ." \"/>   
    <label for=\"customerEmail\">E-mail</label><input id=\"customerEmail\" name=\"customerEmail\"  type=\"email\" placeholder=\"" . htmlspecialchars($_GET["email"]) . "\" value=\"\" readonly/><br>
    <label for=\"customerPhone\">Телефон</label><input id=\"customerPhone\" name=\"customerPhone\" type=\"tel\" placeholder=\"\" value=\" " . htmlspecialchars($_GET["phone"])."\" readonly/><br>
    <label for=\"customerComment\">Комментарий</label><input id=\"customerComment\" name=\"customerComment\" type=\"text\" placeholder=\"\" value=\"\" /><br>
    <input name=\"button\" class=\"pscb-button\" type=\"submit\" value=\"Оплатить\"/>
    <!-- /Необязательные параметры -->
</form>
</div>

</body>

  ";

}

?>
