<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <link rel="stylesheet" href="tienda.css">
</head>
<body>

<?php
    include "header.php";
    ?>
<div class="menu">
    <div class="añadir">
        <a href="formClient.php"><button>Añadir Cliente</button></a>
    </div>
    
    <!-- Tabla -->
    <table border="1">
        <tr>
            <th>CodClientes</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Opciones</th>
        </tr>
        

        
        <?php
        //dataclient
        include "dataClient.php";
        include "functions.php";
        $data = $_SESSION['data'];

        //ir añadiendo los clientes creando mas filas y columnas
        foreach ($data as $cliente) {
            echo "<tr>";
            echo "<td>{$cliente['id']}</td>";
            echo "<td>{$cliente['name']}</td>";
            echo "<td>{$cliente['surname']}</td>";
            echo "<td>
                    <a href='formClient.php?cod={$cliente['id']}&action=Editar'>Editar</a> |
                    <a href='formClient.php?cod={$cliente['id']}&action=Borrar'>Borrar</a> |
                    <a href='formClient.php?cod={$cliente['id']}&action=Ver Datos'>Ver datos</a>
                </td>";
            echo "</tr>";
        }
        //Hemos enviado los paramentros cod y action
        ?>
    </table>
            

<?php
    include "footer.php";
    ?>
</body>
</html>
