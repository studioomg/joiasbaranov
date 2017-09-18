<?php 

//======================================================================
// Variables
//======================================================================


//E-mail address. Enter your email
define("__TO__", "contato@joiasbaranov.com.br");

//Success message
define('__SUCCESS_MESSAGE__', "Mensagem enviada. Entrarei em contato muito em breve!");

//Error message 
define('__ERROR_MESSAGE__', "Oops! Não conseguimos enviar a mensagem dente de novo.");

//Messege when one or more fields are empty
define('__MESSAGE_EMPTY_FIELDS__', "Por favor, preencha todos os campos!");


//======================================================================
// Do not change
//======================================================================

//E-mail validation
function check_email($email){
    if(!@eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){
        return false;
    } else {
        return true;
    }
}

//Send mail
function send_mail($to,$subject,$message,$headers){
    if(@mail($to,$subject,$message,$headers)){
        echo json_encode(array('info' => 'success', 'msg' => __SUCCESS_MESSAGE__));
    } else {
        echo json_encode(array('info' => 'error', 'msg' => __ERROR_MESSAGE__));
    }
}

//Get data form and send mail
if(isset($_POST['name']) and isset($_POST['mail']) and isset($_POST['messageForm'])){
    $name = $_POST['name'];
    $mail = $_POST['mail'];
    $subjectForm = $_POST['subjectForm'];
    $messageForm = $_POST['messageForm'];

    if($name == '') {
        echo json_encode(array('info' => 'error', 'msg' => "Oops! Esqueceu do nome."));
        exit();
    } else if($mail == '' or check_email($mail) == false){
        echo json_encode(array('info' => 'error', 'msg' => "Oops! email inválido."));
        exit();
    } else if($messageForm == ''){
        echo json_encode(array('info' => 'error', 'msg' => "Oops! Esqueceu da mensagem."));
        exit();
    } else {
        $to = __TO__;
        $subject = $subjectForm . ' ' . $name;
        $message = '
        <html>
        <head>
          <title>Email do site joiasbaranov.com.br</title>
        </head>
        <body>
          <table style="width: 500px; font-family: arial; font-size: 14px;" border="1">
            <tr style="height: 32px;">
              <th align="right" style="width:150px; padding-right:5px;">Nome:</th>
              <td align="left" style="padding-left:5px; line-height: 20px;">'. $name .'</td>
            </tr>
            <tr style="height: 32px;">
              <th align="right" style="width:150px; padding-right:5px;">Email:</th>
              <td align="left" style="padding-left:5px; line-height: 20px;">'. $mail .'</td>
            </tr>
            <tr style="height: 32px;">
              <th align="right" style="width:150px; padding-right:5px;">Assunto:</th>
              <td align="left" style="padding-left:5px; line-height: 20px;">'. $subjectForm .'</td>
            </tr>
            <tr style="height: 32px;">
              <th align="right" style="width:150px; padding-right:5px;">Mensagem:</th>
              <td align="left" style="padding-left:5px; line-height: 20px;">'. $messageForm  .'</td>
            </tr>
          </table>
        </body>
        </html>
        ';

        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: ' . $mail . "\r\n";

        send_mail($to,$subject,$message,$headers);
    }
} else {
    echo json_encode(array('info' => 'error', 'msg' => __MESSAGE_EMPTY_FIELDS__));
}
 ?>