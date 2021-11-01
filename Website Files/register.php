<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Page Title</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='main.css'>
    <script src='main.js'></script>
</head>
<body>
    <div class="container">
        <div class="mid login">
            <form method="post" action="registerProcessing.php">
                <label>Username: </label><input type="text" name="username" id="user">
                <label>Password: </label><input type="password" name="password" id="pass">
                <label>Repeat password: </label><input type="password" name="password2" id="repeat">
                <label>Email: </label><input type="email" name="email">
                <input type="submit" value="Register">
            </form>
            <br>
            <a href="index.php">Login</a>
        </div>
    </div>
</body>
</html>