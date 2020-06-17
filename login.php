<?php

include "config/db.php";

session_start();

if (isset($_SESSION['user']) == true) {
    header('Location: index.php');
}

if (isset($_POST['login'])) {

    if (!empty($_POST['username']) && !empty($_POST['password'])) {

        $db_pass = '';

        $user = $con->real_escape_string($_POST['username']);
        $pass = $con->real_escape_string(md5($_POST['password']));

        $sql = "SELECT user_name, password FROM users WHERE user_name = '$user'";

        $result = $con->query($sql);
        //  $row = $result->fetch_array(MYSQLI_ASSOC);

        while ($row = $result->fetch_row()) {
            $db_pass = $row[1];
        }

        if ($pass === $db_pass) {
            $_SESSION['user'] = true;
            header('Location: index.php');
            die();
        } else {
            $err = '<div class="alert alert-danger" role="alert">
            Invalid credentials!
        </div>';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | BrandApp</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/ws.brandapp.css">
 <!--    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest"> -->
</head>

<body>
    <div class="d-flex justify-content-center row">
        <div class="col-md-4 login-form">
            <div class="m-3">
                <?php print $err ?? ''; ?>
            </div>
            <form class="m-3" name="login" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="form-group">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="text-center">
                    <button name="login" type="submit" class="btn btn-block btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>