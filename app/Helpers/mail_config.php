<?php
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

function send_email($receiver_email, $receiver_name, $subject, $message, $variables = [])
{
     $mail = new PHPMailer(true);
    
     $config = email_config();

   //$message = set_email_with_default_template( $receiver_name, $message );

    //  if( count( $variables ) ){
    //      $message = set_email_content_variables($variables, $message);
    //  }
    
     try{
        //Server settings
        $mail->isSMTP();
        //$mail->SMTPDebug = 3;
        $mail->Host       = $config->host;
        $mail->SMTPAuth   = true;
        $mail->Username   = $config->username;
        $mail->Password   = $config->password;
        if ($config->encryption == 'ssl') {
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        }else{
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        }
        $mail->Port = $config->port;
        $mail->CharSet = 'UTF-8';
        //Recipients
        $mail->setFrom( $config->email_from, $config->sitetitle );
        $mail->addAddress( $receiver_email, $receiver_name );
        $mail->addReplyTo( $config->email_from, $config->sitename );
        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        //$mail->send();

    if( !$mail->send() ) 
    {
       return error_msg("Mail failed to send !");
    }

     }catch( Exception $err ){
        //return error_msg(" An error has Occured ! ");
     }
  }

  // function set_email_with_default_template( $receiver_name, $message )
  // {
  //   $template = email_template()->display('email_template');
  //   if( $template->email_body ){
  //        $data['${email_body}'] = $message;
  //        $data['${name}'] = $receiver_name;
  //        $variables['${office_phone_number}'] = general_settings()->display('site_phone_number')->content;
  //        $variables['${head_office_address}'] = general_settings()->display('head_office_address')->content;
  //        $message = str_replace( array_keys($data), array_values($data), $template->email_body );
  //        $message = str_replace( array_keys($variables), array_values($variables), $message );
  //        return $message;
  //   }
  //   return $message;
  // }

  // function set_email_content_variables($variables, $email_content )
  // {
  //   $template = email_template()->display('email_template');
  //   if( $template->email_body ){
  //        $data['${email_body}'] = $email_content;
  //        $variables['${office_phone_number}'] = general_settings()->display('site_phone_number')->content;
  //        $variables['${head_office_address}'] = general_settings()->display('head_office_address')->content;
  //        $message = str_replace( array_keys($data), array_values($data), $template->email_body );
  //        $message = str_replace( array_keys($variables), array_values($variables), $message );
  //        return $message;
  //   }
  //   $message = str_replace( array_keys($variables), array_values($variables), $email_content );
  //   return $message;
  // }

  function email_config()
  {
      $data = json_encode([
          'name' => env('MAIL_MAILER'),
          'host' => env('MAIL_HOST'),
          'port' => env('MAIL_PORT'),
          'encryption' => env('MAIL_ENCRYPTION'),  
          'username' => env('MAIL_USERNAME'),
          'password' => env('MAIL_PASSWORD'),
          'email_from' => env('MAIL_FROM_ADDRESS'),
          'sitetitle' => app_name(),
          'sitename' => app_name() 
      ]);
      return json_decode( $data );
  }