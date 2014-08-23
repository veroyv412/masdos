<?php
include_once __DIR__ . '/../lib/mailer/class.smtp.php';
include_once __DIR__ . '/../lib/mailer/class.phpmailer.php';

function json($obj)
{
    //header('Content-Type', 'application/json');
    return json_encode($obj);
}

function getBody( $_name, $_email, $_subject, $_mensaje )
{
    $body = "<html>".
                "<head>".
                    "<title>Web Mail</title>".
                "</head>".
            "<body>".
                "<table>".
                "<tr>".
                "<td width='19%' height='32' colspan='2'><strong>Mensaje Web desde la pagina... &nbsp;</strong></td>".
                "</tr>".
                "</table>".
                "<table width='80%' style='font-family:Verdana, Arial, Helvetica, sans-serif; font-size:13px'>".
                "<tr><td align='right' width='20%'><strong>Nombre: &nbsp;&nbsp;</strong></td>".
                "<td width='81%'>".$_name."</td>".
                "</tr>".
                "<tr><td align='right'><strong>E-Mail:&nbsp;&nbsp;</strong></td>".
                "<td>".$_email."</td>".
                "</tr>".
                "<tr>".
                "<td align='right'><strong>Asunto: &nbsp;&nbsp;</strong></td>".
                "<td>".$_subject."</td>".
                "</tr>".
                "<tr>".
                "<td align='right'><strong>Mensaje:&nbsp;&nbsp;</strong></td>".
                "<td>".$_mensaje."</td>".
                "</tr>".
                "</table>".
            "</body>".
        "</html>";

    return $body;
}

$app->post('/contact', function() use ($app) {
    $_nombre = $app->request()->post('name');
    $_email = $app->request()->post('email');
    $_subject = $app->request()->post('subject');
    $_mensaje = $app->request()->post('message');

    try {
        $mail = new PHPMailer(); // defaults to using php "mail()"
        $body = getBody($_nombre, $_email, $_subject, $_mensaje);

        $mail->From       = $_email;
        $mail->FromName   = $_nombre;
        $mail->Subject    = "MAS DOS Webmail - Contactenos";
        $mail->AltBody    = ""; // optional, comment out and test
        $mail->MsgHTML($body);
        $mail->AddAddress("veroyv412@gmail.com", "Verónica Nisenbaum");//to  whom  I'm sending
        $mail->AddAddress("loraknawoc@hotmail.com", "Karol Cowan");//to  whom  I'm sending

        $mail->IsSendmail();
        if ($mail->Send())
        {
            echo "ok";
        }
        else
        {
            echo "error";
        }

        // Clear all addresses and attachments for next loop
        $mail->ClearAddresses();
        $mail->ClearAttachments();
    } catch (phpmailerException $e) {
        echo json(array($e->errorMessage())); //Errores de PhpMailer
    } catch (Exception $e) {
        echo json(array($e->getMessage())); //Errores de cualquier otra cosa.
    }

});

// contactenos.
$app->post('/contact2', function() use ($app) {
    $_nombre = $app->request()->post('name');
    $_email = $app->request()->post('email');
    $_subject = $app->request()->post('subject');
    $_mensaje = $app->request()->post('message');

    try {
        $mail = new PHPMailer(); // defaults to using php "mail()"
        $body = getBody($_nombre, $_email, $_subject, $_mensaje);

        $mail->From       = $_email;
        $mail->FromName   = $_nombre;
        $mail->Subject    = "MAS DOS Webmail - Contactenos";
        $mail->AltBody    = ""; // optional, comment out and test
        $mail->MsgHTML($body);
        $mail->AddAddress("veroyv412@gmail.com", "Verónica Nisenbaum");//to  whom  I'm sending
        $mail->AddAddress("loraknawoc@hotmail.com", "Karol Cowan");//to  whom  I'm sending

        $mail->IsSMTP();
        //$mail->SMTPDebug  = 2;
        $mail->SMTPAuth   = true;
        $mail->SMTPSecure = "ssl";
        $mail->Host       = "smtp.gmail.com";
        $mail->Port       = 465;
        $mail->Username   = 'veroyv412@gmail.com';
        $mail->Password   = 'v3r0n1c4';

        if ($mail->Send())
        {
            echo "ok";
        }
        else
        {
            echo "error";
        }

        // Clear all addresses and attachments for next loop
        $mail->ClearAddresses();
        $mail->ClearAttachments();
    } catch (phpmailerException $e) {
        echo json(array($e->errorMessage())); //Errores de PhpMailer
    } catch (Exception $e) {
        echo json(array($e->getMessage())); //Errores de cualquier otra cosa.
    }

});
