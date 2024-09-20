<?php

if (isset($_SESSION["message"]) && isset($_SESSION["class"])) {
    $message = $_SESSION["message"];
    $class = $_SESSION["class"];

    // Limpiar las variables de sesión después de mostrar el mensaje
    unset($_SESSION["message"]);
    unset($_SESSION["class"]);

    echo "<script>
	            window.addEventListener('load', function() {
	                showSnackbar('$message', '$class');
	            });
	          </script>";
} ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio</title>
	<link href="https://cdn.jsdelivr.net/npm/beercss@3.6.13/dist/cdn/beer.min.css" rel="stylesheet">
	<script type="module" src="https://cdn.jsdelivr.net/npm/beercss@3.6.13/dist/cdn/beer.min.js"></script>
	<script type="module" src="https://cdn.jsdelivr.net/npm/material-dynamic-colors@1.1.2/dist/cdn/material-dynamic-colors.min.js"></script>
	<link rel="manifest" href="./manifest.json">
</head>
<body>
	<dialog class="modal" id="addForm">
		<form action="backend.php?order=create" method="POST" enctype="multipart/form-data">
			<h5>Crear</h5>
			<fieldset>
				<legend>Complete la información</legend>
				<button>
					<i>attach_file</i>
					<span>File</span>
					<input type="file" name="photo" accept="image/*" required>
				</button>
				<div class="field border label">
					<input name="name" required>
					<label>Nombre</label>
				</div>
				<div class="field border label">
					<input name="location" required>
					<label>Ubicación</label>
				</div>
				<div class="field border label textarea">
					<textarea name="notes" required></textarea>
					<label>Notas</label>
				</div>
			</fieldset>
			<nav class="right-align no-space">
				<button class="transparent link cancel-button" data-ui="#addForm">Cancel</button>
				<button class="transparent link" type="submit">Confirm</button>
			</nav>
		</form>
	</dialog>
	<header>
		<nav>
			<h6 class="max center-align">Sistema de administración de prestamos</h6>
		</nav>
	</header>
	<nav class="bottom max">
		<button data-ui="#addForm">
			<i>add</i>
			<div>Añadir</div>
		</button>
	</nav>
	<main class="responsive">
		<center>
			<div style="width: 80%;">
				<?php if ($objetos == null): ?>
				<article class="medium middle-align center-align">
					<div>
						<img style="width: 130px;" src="gato.gif" alt="gato">
						<h5>Sin contenido registrado</h5>
						<p>Haga click en el botón para agregar un nuevo registro</p>
						<nav class="center-align">
							<button data-ui="#addForm">
								<i>add</i>
								<div>Añadir</div>
							</button>
						</nav>
					</div>
				</article>
				<?php endif; ?>
				<?php foreach ($objetos as $obj): ?>
				<dialog class="modal" id="deleteForm-<?= $obj["id"] ?>">
					<h5>Eliminar</h5>
					<div>¿Desea eliminar este objeto? "<?= htmlspecialchars($obj["name"]) ?>"
					</div>
					<nav class="right-align no-space">
						<button class="transparent link" data-ui="#deleteForm-<?= $obj[
          "id"
      ] ?>">Cancelar</button>
						<a href="backend.php?order=delete&id=<?= $obj["id"] ?>&img=<?= $obj[
    "photo"
] ?>"><button class="transparent link">Confirmar</button></a>
					</nav>
				</dialog>
				<form action="backend.php?order=edit" method="POST" enctype="multipart/form-data">
					<dialog class="modal" id="editForm-<?= $obj["id"] ?>">
						<h5>Editar</h5>
						<fieldset>
							<legend>Complete la información</legend>
							<button>
								<i>attach_file</i>
								<span>File</span>
								<input type="file" name="photo" accept="image/*">
							</button>
							<input type="hidden" name="id" value="<?= $obj["id"] ?>">
							<input type="hidden" name="prevPicture" value="<?= $obj["photo"] ?>">
							<div class="field border label">
								<input name="name" required value="<?= htmlspecialchars($obj["name"]) ?>">
								<label>Nombre</label>
							</div>
							<div class="field border label">
								<input name="location" required value="<?= htmlspecialchars(
            $obj["location"]
        ) ?>">
								<label>Ubicación</label>
							</div>
							<div class="field border label textarea">
								<textarea name="notes" required><?= htmlspecialchars(
            $obj["notes"]
        ) ?></textarea>
								<label>Notas</label>
							</div>
						</fieldset>
						<nav class="right-align no-space">
							<button class="transparent link cancel-button" data-ui="#editForm-<?= $obj[
           "id"
       ] ?>">Cancel</button>
							<button class="transparent link" type="submit">Confirm</button>
						</nav>
					</dialog>
				</form>
				<form action="backend.php?order=editLocation" method="POST">
					<dialog class="modal" id="editLocation-<?= $obj["id"] ?>">
						<h5>Editar ubicación</h5>
						<fieldset>
							<legend>Complete la información</legend>
							<input type="hidden" name="id" value="<?= $obj["id"] ?>">
							<input type="hidden" name="name" value="<?= $obj["name"] ?>">
							<div class="field border label">
								<input name="location" required value="<?= htmlspecialchars(
            $obj["location"]
        ) ?>">
								<label>Ubicación</label>
							</div>
						</fieldset>
						<nav class="right-align no-space">
							<button class="transparent link cancel-button" data-ui="#editLocation-<?= $obj[
           "id"
       ] ?>">Cancel</button>
							<button class="transparent link" type="submit">Confirm</button>
						</nav>
					</dialog>
				</form>
				<article class="no-padding round primary-container">
					<img style="width: 10pc;" class=" responsive small round" src="./photos/<?= $obj[
         "photo"
     ] ?>">
					<div class="padding">
						<h5><b>Nombre: </b><?= htmlspecialchars($obj["name"]) ?></h5>
						<p><b>Ubicación: </b><?= htmlspecialchars($obj["location"]) ?></p>
						<p><b>Notas: </b><?= htmlspecialchars($obj["notes"]) ?></p>
						<nav class="center-align">
							<button class="primary" data-ui="#editForm-<?= $obj["id"] ?>">Editar</button>
							<button class="primary" data-ui="#deleteForm-<?= $obj[
           "id"
       ] ?>">Eliminar</button>
						</nav>
						<nav class="center-align">
							<button class="primary" data-ui="#editLocation-<?= $obj[
           "id"
       ] ?>">Editar ubicación</button>
						</nav>
					</div>
				</article>
				<?php endforeach; ?>
			</div>
		</center>
	<div class="snackbar" id="snack">a</div>
	</main>
</body>
<script type="text/javascript">

	document.querySelectorAll('.cancel-button').forEach(button => {
		button.addEventListener('click', function(event) {
			event.preventDefault();
			const modal = document.querySelector(this.getAttribute('data-ui'));
			if (modal) {
				modal.close();
			}
		});
	});

	function showSnackbar(message, classes) {
		var snackbar = document.getElementById("snack");
		snackbar.textContent = message;
		snackbar.classList.add(classes)
		snackbar.classList.add("active");

		// Después de 3 segundos, ocultar el snackbar
		setTimeout(function() {
			snackbar.classList.remove("active");
		}, 3000);
	}
</script>
<script src="./script.js"></script>
</html>
