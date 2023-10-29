<?php 
require "auth/auth.php";
?>

<!DOCTYPE html>
<html lang="en" translate="no">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/style.css">
    <title>Home</title>
    <script>
        window.addEventListener('load', () => {
            const buttonCrud = document.querySelector('#button-crud');
            const buttonLogout = document.querySelector('#button-logout');

            buttonCrud.addEventListener('click', () => {
                window.location.href = '/src/crud-anime/add.php';
            });

            buttonLogout.addEventListener('click', () => {
                window.location.href = '/src/logout.php';
            });

        });
    </script>
</head>
<body>
    <h1>Home Page</h1>

    <div>
        <button class="button-default" id="button-crud">Anime Crud</button>
        <button class="button-default" id="button-logout">Logout</button>
    </div>
</body>
</html>