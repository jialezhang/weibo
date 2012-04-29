<?php
 echo"ahhahah";

$to = "254368094@qq.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: jialezhang@hustunique.com" . "\r\n" .
"CC:zhangjames@gmail.com";

mail($to,$subject,$txt,$headers);

echo "An email has been sent to $_POST[email] with an activation key. Please check your mail to complete registration."; 
##Send activation Email
$to      = $_POST[email]; 
$subject = " YOURWEBSITE.com Registration"; 
$message = "Welcome to our website!\r\rYou, or someone using your email address, has completed registration at YOURWEBSITE.com.
You can complete registration by clicking the following link:\rhttp.//www.YOURWEBSITE.com/verify.php?$activationKey\r\rIf this is an error,
ignore this email and you will be removed from our mailing list.\r\rRegards,\ YOURWEBSITE.com Team"; 
$headers = 'From: noreply@ YOURWEBSITE.com' . "\r\n" . 
'Reply-To: noreply@ YOURWEBSITE.com' . "\r\n" . 
'X-Mailer: PHP/' . phpversion(); 
mail($to, $subject, $message, $headers);
?>
