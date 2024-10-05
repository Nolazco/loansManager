<?php
if (isset($_SESSION["message"]) && isset($_SESSION["class"])) {
    $message = $_SESSION["message"];
    $class = $_SESSION["class"];

    // Clear session variables after displaying the message
    unset($_SESSION["message"]);
    unset($_SESSION["class"]);

    echo "<script>
                window.addEventListener('load', function() {
                    showSnackbar('$message', '$class');
                });
              </script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/beercss@3.6.13/dist/cdn/beer.min.css" rel="stylesheet">
    <script type="module" src="https://cdn.jsdelivr.net/npm/beercss@3.6.13/dist/cdn/beer.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="manifest" href="./manifest.json">
    <style>
        body {
            background-color: #f5f5f5; /* Light background for contrast */
            color: #333; /* Dark text for readability */
        }
        header {
            background-color: #65aca4; /* Header color */
            color: white;
            padding: 10px;
        }
        .modal {
            max-width: 90%; /* Responsive modal width */
            margin: auto; /* Center modal */
        }
        .padding {
            padding: 10px; /* Increased padding for touch targets */
        }
        .primary-container {
            margin: 10px; /* Margins between articles */
            background-color: #b3d9d3; /* Card background color */
            border: 2px solid #508e87; /* Card border color */
            border-radius: 8px; /* Rounded corners */
            padding: 16px; /* Padding inside cards */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Light shadow */
        }
        nav button {
            margin: 5px; /* Spacing between buttons */
        }
        .snackbar {
            background-color: #333; /* Snackbar background */
            color: white;
            padding: 16px;
            position: fixed;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1000;
            border-radius: 5px;
            display: none; /* Hidden by default */
        }
        .snackbar.active {
            display: block; /* Show when active */
        }
        button.primary {
            background-color: #65aca4; /* Button background color */
            color: white; /* Button text color */
        }
        button.primary:hover {
            background-color: #508e87; /* Darker shade on hover */
        }
    </style>
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
                <button class="transparent link cancel-button" data-ui="#addForm">Cancelar</button>
                <button class="transparent link" type="submit">Confirmar</button>
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
            <div style="width: 90%;"> <!-- Slightly wider for mobile -->
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
                    <div>¿Desea eliminar este objeto? "<?= htmlspecialchars($obj["name"]) ?>"</div>
                    <nav class="right-align no-space">
                        <button class="transparent link" data-ui="#deleteForm-<?= $obj["id"] ?>">Cancelar</button>
                        <a href="backend.php?order=delete&id=<?= $obj["id"] ?>&img=<?= $obj["photo"] ?>">
                            <button class="transparent link">Confirmar</button>
                        </a>
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
                                <input name="location" required value="<?= htmlspecialchars($obj["location"]) ?>">
                                <label>Ubicación</label>
                            </div>
                            <div class="field border label textarea">
                                <textarea name="notes" required><?= htmlspecialchars($obj["notes"]) ?></textarea>
                                <label>Notas</label>
                            </div>
                        </fieldset>
                        <nav class="right-align no-space">
                            <button class="transparent link cancel-button" data-ui="#editForm-<?= $obj["id"] ?>">Cancelar</button>
                            <button class="transparent link" type="submit">Confirmar</button>
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
                                <input name="location" required value="<?= htmlspecialchars($obj["location"]) ?>">
                                <label>Ubicación</label>
                            </div>
                        </fieldset>
                        <nav class="right-align no-space">
                            <button class="transparent link cancel-button" data-ui="#editLocation-<?= $obj["id"] ?>">Cancelar</button>
                            <button class="transparent link" type="submit">Confirmar</button>
                        </nav>
                    </dialog>
                </form>
                <article class="no-padding round primary-container">
                    <img style="width: 10pc;" class="responsive small round" src="./photos/<?= $obj["photo"] ?>">
                    <div class="padding">
                        <h5><b>Nombre: </b><?= htmlspecialchars($obj["name"]) ?></h5>
                        <p><b>Ubicación: </b><?= htmlspecialchars($obj["location"]) ?></p>
                        <p><b>Notas: </b><?= htmlspecialchars($obj["notes"]) ?></p>
                        <nav class="center-align">
                            <button class="primary" data-ui="#editForm-<?= $obj["id"] ?>">
                                <i>edit</i> Editar
                            </button>
                            <button class="primary" data-ui="#deleteForm-<?= $obj["id"] ?>">
                                <i>delete</i> Eliminar
                            </button>
                        </nav>
                        <nav class="center-align">
                            <button class="primary" data-ui="#editLocation-<?= $obj["id"] ?>">
                                <i>edit_location</i> Editar ubicación
                            </button>
                        </nav>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </center>
        <div class="snackbar" id="snack"></div>
        <script>
            function showSnackbar(message, className) {
                const snackbar = document.getElementById('snack');
                snackbar.textContent = message;
                snackbar.className = `snackbar active ${className}`;
                setTimeout(() => {
                    snackbar.className = 'snackbar';
                }, 3000);
            }

            const cancelButtons = document.querySelectorAll('.cancel-button');
            cancelButtons.forEach(button => {
                button.addEventListener('click', (event) => {
                    event.preventDefault();
                    const dialog = event.target.closest('dialog');
                    if (dialog) {
                        dialog.close();
                    }
                });
            });
        </script>
    </main>
</body>
<script src="./script.js"></script>
</html>
