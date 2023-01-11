<?php

$status = "";
$erro = "";
    if (array_key_exists('submit', $_GET)){
        if (!$_GET['city']){
            $erro = "Campo está vazio";
        }
        if ($_GET['city']) {
            $url = "https://api.openweathermap.org/data/2.5/weather?q=".$_GET['city']."&lang=pt_br&units=metric&appid="your_api_key"";
            $apiData = curl_init($url);
            curl_setopt($apiData, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($apiData,CURLOPT_SSL_VERIFYPEER, false);
            
            $localidade = json_decode(curl_exec($apiData), true);

            if ($localidade['cod']==200) {

                $status = "yes";

            } else {
                $erro = "Nome da cidade não válido";
            } 
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Previsão Tempo</title>
</head>
<body>
    <form action="" method="GET">
        <label for="city">Nome da Cidade:</label>
        <p><input type="text" name="city" id="city" placeholder="Digite o nome da cidade"></p>
        <button type="submit" name="submit">Enviar</button>
    
        <div class="output">
            <?php
                if($status == "yes"){
                    echo "Cidade: " .$localidade['name'] . "<br>";
                    echo "Temperatura: " .$localidade['main']['temp'] . "°C.<br>";
                    echo "Temperatura Minima: " .$localidade['main']['temp_min'] . "°C.<br>";
                    echo "Temperatura Máxima: " .$localidade['main']['temp_max'] . "°C.<br>";
                    echo "Céu: " .$localidade['weather']['0']['description'] . "<br>";
                    echo "<img src='http://openweathermap.org/img/wn/".$localidade['weather']['0']['icon']."@2x.png' />";
                } else {
                    echo $erro;
                }
            ?>
        </div>
    </form>
</body>
</html>

