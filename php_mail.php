<?php
/* This is just for demo purpose-- Put this code in your application
 * 
 */
require("class.phpmailer.php");  //this libarary is required to send mail in core php or otther appliaction which does not have SMTP library

$mail = new PHPMailer();
$mail->IsSMTP();
$mail->Host = "mail.tulia.tech";
$mail->SMTPAuth = true;
//$mail->SMTPSecure = "ssl";
$mail->Port = 587;
$mail->Username = "noreply@tulia.tech";
$mail->Password = "GR}7EVB)5qH6";
$mail->From = "neil@tulia.tech";
/*Do not make changes above this line */


$mail->FromName = "Test for info";
$mail->AddAddress("monika.mindiii@gmail.com"); //change it to yours
//$mail->AddReplyTo("mail@mail.com");
$mail->IsHTML(true);        //keep this true
$sub = '    
<table style="max-width: 750px; margin: 0px auto; width: 100% ! important; background: #F3F3F3; padding:30px 30px 30px 30px;" width="100% !important" border="0" cellpadding="0" cellspacing="0">
    <tr>
        <td style="text-align: center; background: #eb0202;">
            <table width="100%" border="0" cellpadding="30" cellspacing="0">	
                    <tr>
                        <td>
                            
                        </td>
                    </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <table width="100%" border="0" cellpadding="30" cellspacing="0" bgcolor="#fff">
                <tr>
                    <td>
                    
                        <h3 style="color: #333; font-size: 28px; font-weight: normal; margin: 0; text-transform: capitalize;">Reset Password</h3>
                        <p style="text-align: left; color: #333; font-size: 16px; line-height: 28px;">Hello manish,</p>
                        <p style="text-align: left;color: #333; font-size: 16px; line-height: 28px;">You Recently requested to reset your password for your Tulia account. Please use password given below to login: </p>
                        <h3 style="margin: 0; background-color: #F3F3F3; font-size: 25px; display: inline-block; font-weight: bold;">916770</h3>
                        <p style="text-align: left;color: #333; font-size: 16px; line-height: 28px;">If you did not request password reset, please login with above password and change your password.</p>
                        <p style="text-align: left;color: #333; font-size: 16px; line-height: 28px;">Thanks,
                            <br>Tulia team
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#fff">
                <tr>
                    <td style="padding: 10px;background: #eb0202;color: #fff;">Tulia &copy; 2017-2018</td>
                </tr>
            </table>
        </td>
    </tr>
</table>';
$mail->Subject = "Test message from server";
//$sub = 'This is message in <b>bold</b>';
$mail->Body = $sub;


if(!$mail->Send())
{
echo "Message could not be sent. <p>";
echo "Mailer Error: " . $mail->ErrorInfo;
exit;
}

echo "Message has been sent";

?>