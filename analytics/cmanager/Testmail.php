<head>
<title>Sending email using PHP</title>
</head>
<body>
<?php
   //$to = "mahendra.akula@ideabytes.com";
   $to = "gayathri.dendukuri@ideabytes.com";
   $subject = "This is subject";
   $message = "This is simple text message.";
   $header = "From:cmanager@cm.ideabytes.com\r\n";
   $retval = mail ($to,$subject,$message,$header);
   if( $retval == true )  
   {
      echo "Message sent successfully...";
   }
   else
   {
      echo "Message could not be sent...";
   }
?>
</body>
</html>