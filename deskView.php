<?php 

	if (isset($_SESSION['message']) && isset($_SESSION['class'])) {
	    $message = $_SESSION['message'];
	    $class = $_SESSION['class'];

	    // Limpiar las variables de sesión después de mostrar el mensaje
	    unset($_SESSION['message']);
	    unset($_SESSION['class']);
	    
	    $class == 'primary' ? $class = 'success' : $class = 'danger';
	    echo "<script>
	            window.addEventListener('load', function() {
	                appendAlert('$message', '$class')
	            });
	          </script>";
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Inicio</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body data-bs-theme="dark">
	<div class="modal fade" id="addForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir</h1>
	        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	      </div>
        <form action="backend.php?order=create" method="POST" enctype="multipart/form-data">
					<div class="modal-body">
						<div class="mb-3">
							<label for="photo" class="form-label">Foto</label>
							<input class="form-control" type="file" id="photo" accept="image/*" name="photo" required>
						</div>
						<div class="mb-3">
							<input type="text" class="form-control" id="name" placeholder="Nombre" name="name" required>
						</div>
						<div class="mb-3">
							<input type="text" class="form-control" id="location" placeholder="Ubicación" name="location" required>
						</div>
						<div class="mb-3">
							<label for="notes" class="form-label">Notas</label>
							<textarea class="form-control" id="notes" rows="3" name="notes" required></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						<button type="submit" class="btn btn-primary">Guardar</button>
					</div>
        </form>
	    </div>
	  </div>
	</div>
	<nav class="navbar navbar-expand-lg bg-body-tertiary">
	  <div class="container-fluid">
	    <a class="navbar-brand" href="#">Sistema de administración de prestamos</a>
      <form class="d-flex" role="search">
        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addForm"><i class="bi bi-plus-circle"></i> Añadir</a>
      </form>
	  </div>
	</nav>
	<div class="container mt-3">
		<?php if($objetos == null): ?>
			<center>
				<div class="card center" style="width: 18rem;">
				  <img src="gato.gif" class="card-img-top" alt="...">
				  <div class="card-body">
				    <h5 class="card-title">Sin contenido registrado</h5>
				    <p class="card-text">Haga click en el botón para agregar un nuevo registro</p>
				    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addForm"><i class="bi bi-plus-circle"></i> Añadir</a>
				  </div>
				</div>
			</center>
		<?php else: ?>
		<table class="table table-dark" data-bs-theme="dark">
		  <thead>
		    <tr>
		      <th scope="col">Foto</th>
		      <th scope="col">Nombre</th>
		      <th scope="col">Ubicación</th>
		      <th scope="col">Notas</th>
		      <th scope="col">Opciones</th>
		    </tr>
		  </thead>
		  <tbody>
		  	<?php foreach($objetos as $obj): ?>
	  			<div class="modal fade" id="editForm-<?=$obj['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  			  <div class="modal-dialog">
	  			    <div class="modal-content">
	  			      <div class="modal-header">
	  			        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar</h1>
	  			        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	  			      </div>
	  		        <form action="backend.php?order=edit" method="POST" enctype="multipart/form-data">
	  		        	<input type="hidden" name="id" value="<?=$obj['id']?>">
	  		        	<input type="hidden" name="prevPicture" value="<?=$obj['photo']?>">
	  							<div class="modal-body">
	  								<div class="mb-3">
	  									<label for="photo" class="form-label">Foto</label>
	  									<input class="form-control" type="file" id="photo" accept="image/*" name="photo">
	  								</div>
	  								<div class="mb-3">
	  									<input type="text" class="form-control" id="name" placeholder="Nombre" name="name" value="<?=htmlspecialchars($obj['name'])?>" required>
	  								</div>
	  								<div class="mb-3">
	  									<input type="text" class="form-control" id="location" placeholder="Ubicación" name="location" value="<?=htmlspecialchars($obj['location'])?>" required>
	  								</div>
	  								<div class="mb-3">
	  									<label for="notes" class="form-label">Notas</label>
	  									<textarea class="form-control" id="notes" rows="3" name="notes" required><?=htmlspecialchars($obj['notes'])?></textarea>
	  								</div>
	  							</div>
	  							<div class="modal-footer">
	  								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
	  								<button type="submit" class="btn btn-primary">Guardar</button>
	  							</div>
	  		        </form>
	  			    </div>
	  			  </div>
	  			</div>
  				<div class="modal fade" id="editLocation-<?=$obj['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  				  <div class="modal-dialog">
  				    <div class="modal-content">
  				      <div class="modal-header">
  				        <h1 class="modal-title fs-5" id="exampleModalLabel">Editar ubicación</h1>
  				        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
  				      </div>
  			        <form action="backend.php?order=editLocation" method="POST" enctype="multipart/form-data">
  			        	<input type="hidden" name="id" value="<?=$obj['id']?>">
  			        	<input type="hidden" name="name" value="<?=$obj['name']?>">
  								<div class="modal-body">
  									<div class="mb-3">
  										<input type="text" class="form-control" id="location" placeholder="Ubicación" name="location" value="<?=htmlspecialchars($obj['location'])?>" required>
  									</div>
  								</div>
  								<div class="modal-footer">
  									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
  									<button type="submit" class="btn btn-primary">Guardar</button>
  								</div>
  			        </form>
  				    </div>
  				  </div>
  				</div>
		  		<div class="modal fade" id="deleteForm-<?=$obj['id']?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  		  <div class="modal-dialog">
		  		    <div class="modal-content">
		  		      <div class="modal-header">
		  		        <h1 class="modal-title fs-5" id="exampleModalLabel">Eliminar</h1>
		  		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		  		      </div>
		  		      <div class="modal-body">
		  		        ¿Desea eliminar este objeto? "<?=htmlspecialchars($obj['name'])?>"
		  		      </div>
		  		      <div class="modal-footer">
		  		        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
		  		        <a href="backend.php?order=delete&id=<?=$obj['id']?>&img=<?=$obj['photo']?>" type="button" class="btn btn-primary">Confirmar</a>
		  		      </div>
		  		    </div>
		  		  </div>
		  		</div>
			    <tr>
			      <td><img src="/photos/<?=$obj['photo']?>" alt="..." width="200"></td>
			      <td><?=htmlspecialchars($obj['name'])?></td>
			      <td><?=htmlspecialchars($obj['location'])?></td>
			      <td><?=htmlspecialchars($obj['notes'])?></td>
			      <td>
			      	<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editForm-<?=$obj['id']?>"><i class="bi bi-pencil-square"></i></button>
			      	<button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editLocation-<?=$obj['id']?>"><i class="bi bi-geo-alt"></i></button>
			      	<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteForm-<?=$obj['id']?>"><i class="bi bi-trash"></i></button>
			      </td>
			    </tr>
		  	<?php endforeach?>
		  </tbody>
		</table>
		<?php endif ?>
		<div id="alert"></div>
	</div>
</body>
<script>
	const alert = document.getElementById('alert')
	const appendAlert = (message, type) => {
	  const wrapper = document.createElement('div')
	  wrapper.innerHTML = [
	    `<div class="alert alert-${type} alert-dismissible" role="alert">`,
	    `   <div>${message}</div>`,
	    '   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>',
	    '</div>'
	  ].join('')

	  alert.append(wrapper);

	  setTimeout(function() {
	  	alert.style.visibility="hidden";
	  }, 3000);
	}
</script>
<script src="./script.js"></script>
</html>