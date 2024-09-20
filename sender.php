<?php

require_once "./vendor/autoload.php";

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

function sendNotify($mysqli, $msg)
{
    $querySubs = "SELECT * FROM `subscriptions`";
    $subscriptions = mysqli_query($mysqli, $querySubs)->fetch_all(MYSQLI_ASSOC);

    $payload = '{"title":"Aviso" , "body":"' . $msg . '" , "url":"./"}';

    $auth = [
        "VAPID" => [
            "subject" => "mailto:me@website.com", // can be a mailto: or your website address
            "publicKey" =>
                $_ENV['VAPIDPUB'], // (recommended) uncompressed public key P-256 encoded in Base64-URL
            "privateKey" => $_ENV['VAPIDPRIV'], // (recommended) in fact the secret multiplier of the private key encoded in Base64-URL
        ],
    ];

    $webPush = new WebPush($auth);
    foreach ($subscriptions as $subscription) {
        $sub = Subscription::create([
            "endpoint" => $subscription["endpoint"],
            "keys" => [
                "p256dh" => $subscription["p256dh"],
                "auth" => $subscription["auth"],
            ],
        ]);

        //$payload = '{"title":"Aviso" , "body":"'.$msg.'" , "url":"./"}';

        $webPush->sendOneNotification($sub, $payload, ["TTL" => 5000]);
    }

    //$res = $webPush->sendOneNotification(
    //    Subscription::create($subscription),
    //    $payload,
    //    ['TTL' => 5000]
    //);

    //print_r($res);
}
