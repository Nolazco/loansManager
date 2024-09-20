<?php 

require ("./required.php");

$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
include('./sender.php');

$data = json_decode(file_get_contents('php://input'), true);
if($data != null){
	$query = "INSERT INTO `subscriptions` (`endpoint`, `p256dh`, `auth`) VALUES (?, ?, ?)";
	$stmt = $pdo->prepare($query);
	$stmt = $mysqli->prepare($query);
	$stmt->bind_param("sss", $data['endpoint'], $data['keys']['p256dh'], $data['keys']['auth']);
	if(!$stmt->execute()){
		print_r("Inserción fallida: (" . $mysqli->errno . ") " . $mysqli->error);
	}else{
		print_r("like");
	}
}

isset($_GET['order']) ? $order = $_GET['order'] : $order = null;

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

$queryObj = "SELECT * FROM `objetos`";
$objetos = mysqli_query($mysqli, $queryObj)->fetch_all(MYSQLI_ASSOC);

if(isset($order)){
	$name = $mysqli->real_escape_string($_POST['name']);
	$location = $mysqli->real_escape_string($_POST['location']);
	$notes = $mysqli->real_escape_string($_POST['notes']);
	$filename = uniqid();
	$photo = $_FILES['photo']['tmp_name'];

	switch ($order) {
		case 'create':
			if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
				$message = "Error: Tipo de archivo no permitido.";
				$class = "error";
			}else{
				$query = "INSERT INTO `objetos`(`name`, `location`, `notes`, `photo`) VALUES(?, ?, ?, ?)";
				$stmt = $mysqli->prepare($query);
				$stmt->bind_param("ssss", $name, $location, $notes, $filename);
				if(!$stmt->execute()){
					$message = "Inserción fallida: (" . $mysqli->errno . ") " . $mysqli->error;
					$class = "error";
				}else{
					if(!file_exists('./photos')){
						mkdir('./photos', 0777, true);
						if(file_exists('./photos'))
							move_uploaded_file($photo, './photos/'.$filename);
					}else
						move_uploaded_file($photo, './photos/'.$filename);
					$message = "Registro agregado correctamente.";
					$class = "primary";
					$send = "Se agregó el registro: ".$name;
					sendNotify($mysqli, $send);
				}
			}
			$_SESSION['message'] = $message;
			$_SESSION['class'] = $class;
			header("Location: /");
			break;
		case 'edit': 
			if($photo == null)
				$filename = $_POST['prevPicture'];
			else{
				if (!in_array($_FILES['photo']['type'], $allowedTypes)) {
					$message = "Error: Tipo de archivo no permitido.";
					$class = "error";
					$_SESSION['message'] = $message;
					$_SESSION['class'] = $class;
					header("Location: /");
					die();
				}else{
					unlink('./photos/'.$_POST['prevPicture']);
					if(!file_exists('./photos')){
						mkdir('./photos', 0777, true);
						if(file_exists('./photos'))
							move_uploaded_file($photo, './photos/'.$filename);
					}else
						move_uploaded_file($photo, './photos/'.$filename);
				}
			}
			$query = "UPDATE `objetos` SET `name` = ?, `location` = ?, `notes` = ?, `photo` = ? WHERE `id` = ?";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("ssssd", $name, $location, $notes, $filename, $_POST['id']);
			if(!$stmt->execute()){
				$message = "Edicion fallida: (" . $mysqli->errno . ") " . $mysqli->error;
				$class = "error";
			}
			else{
				$message = "Registro editado correctamente.";
				$class = "primary";
			}
			$_SESSION['message'] = $message;
			$_SESSION['class'] = $class;
			$send = "Se modificó el registro: ".$name;
			sendNotify($mysqli, $send);
			header("Location: /");
			break;
		case 'editLocation':
			$query = "UPDATE `objetos` SET `location` = ? WHERE `id` = ?";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("sd", $location, $_POST['id']);
			if(!$stmt->execute()){
				$message = "Edicion fallida: (" . $mysqli->errno . ") " . $mysqli->error;
				$class = "error";
			}
			else{
				$message = "Registro editado correctamente.";
				$class = "primary";
			}
			$_SESSION['message'] = $message;
			$_SESSION['class'] = $class;
			$send = "Se modificó la ubicación del registro: ".$name;
			sendNotify($mysqli, $send);
			header("Location: /");
			break;
		case 'delete':
			$query = "SELECT `name` FROM `objetos` WHERE `id` = ".$_GET['id'];
			$result = mysqli_query($mysqli, $query);
			$row = mysqli_fetch_row($result);
			$name = $row[0];
			$query = "DELETE FROM `objetos` WHERE `id` = ?";
			$stmt = $mysqli->prepare($query);
			$stmt->bind_param("d", $_GET['id']);
			unlink('./photos/'.$_GET['img']);
			if(!$stmt->execute()){
				$message = "Eliminación fallida: (" . $mysqli->errno . ") " . $mysqli->error;
				$class = "error";
			}
			else{
				$message = "Registro eliminado correctamente.";
				$class = "primary";
			}
			$_SESSION['message'] = $message;
			$_SESSION['class'] = $class;
			$send = "Se eliminó el registro: ".$name;
			sendNotify($mysqli, $send);
			header("Location: /");
			break;
		default:
			null;
			break;
	}	
}