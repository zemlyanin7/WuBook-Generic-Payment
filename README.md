# WuBook-Generic-Payment
Тут собраны скрипты для самостоятельного использования WuBook Payment Gateway

## Сбербанк

По умолчанию используется ссылка для тестового окружения.
Закоментируйте $pay_url с тестовым адресом и раскоментируйте с боевым.

Укажите свой логин и пароль в переменных $userName и $password. Для доступа по АПИ к вашему логину должен быть добавлен суффикс -api.

![image](https://user-images.githubusercontent.com/47315993/113978159-45beca00-984c-11eb-932a-cb810688a0ca.png)

После чего разметите файл Sberbank.php на своем хостинге и в настройках Generic WuBook Payment gateway нужно разместить ссылку на на этот файл.
Например: http://адрессайта/sberbank.php

Настроитe Wubook следующим образом:
В личном кабинете подключите платежный шлюз: WuBook Payment Gateway:

![image](https://user-images.githubusercontent.com/47315993/113978386-8fa7b000-984c-11eb-9df2-3482edea2c2b.png)

В поле ACK Url вписать путь к файлу со скриптом на Вашем хостинге:

![image](https://user-images.githubusercontent.com/47315993/113978418-99311800-984c-11eb-9c79-6c6e7ecf3ab7.png)

Настройте оплату картой:

![image](https://user-images.githubusercontent.com/47315993/113978457-a4844380-984c-11eb-97de-555fb1ec68a6.png)


В процессе бронирования пользователю будет предложено оплатить бронирование через Сбербанк.


## CloudPayments

