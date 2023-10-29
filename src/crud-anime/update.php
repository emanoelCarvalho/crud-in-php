<?php 
require "../auth/auth.php";
$fileAnime = "../../database/anime.csv";

$animeValid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST["id"]) ? $_POST["id"] : null;
    $title = $_POST["title"];
    $genre = $_POST["genre"];
    $protagonist = $_POST["protagonist"];

    if ($id !== null && isset($title) && isset($genre) && isset($protagonist)) {
        $fp = fopen($fileAnime, "r");

        if ($fp) {
            $copy = tempnam("../../database/", "");
            $temp = fopen($copy, "w");

            if ($temp) {
                while ($row = fgetcsv($fp)) {
                    if ($row[0] == $id) {
                        fputcsv($temp, [$id, $title, $genre, $protagonist]);
                    } else {
                        fputcsv($temp, $row);
                    }
                }

                fclose($temp);
                fclose($fp);

                rename($copy, $fileAnime);
                header("Location: /src/crud-anime/add.php", true, 302);
                exit();
            } else {
                fclose($fp);
            }
        }
    }
}

$id = isset($_GET["id"]) ? $_GET["id"] : null;

if ($id !== null) {
    $handle = fopen($fileAnime, "r");

    if ($handle) {
        while ($line = fgetcsv($handle)) {
            if ($line[0] == $id) {
                $data = $line;
                break;
            }
        }
        fclose($handle);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <title>Update</title>
    <script>
        window.addEventListener("load", () => {
            const buttonVoltar = document.querySelector("#voltar");

            buttonVoltar.addEventListener("click", function() {
                window.location.href = "/src/crud-anime/add.php";
            });

        });
    </script>
</head>
<body>
    <h1>Update Data</h1>

    <form action="<?= $_SERVER["PHP_SELF"]?> " method="post" class="formDefault">
        <input type="hidden" name="id" value="<?= $data[0] ?>" >

        <label for="title">Title</label>
        <input type="text" name="title" value="<?= $data[1] ?>">

        <label for="genre">Genre</label>
        <input type="text" name="genre" value="<?= $data[2] ?>">

        <label for="protagonist">Protagonist</label>
        <input type="text" name="protagonist" value="<?= $data[3] ?>">

        <input type="submit" value="Update">
    </form>

    <?php if (!$animeValid) : ?>
        <p class="error">Anime already exists</p>
    <?php endif; ?>

    <button class="button-default" id="voltar">Back</button>
</body>
</html>
