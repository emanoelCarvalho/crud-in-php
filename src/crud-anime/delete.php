<?php 
    $id = $_GET["id"];
    $copy = tempnam("../../database/","");
    $temp = fopen($copy, "w");
    if ($temp) {
        $arquivo = "../../database/anime.csv";
        $fp = fopen($arquivo, "r");
        if ($fp) {
            while(($row = fgetcsv($fp)) !== false) {
                if ($row[0] == $id) {
                    continue;
                }
                fputcsv($temp, $row);
            }
            fclose($temp);
            fclose($fp);
            rename($copy, $arquivo);
            header("location: /src/crud-anime/add.php", true, 302);
        }
    }
?>