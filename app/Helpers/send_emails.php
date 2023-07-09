<?php

use App\Models\User;

function email_template($user_name = '', $content = '')
{
    $header = "<section style='padding-bottom:10px;'>
              <div style='text-align:center; background:lightgreen;'>
                <img src='".asset( logo() )."' style='height:80px; width:auto;'>
              </div>
            </section>";
    $body = "<section style='padding:10px;'> Hi, ". $user_name .
             " <br><br> ". $content . "

              <div style='padding-top: 50px;'>
              Kind Regards, <br><br>
              ".app_name() . " Team <br>"
              . official_phone_number(). "<br> 
              </div>
             </section>";

    $footer = "<section style='padding-top:5px;'>
              <div style='text-align:center; background:lightgreen; color:white; height:40px;'>
                <p style='padding:10px;'> ". app_name() ." ".date('Y'). " </p>
              </div>
            </section>";
            
    $template = "<section style='font-family:verdana; padding:15px; font-size:13px;'>"
                . $header. $body. $footer 
                . "</section>";
    return $template;
}

function send_password_reset_email($user, $token)
{
    $content = "You have Initiated a request to reset your password, <br>
                     Please, click or copy the link below to proceed ! <hr> <br>
                     <a href='".route('confirm_password_reset_token',['email'=>$user->email, 'token'=>$token])."'> Click here </a> <br> <br> or copy the link below <br> <br> 
                     <p> '". route('confirm_password_reset_token',['email'=>$user->email, 'token'=>$token]) ."'</p>
                     ";
    $title = "Password Reset !";
    send_email($user->email, $user->fullnames(), $title, email_template($user->fullnames(), $content) );
}

function send_login_email($user, $login)
{
    $content = "You recently logged in to your account on ".$login->created_at.
                    " <br><br> with <b> IP Address: </b>".$login->ip_address;
    send_email($user->email, $user->fullnames(), "Account Login", email_template( $user->fullnames(), $content) );
}

function send_registration_email($user, $password = null)
{
        $title = "Registration Successful !";  
        $content = "Congratulation, your account has been created successfully. <br/><br>
                    Below are your login Details: <br>".
                    "<p> Email: " .$user->email . " </p> <hr>".
                    "<p> Password: " .$password . " </p> <hr>".
                   
                " Thank you <br><br>". app_name(). " Team <br>";
       
        send_email( $user->email, $user->fullnames(), $title, email_template( $user->fullnames(), $content) );
}

function send_election_result_email()
{
     return;
}

