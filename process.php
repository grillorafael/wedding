<?php

$from = 'Rafael Grillo <grillorafael@gmail.com>';
$to = 'marialowen@gmail.com';
$name = $_POST['name'];
$guests = $_POST['guests'];
$subject = "Confirmação do convidado - $name";
$message = "O convidado $name confirmou $guests convidados";

$ch = curl_init();

curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, 'api:key-0qsp-amfc75mfw-u0ggm-grp0b4jmis1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$plain = strip_tags(br2nl($message));

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/rgrillo.com/messages');
curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => 'support@rgrillo.com',
    'to' => $to,
    'subject' => $subject,
    'html' => $message,
    'text' => $plain));

$j = json_decode(curl_exec($ch));

$info = curl_getinfo($ch);

if($info['http_code'] != 200)
    error("Fel 313: Vänligen meddela detta via E-post till support@".DOMAIN);

curl_close($ch);

return json_encode($j);
