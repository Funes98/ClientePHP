<?php
session_start();

$_SESSION["cartas"] = [
    "cartas/c1.svg", "cartas/c2.svg", "cartas/c3.svg", "cartas/c4.svg", "cartas/c5.svg", 
    "cartas/c6.svg", "cartas/c7.svg", "cartas/c8.svg", "cartas/c9.svg", "cartas/c10.svg",
    "cartas/d1.svg", "cartas/d2.svg", "cartas/d3.svg", "cartas/d4.svg", "cartas/d5.svg", 
    "cartas/d6.svg", "cartas/d7.svg", "cartas/d8.svg", "cartas/d9.svg", "cartas/d10.svg",
    "cartas/p1.svg", "cartas/p2.svg", "cartas/p3.svg", "cartas/p4.svg", "cartas/p5.svg", 
    "cartas/p6.svg", "cartas/p7.svg", "cartas/p8.svg", "cartas/p9.svg", "cartas/p10.svg",
    "cartas/t1.svg", "cartas/t2.svg", "cartas/t3.svg", "cartas/t4.svg", "cartas/t5.svg", 
    "cartas/t6.svg", "cartas/t7.svg", "cartas/t8.svg", "cartas/t9.svg", "cartas/t10.svg"
];

// Mezcla las cartas y selecciona las primeras 8
shuffle($_SESSION["cartas"]);
$_SESSION["resultado"] = array_slice($_SESSION["cartas"], 0, 8);





if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["game"])) {
    $perder = false;

    // Verifica si alguna carta tiene el mismo número que su índice
    foreach ($_SESSION["resultado"] as $index => $carta) {
        // Obtiene el número de la carta
        preg_match('/\d+/', $carta, $busca);
        $numeroCarta = $busca[0];

        //verifica si pierde
        if ($numeroCarta == $index + 1) {
            $perder = true;
            
        }
    }

    // imprime las cartas
    foreach ($_SESSION["resultado"] as $carta) {
        echo '<img src="' . $carta . '" alt="Carta" style="width: 50px; height: auto; margin: 5px;" />';
    }

    // resul
    if ($perder) {
        echo "<br> Has perdido";
    } else {
        echo "<br> Has ganado";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solitario</title>

    <style>
        body {
            background-color: #222;
            color: #fff;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h1 {
            color: #7FFF00;
        }

        .container {
            text-align: center;
            background-color: #333;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.5);
        }

        .card-container {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        img {
            width: 50px;
            height: auto;
            margin: 5px;
            transition: transform 0.3s ease;
        }

        img:hover {
            transform: scale(1.1);
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            background-color: #7FFF00;
            color: #222;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #9ACD32;
        }

        .result {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>


</head>
<body>

    <form method="GET">
        <h1>Bienvenido al Solitario</h1>
        <input type="submit" value="Empezar Juego" id="game" name="game">

        <input type="submit" value="Finalizar Juego" id="end" name="end">
    </form>
    
</body>
</html>



