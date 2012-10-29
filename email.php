<html>
<body>
<?php
$to = "chris@xenosec.org";
$datetime = new DateTime();
$subject = "New DNS Record for Domain.com!";
$body = "Hello, as of ". $datetime->format('Y-m-d H:i:s') . "\n \n Domain.com Now Resolves to NEWIP \n Domain.com Previously Resolved to OLDIP";
$headers = 'From: DomainTrackr <trackr@xenosec.org>' . "\r\n" . 'Reply-To: trackr@xenosec.org' . "\r\n" . 'X-Mailer: DomainTrackr';

 if (mail($to, $subject, $body, $headers)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
  }
 ?>
</body>
</html>
