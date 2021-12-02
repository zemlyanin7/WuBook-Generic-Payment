<?php


# Uniteller Point ID (как правило, 8 цифр) из Личного кабинета, раздел "Точки продажи"
$Shop_IDP = "";
# Password (80 символов) из Личного кабинета, раздел "Параметры авторизации"
$password = "";


// Дальше ничего не менять

$request_addr = "https://wpay.uniteller.ru/pay/";

$params = array();

$postData = file_get_contents('php://input');

$data = urldecode($postData);

parse_str($data, $params);


$Signature = strtoupper( md5(
    md5($Shop_IDP) . "&" .
    md5($params['rcode']) . "&" .
    md5($params['deposit']) . "&" .
    md5("") . "&" .
    md5("") . "&" .
    md5("") . "&" .
    md5("") . "&" .
    md5("") . "&" .
    md5("") . "&" .
    md5("") . "&" .
    md5($password)
    ) );

$url_param = array(  
                'Shop_IDP'      => $Shop_IDP,
                'Order_IDP'     => $params['rcode'],
                'Subtotal_P'    => $params['deposit'],
                'Signature'     => $Signature,
                'URL_RETURN_OK' => $params['ok_url'],
                'URL_RETURN_NO' => $params['ko_url'],
                'Currency'      => "RUB",
                'Email'         => $params['email'],
                'FirstName'     => $params['first_name'],
                'LastName'      => $params['last_name'],
                'Address'       => $params['address'],
                'City'          => $params['city'],
                'Zip'           => $params['zip']
            );



if ($url_param['Email'] === null) {
    $url_param['Email'] = "";
};

if ($url_param['FirstName'] === null) {
    $url_param['FirstName'] = "";
};

if ($url_param['LastName'] === null) {
    $url_param['LastName'] = "";
};

if ($url_param['Address'] === null) {
    $url_param['Address'] = "";
};

if ($url_param['City'] === null) {
    $url_param['City'] = "";
};

if ($url_param['Zip'] === null) {
    $url_param['Zip'] = "";
};

# echo implode($url_param);

$urlstring = $request_addr ."?". http_build_query($url_param);

echo $urlstring;

?>


