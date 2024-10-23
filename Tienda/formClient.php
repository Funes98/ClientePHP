<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <link rel="stylesheet" href="tienda.css">

    <style>
        body {
            text-align: center;
        }
    </style>
</head>
<body>
<?php
    include "header.php";
    include "dataClient.php"; // Contiene el array data
    include "functions.php"; // Contiene la funcion findClient

    $data = $_SESSION['data'] ?? [];
    $cliente = null;
    $action = $_GET['action'] ?? null;

    if (isset($_GET["cod"]) && $action && $action !== 'Anadir') {
        $cliente = findClient($data, intval($_GET["cod"]));

        if ($cliente == null || !is_numeric($cliente["id"])) {
            echo "<script>window.location.href = 'Error.php';</script>";
            exit();
        }
    }
?>
<!-- Paranolla revisar -->
<h2><?php echo ($action == 'Editar') ? 'Editar Cliente' : ($action == 'Borrar' ? 'Borrar Cliente' : ($action == 'Anadir' ? 'Anadir Nuevo Cliente' : 'Detalles del Cliente')); ?></h2>

<!-- Formulario para anadir un cliente -->
<?php if ($action == 'Anadir'): ?>
    <form action="formClient.php?action=Anadir" method="POST">
        <label>Nombre:</label>
        <input type="text" name="name" required><br>
        
        <label>Apellido:</label>
        <input type="text" name="surname" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" required><br>
        
        <label>Genero:</label>
        <input type="text" name="gender" required><br>
        
        <label>Direccion:</label>
        <input type="text" name="address" required><br>
        
        <button type="submit">Anadir Cliente</button>
    </form>

    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = trim($_POST['name']);
        $surname = trim($_POST['surname']);
        $email = trim($_POST['email']);
        $gender = trim($_POST['gender']);
        $address = trim($_POST['address']);

        // Validaciones basicas 
        if (empty($name) || empty($surname) || empty($email) || empty($gender) || empty($address)) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: Error.php");
            exit();
        }

        // Crear un nuevo cliente con un ID unico
        $newCliente = [
            'id' => count($data) + 1, // id automatico +1
            'name' => $name,
            'surname' => $surname,
            'email' => $email,
            'gender' => $gender,
            'address' => $address,
        ];

        // Anadir el nuevo cliente al array 
        $_SESSION['data'][] = $newCliente;

        // Redirigir despues de anadir
        echo "<script>window.location.href = 'clientes.php';</script>";
        exit();
    }
    ?>
<?php endif; ?>

<!-- Formulario para editar un cliente -->
<?php if ($action == 'Editar' && $cliente): ?>
    <form action="formClient.php?action=Editar&cod=<?= htmlspecialchars($cliente['id']); ?>" method="POST">
        <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id']); ?>">
        <label>Nombre:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($cliente['name']); ?>" required><br>
        
        <label>Apellido:</label>
        <input type="text" name="surname" value="<?= htmlspecialchars($cliente['surname']); ?>" required><br>
        
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($cliente['email']); ?>" required><br>
        
        <label>Genero:</label>
        <input type="text" name="gender" value="<?= htmlspecialchars($cliente['gender']); ?>" required><br>
        
        <label>Direccion:</label>
        <input type="text" name="address" value="<?= htmlspecialchars($cliente['address']); ?>" required><br>
        
        <button type="submit">Guardar Cambios</button>
    </form>

    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = intval($_POST['id']);
        $name = trim($_POST['name']);
        $surname = trim($_POST['surname']);
        $email = trim($_POST['email']);
        $gender = trim($_POST['gender']);
        $address = trim($_POST['address']);
        
        // Validaciones basicas 
        if (empty($name) || empty($surname) || empty($email) || empty($gender) || empty($address)) {
            $_SESSION['error'] = "Todos los campos son obligatorios.";
            header("Location: Error.php");
            exit();
        }
    
        // Encontrar el indice del cliente en la sesion
        $index = null;
        foreach ($_SESSION['data'] as $key => $cliente) {
            if ($cliente['id'] === $id) {
                $index = $key; 
                break; 
            }
        }

        // Actualizar los datos del cliente
        if ($index !== null) {
            $_SESSION['data'][$index] = [
                'id' => $id, // Mantener el mismo ID
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'gender' => $gender,
                'address' => $address,
            ];

            // Redirigir despues de guardar
            echo "<script>window.location.href = 'clientes.php';</script>";
            exit();
        } else {
            $_SESSION['error'] = "Cliente no encontrado.";
            header("Location: Error.php");
            exit();
        }
    }
    ?>
    <a href="clientes.php"><button>Ver Clientes</button></a>
<?php endif; ?>

<!-- Borrar cliente -->
<?php if ($action == 'Borrar' && $cliente): ?>
    <p>¿Estas seguro que deseas borrar al cliente <strong><?= htmlspecialchars($cliente['name'] . ' ' . $cliente['surname']); ?></strong>?</p>
    <form action="formClient.php?action=Borrar&cod=<?= htmlspecialchars($cliente['id']); ?>" method="post">
        <input type="hidden" name="id" value="<?= htmlspecialchars($cliente['id']); ?>">
        <button type="submit" name="delete">Si, borrar</button>
    </form>
    <a href="clientes.php"><button>No, volver</button></a>

    <?php 
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
        $id = intval($_POST['id']);
        $index = null;
        foreach ($_SESSION['data'] as $key => $cliente) {
            if ($cliente['id'] === $id) {
                $index = $key; 
                break;
            }
        }

        if ($index !== null) {
            // Eliminar el cliente del array
            unset($_SESSION['data'][$index]);
            $_SESSION['data'] = array_values($_SESSION['data']); // Reindexar el array

            // Redirigir despues de borrar
            echo "<script>window.location.href = 'clientes.php';</script>";
            exit();
        } else {
            $_SESSION['error'] = "Cliente no encontrado.";
            header("Location: Error.php");
            exit();
        }
    }
    ?>
<?php endif; ?>

<!-- Ver datos del cliente -->
<?php if ($action == 'Ver Datos' && $cliente): ?>
    <p><strong>Nombre:</strong> <?= htmlspecialchars($cliente['name']); ?></p>
    <p><strong>Apellido:</strong> <?= htmlspecialchars($cliente['surname']); ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($cliente['email']); ?></p>
    <p><strong>Genero:</strong> <?= htmlspecialchars($cliente['gender']); ?></p>
    <p><strong>Direccion:</strong> <?= htmlspecialchars($cliente['address']); ?></p>
    <a href="clientes.php"><button>Ver Clientes</button></a>
<?php endif; ?>

<?php
    include "footer.php";
?>
</body>
</html>





