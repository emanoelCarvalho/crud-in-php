<?php 
$emailValid = true;
$passwordValid = true;
$validationData = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];
    $passwordConfirmation = $_POST["passwordConfirmation"];

    if (isset($email) && isset($password) && isset($passwordConfirmation)) {
        $handle = fopen("../database/users.csv", "r");

        if ($handle) {
            while (($row = fgetcsv($handle)) !== false) {
                if ($row[0] == $email) {
                    $emailValid = false;
                    $validationData = false;
                    break;
                }
            }
                if ($password != $passwordConfirmation) {
                    $passwordValid = false;
                    $validationData = false;
                }
                fclose($handle);

                if ($validationData) {
                    $handle = fopen("../database/users.csv", "a");
                    fputcsv($handle, [$email, $password]);
                    session_start();

                    $_SESSION["user"] = $email;
                    $_SESSION["auth"] = true;

                    fclose($handle);

                    header("Location: /src/home.php");
                    exit();
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
    <title>Register</title>
</head>
<style>
    .formDefault input[type="email"], 
    .formDefault input[type="password"] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: none;
        border-radius: 4px;
        background-attachment: #f8f8f8;
    }
</style>
<body>
    <h1>Register</h1>

    <form action="<?= $_SERVER["PHP_SELF"]?>" method="post" class="formDefault">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="passwordConfirmation" placeholder="Confirm Password" required>

        <input type="submit" value="Register">

        <p class="p"><a href="/index.php">Login</a></p>
    </form>

    <?php if (!$emailValid) : ?>
        <p class="p">Email already registered</p>
    <?php endif; ?>
    <?php if (!$passwordValid) : ?>
        <p class="p">Passwords do not match</p>
    <?php endif; ?>
</body>
</html>