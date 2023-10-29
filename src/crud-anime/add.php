<?php 
require "../auth/auth.php";

$animeValid = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = uniqid();
    $title = $_POST["title"];
    $genre = $_POST["genre"];
    $prota = $_POST["prota"];

    if (isset($id) && isset($title) && isset($genre) && isset($prota)) {
        $handle = fopen("../../database/anime.csv", "r");

        if ($handle) {
            while (($line = fgetcsv($handle)) !== false) {
               if ($line[1] == $title && $line[2] == $genre && $line[3] == $prota) {
                   $animeValid = false;
                   break;
               }
            }
        }

        if ($handle !== false) {
            fclose($handle);
        }
        if ($animeValid) {
            $handle = fopen("../../database/anime.csv", "a");

            if ($handle) {
                fputcsv($handle, [$id, $title, $genre, $prota]);
            }

            if ($handle !== false) {
                fclose($handle);
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <title>Add</title>
    <script>
        window.addEventListener("load", () => {
            const buttonVoltar = document.querySelector("#voltar");

            buttonVoltar.addEventListener("click", () => {
                window.location.href = "/src/home.php"
            });
        });
    </script>
</head>
<body>
        <form action="<?= $_SERVER["PHP_SELF"]?> " method="post" class="formDefault">
            <h1 class="title">Adicionar Anime</h1>
            <div class="input">
                <label for="title">Título</label>
                <input type="text" name="title" id="title" required>
            </div>
            <div class="input">
                <label for="genre">Gênero</label>
                <input type="text" name="genre" id="genre" required>
            </div>
            <div class="input">
                <label for="prota">Protagonista</label>
                <input type="text" name="prota" id="prota" required>
            </div>
                <button class="button-default" type="submit" style="display: flex;">Adicionar</button>
                <button class="button-default" id="voltar">Back</button>
        </form>


        <?php if (!$animeValid) : ?>
            <p class="error">Anime já cadastrado!</p>
        <?php endif; ?>

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Genre</th>
                        <th>Protagonist</th>
                        <th style="color: red;">Remove</th>
                        <th style="color: green;">Update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $handle = fopen("../../database/anime.csv", "r");
                    ?>
                    <?php if ($handle) : ?>
                        <?php while (($line = fgetcsv($handle)) !== false) : ?>
                            <tr>
                                <td><?= $line[1] ?></td>
                                <td><?= $line[2] ?></td>
                                <td><?= $line[3] ?></td>
                                <td>
                                    <a href="delete.php?id=<?= $line[0] ?>">
                                        <button class="button-default">
                                            Remove
                                        </button>
                                    </a>
                                </td>
                                <td>
                                    <a href="update.php?id=<?= $line[0] ?>">
                                        <button class="button-default">
                                            Update
                                        </button>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <?php fclose($handle); ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
</body>
</html>