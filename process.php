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
}

//cors();

$postdata = file_get_contents("php://input");

$request = json_decode($postdata);

$from = 'Rafael Grillo <grillorafael@gmail.com>';
$to = 'grillorafael@gmail.com';
$name = $request->name;
$guests = $request->guests;
$email = $request->email;
$subject = "Confirmação do convidado - $name";
$message = "O convidado $name confirmou $guests convidados <br> De: $email";


$ch = curl_init();


curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, 'api:key-0qsp-amfc75mfw-u0ggm-grp0b4jmis1');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$plain = strip_tags(str_replace("<br>", "\n", $message));



curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_URL, 'https://api.mailgun.net/v3/rgrillo.com/messages');
curl_setopt($ch, CURLOPT_POSTFIELDS, array('from' => "RSVP $name <support@rgrillo.com>",
    'to' => $to,
    'subject' => $subject,
    'html' => $message,
    'text' => $plain));

$j = json_decode(curl_exec($ch));

$info = curl_getinfo($ch);

if($info['http_code'] != 200) {
	echo json_encode($info);
}

curl_close($ch);

echo json_encode($j);
