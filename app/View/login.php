<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>login Page </title>

<body>

    <div id="content" class="container">
        <?php
        if (!isset($_SESSION)) {
            session_start();
        }

        ?>
        <small> <?php echo isset($_SESSION["error"]) ? $_SESSION["error"] : '';    ?></small>
        <form action="home.php" method="POST">

            <input type="text" id="user-name" name="name" placeholder="username" value="<?= (isset($_COOKIE["user_name"])) ? $_COOKIE["user_name"] : '' ?>">
            <br>
            <input type="text" id="pass" name="pass" placeholder="password" value="<?= (isset($_COOKIE["pass"])) ? $_COOKIE["pass"] : '' ?>"><br>
            <input type="submit" id="pass" name="submit" value="Submit"><br>
            <input type="checkbox" name="remember-me" id=""<?= (isset($_COOKIE["user_name"])) ? 'checked' : '' ?>>remember me
        </form>
        <h4>dont have account <a href="#">SignUp now?</a></h4>
    </div>


</body>

</html>