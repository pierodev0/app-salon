<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion()
    {

        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = $_ENV['EMAIL_HOST'];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV['EMAIL_PORT'];
        $mail->Username = $_ENV['EMAIL_USER'];
        $mail->Password = $_ENV['EMAIL_PASSWORD'];

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $mail->Body = "
        <html>
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap');
        h2 {
            font-size: 25px;
            font-weight: 500;
            line-height: 25px;
        }
    
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }
    
        p {
            line-height: 18px;
        }
    
        a {
            position: relative;
            z-index: 0;
            display: inline-block;
            margin: 20px 0;
        }
    
        a button {
            padding: 0.7em 2em;
            font-size: 16px !important;
            font-weight: 500;
            background: #000000;
            color: #ffffff;
            border: none;
            text-transform: uppercase;
            cursor: pointer;
        }
        p span {
            font-size: 12px;
        }
        div p{
            border-bottom: 1px solid #000000;
            border-top: none;
            margin-top: 40px;
        }
    </style>
    <body>
        <h1>BarberShop</h1>
        <h2>¡Gracias por registrarte!</h2>
        <p>Por favor confirma tu correo electrónico para que puedas comenzar a disfrutar de todos los servicios de
            BarberShop</p>
        <a href='". asset("/confirmar-cuenta?token=" . $this->token)."'><button>Verificar</button></a>
        <p>Si tú no te registraste en BarberShop, por favor ignora este correo electrónico.</p>
        <div><p></p></div>
        <p><span>Este correo electrónico fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje.</span></p>
    </body>
    </html>";

    $mail->send();
    }

    public function enviarInstrucciones()
    {

        //Crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '74c2e6df004524';
        $mail->Password = '3ca3ef1deae8bc';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');
        $mail->Subject = 'Restablece tu contraseña';

        //Set HTML
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        $mail->Body = "
        <html>
        <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500;700&display=swap');
        h2 {
            font-size: 25px;
            font-weight: 500;
            line-height: 25px;
        }
    
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ffffff;
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }
    
        p {
            line-height: 18px;
        }
    
        a {
            position: relative;
            z-index: 0;
            display: inline-block;
            margin: 20px 0;
        }
    
        a button {
            padding: 0.7em 2em;
            font-size: 16px !important;
            font-weight: 500;
            background: #000000;
            color: #ffffff;
            border: none;
            text-transform: uppercase;
            cursor: pointer;
        }
        p span {
            font-size: 12px;
        }
        div p{
            border-bottom: 1px solid #000000;
            border-top: none;
            margin-top: 40px;
        }
    </style>
    <body>
        <h1>BarberShop</h1>
        <h2>Restablece tu contraseña</h2>
        <p>Hemos recibido una solicitud para restablecer tu contraseña en BarberShop. Haz clic en el enlace para
            restablecer.</p>
        <a href='". asset("/recuperar?token=" . $this->token)."'><button>Restablecer</button></a>
        <p>Si tú no solicitaste restablecer tu contraseña, por favor ignora este correo electrónico.</p>
        <div><p></p></div>
        <p><span>Este correo electrónico fue enviado desde una dirección solamente de notificaciones que no puede aceptar correo electrónico entrante. Por favor no respondas a este mensaje.</span></p>
    </body>
    </html>";

    $mail->send();
    }

    

    
}
