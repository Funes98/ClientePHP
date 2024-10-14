<?php
    session_start();

    if(!isset($_SESSION["InicioJuego"]) or $_SESSION["InicioJuego"] === false){
        $_SESSION["arrayPalabras"]=["oso","pozo","mocoso","betis","casco","moscardon","flauta","pelota","astronauta"];
        $_SESSION["pos"]=random_int(0,8);

        $_SESSION["palabraResultado"]=$_SESSION["arrayPalabras"][$_SESSION["pos"]];
        $_SESSION["cont"]=0;
        $_SESSION["momentaneo"]=[];
        for($i=0;$i<strlen($_SESSION["palabraResultado"]);$i++){
            array_push($_SESSION["momentaneo"],"-");
        }

        $_SESSION["InicioJuego"] = true;  //Empieza el juego
    }
    //Revisar
    echo "Tiene ".count($_SESSION["momentaneo"])." letras"."<br>";


    if($_SERVER["REQUEST_METHOD"]=="GET" && isset($_GET["pal"]) && !is_numeric($_GET["pal"]) && !empty($_GET["pal"])&&
    $_GET["pal"]!==""){

        $_SESSION["cont"]++;
        $resul=str_split($_SESSION["palabraResultado"]);
        $pal=str_split($_GET["pal"]);

        if($pal===$resul){
            echo "Enhorabuena has acertado la palabra";
            session_destroy();
            $_SESSION["InicioJuego"] = false;
        }else if($_SESSION["cont"]>=5){
            echo "Has superado el limite de intentos ". "la respuesta era: ". implode("",$resul);
            session_destroy();
            $_SESSION["InicioJuego"] = false;
        }else {
            // No deberia salir de los indices
            for ($i = 0; $i < min(count($resul), count($pal)); $i++) {
                if ($resul[$i] === $pal[$i]) {
                    $_SESSION["momentaneo"][$i] = $pal[$i];
                }
            }
            echo "Progreso: " . implode("", $_SESSION["momentaneo"]) . "<br>";
            echo "Te quedan " . (5 - $_SESSION["cont"]) . " intentos.";
        }
        



    }


    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

    <form method="GET">
    Dime una palabra: <input type="text" id="pal" name="pal" pattern="[A-Za-z\s]+" minlength="3" required>
    <input type="submit" value="Enviar">

    </form>
</body>
</html>