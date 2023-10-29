<?php 
$validationData = true;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (isset($email) && isset($password)) {
        $handle = fopen("database/users.csv", "r");

        if ($handle) {
            while (($row = fgetcsv($handle)) !== false) {
                if ($row[0] == $email && $row[1] == $password) {
                    session_start();
                    $_SESSION["user"] = $row[0];
                    $_SESSION["auth"] = true;

                    fclose($handle);

                    header("Location: /src/home.php");
                    exit();
                }
            }
            fclose($handle);
            $validationData = false;
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
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>

    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post" class="formDefault">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Enter">
        
        <p class="p"><a href="src/cadastro.php">Create an acount</a></p>
    </form>

    <?php if (!$validationData) : ?>
        <p class="p">Invalid email or password</p>
    <?php endif; ?>
</body>
</html>