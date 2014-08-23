<?php
include_once __DIR__ . '/../lib/mailer/class.smtp.php';
include_once __DIR__ . '/../lib/mailer/class.phpmailer.php';

$app->post('/mercadopagonotifications', function() use ($app) {

    $client_id = "8977799810561584";
    $client_secret = "iIMJnnb15UKtXuEFDzYf7UI5aVpBXyeV";

    $topic = $_POST['topic'];
    $payment_id = $_POST['id'];

    $toLog = array(
        'time' => date('d/m/Y h:i:s a', time()),
        'topic' => $topic,
        'payment' => $payment_id,
        'remote_addr' => $_SERVER['REMOTE_ADDR']
    );
    error_log(json_encode($toLog), 3, APPLICATION_PATH.'/logs/logs.txt');

    $mp = new MP ($client_id, $client_secret);
    //$mp->sandbox_mode(TRUE);

    $payment_information = $mp->get_payment($payment_id);

    if ( $payment_information['response']['collection']['status'] == "approved" ){
        sendEntrada($app, $payment_information['response']['collection']);
        writeNickNameToFile($payment_information['response']['collection']);
    }

    return json_encode("OK");
});

function writeNickNameToFile( $payment_information )
{
    $data = file_get_contents(APPLICATION_PATH.'/mercadopago/nicknames.json');
    $dataJSON = json_decode($data);

    $newData = new stdClass();
    $newData->time = date('d/m/Y h:i:s a', time());
    $newData->nickname = $payment_information['payer']['nickname'];
    $newData->name = $payment_information['payer']['first_name'] . ' ' . $payment_information['payer']['last_name'];
    $newData->id = $payment_information['id'];
    $newData->status = $payment_information['status'];


    if ( empty($dataJSON) ){
        $result = array( $newData );
    } else {
        $result = array_merge($dataJSON, array($newData));
    }

    file_put_contents(APPLICATION_PATH.'/mercadopago/nicknames.json', json_encode($result));
}

function sendEntrada( $app, $payment_information )
{
    $app->view()->appendData(array('payment_information' => $payment_information));
    $body = $app->view()->render('email_confirmacion_entrada.html');

    try {
        $mail = new PHPMailer(); // defaults to using php "mail()"

        $mail->From       = 'dinamico_juan.karol@hotmail.com.ar';
        $mail->FromName   = 'MAS2KJ';
        $mail->Subject    = "MAS2 en Concierto - Confirmacion de Compra";
        $mail->AltBody    = ""; // optional, comment out and test
        $mail->MsgHTML($body);

        $mail->AddAddress($payment_information['payer']['email'], $payment_information['payer']['first_name']. " ". $payment_information['payer']['last_name']);
        $mail->AddCC("veroyv412@gmail.com", "Verónica Nisenbaum");//to  whom  I'm sending
        $mail->AddCC("loraknawoc@hotmail.com", "Karol Cowan");//to  whom  I'm sending

        $mail->IsSendmail();

        /*$mail->IsSMTP();
        //$mail->SMTPDebug  = 2;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465;
        $mail->Username   = 'veroyv412@gmail.com';
        $mail->Password   = 'v3r0n1c4';*/

        $mail->Send();

        // Clear all addresses and attachments for next loop
        $mail->ClearAddresses();
        $mail->ClearAttachments();
    } catch (phpmailerException $e) {
        error_log($e->errorMessage(), 3, APPLICATION_PATH.'/logs/logs.txt');
    } catch (Exception $e) {
        error_log($e->errorMessage(), 3, APPLICATION_PATH.'/logs/logs.txt');
    }
}