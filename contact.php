<?php
$email_from = "";   // Sender if none specified
$sendermail_antwort = true;      // Email address of the visitor as sender
$name_from_email = "Email";   // Field containing the sender address
 
$recipient = "YOUR@EMAIL.COM"; // recipient address
$mail_cc = ""; // CC address, this email address gets another copy
$subject = "New contact request"; // subject of the email
 
$ok = "./mail-erfolgreich.html"; // Target page when email was sent successfully
$error = "./mail-fehlgeschlagen.html"; // Landing page when email could not be sent
 
 
// These fields will not be in the mail
$ignore_fields = array('submit');

// Date when the email was created
$name_tag = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
$num_tag = date("w");
$tag = $name_tag[$num_tag];
$jahr = date("Y");
$n = date("d");
$monat = date("m");
$time = date("H:i");
 
// First line of the email
$msg = ">> Sent on $tag, $n.$monat.$jahr - $time Clock <<\n\n";
 
// All input fields are queried here
foreach($_POST as $name => $value) {
   if (in_array($name, $ignore_fields)) {
        continue; // Ignore fields will not be included in the mail
   }
   $msg .= ">> $name <<\n$value\n\n";
}
 
// Email address of the visitor as sender
if ($sendermail_antwort and isset($_POST[$name_from_email]) and filter_var($_POST[$name_from_email], FILTER_VALIDATE_EMAIL)) {
   $email_from = $_POST[$name_from_email];
}
 
$header="From: $email_from";
 
if (!empty($mail_cc)) {
   $header .= "\n";
   $header .= "Cc: $mail_cc";
}
 
// Send email as UTF-8
$header .= "\nContent-type: text/plain; charset=utf-8";
 
$mail_senden = mail($recipient,$subject,$msg,$header);

// Forwarding, there could now also be outputs here via echo
if($mail_senden){
  header("Location: ".$ok); // Mail has been sent

  exit();
} else{
  header("Location: ".$error); // Error sending
  exit();
}
?>