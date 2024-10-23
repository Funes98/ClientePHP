<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda virtual</title>
    <link rel="stylesheet" href="tienda.css">

</head>
<body>
    <?php
    include "header.php";
    ?>

    <div class="irclientes">
            <a href="clientes.php"><button>Ver Clientes</button></a>
        </div>
    

        <?php
    include "footer.php";
    ?>
</body>
</html>