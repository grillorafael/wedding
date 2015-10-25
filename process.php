<?php

function cors() {

    // Allow from any origin
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');    // cache for 1 day
    }

    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

        exit(0);
    }

    echo "You have CORS!";
}

cors();

$from = 'Rafael Grillo <grillorafael@gmail.com>';
$to = 'marialowen@gmail.com';
$name = $_POST['name'];
$guests = $_POST['guests'];
$email = $_POST['email'];
$subject = "Confirmação do convidado - $name";
$message = "O convidado $name confirmou $guests convidados <br> De: $email";

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

if($info['http_code'] != 200) {
	return json_encode($info);
}

curl_close($ch);

return json_encode($j);
