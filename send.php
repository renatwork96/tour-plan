<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$phone = $_POST['phone'];
$message = $_POST['message'];
$email = $_POST['email'];

// Формирование самого письма
$title = "New appeal Best Tour Plan";
$body = "
<h2>New appeal</h2>
<b>Name:</b> $name<br>
<b>Phone number:</b> $phone<br>
<b>E-mail:</b> $email<br><br>
<b>Message:</b><br>$message
";

$body2 = "
<h2>New appeal</h2>
<b>E-mail:</b> $email<br>
";

$body3 = "
<h2>New appeal</h2>
<b>Name:</b> $name<br>
<b>Phone number:</b> $phone<br><br>
<b>Message:</b><br>$message
";

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
     
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'renatbiz.mail@gmail.com'; // Логин на почте
    $mail->Password   = 'sIpwTZaY'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('renatbiz.mail@gmail.com', 'Khakov Renat'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('chakov_renat@mail.ru');

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone'])) {
        $mail->Body = $body; 
    } else if (isset($_POST['email'])) {  
        $mail->Body = $body2;
    } else if (isset($_POST['name']) && isset($_POST['phone'])) {  
        $mail->Body = $body3;
    } 

// Проверяем отравленность сообщения
if ($mail->send()) {$result = "success";} 
else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
header('Location: thankyou.html');