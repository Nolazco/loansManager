<?php

require ("./required.php");

$querySubs = "SELECT * FROM `subscriptions`";
$subscriptions = mysqli_query($mysqli, $querySubs)->fetch_all(MYSQLI_ASSOC);
$flag = true;

$data = json_decode(file_get_contents("php://input"), true);
if ($data != null) {
	foreach ($subscriptions as $subscription) {
		if($subscription["endpoint"] == $data["endpoint"] && $subscription["p256dh"] == $data["keys"]["p256dh"] && $subscription["auth"] == $data["keys"]["auth"]){
			$flag = false;
		}
	}
	if($flag){
	    $query =
	        "INSERT INTO `subscriptions` (`endpoint`, `p256dh`, `auth`) VALUES (?, ?, ?)";
	    $stmt = $mysqli->prepare($query);
	    $stmt->bind_param(
	        "sss",
	        $data["endpoint"],
	        $data["keys"]["p256dh"],
	        $data["keys"]["auth"]
	    );
	    if (!$stmt->execute()) {
	        print_r(
	            "Inserción fallida: (" . $mysqli->errno . ") " . $mysqli->error
	        );
	    } else {
	        print_r("like");
	    }
	}
}
