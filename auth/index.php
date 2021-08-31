<?php
$errorsCodes = require './errors.php';
if (isset($_POST['register'])) {
    require './User.php';
    $user = new User($_POST);
    if (!$user->valid) {
        $registerErrors = $user->errors;
    } else {
        $status = $user->save();
        if ($status !== true) {
            $registerErrors[] = $status;
        } else {
            $_POST = [];
        }
    }
} elseif (isset($_POST['logging'])) {
    require './User.php';
    $user = new User();
    if ($user->login($_POST['login_login'], $_POST['login_password'])) {
        header('Location: /auth/home.php');
        exit;
    } else {
        $loginError = 'LOGIN_ERROR';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"
          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" rel="stylesheet">
    <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport">
    <title>Auth</title>
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-md-8">
            <div class="text-center">
                <h1 class="display-1">Witaj!</h1>
            </div>

            <!--Login-->
            <div class="card">
                <article class="card-body">
                    <h4 class="card-title text-center mb-4 mt-1">Zaloguj się</h4>
                    <hr>
                    <?= isset($status) && $status === true
                        ? '<p class="text-success text-center">Świetnie! Teraz możesz się zalogować</p>'
                        : null ?>
                    <?= isset($loginError)
                        ? "<p class=\"text-success text-danger\">$errorsCodes[$loginError]</p>"
                        : null ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input name="logging" type="hidden" value="1">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input class="form-control" value="<?= $_POST['login_login'] ??
                                '' ?>" name="login_login" placeholder="Login" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input class="form-control" value="<?= $_POST['login_password'] ??
                                '' ?>" name="login_password" placeholder="Hasło" type="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Zaloguj</button>
                        </div>
                        <p class="text-center"><a class="btn" href="#">Zapomniałeś hasła?</a></p>
                    </form>
                </article>
            </div>

            <div class="mt-4 h2 text-center">Lub</div>

            <!--register-->
            <div class="card mt-4">
                <article class="card-body">
                    <h4 class="card-title text-center mb-4 mt-1">Załóż konto</h4>
                    <hr>
                    <?php foreach ($registerErrors ?? [] as $error) {
                        echo "<p class=\"text-danger text-center\">$errorsCodes[$error]</p>";
                    }
                    ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <input name="register" type="hidden" value="1">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input class="form-control" value="<?= $_POST['login'] ??
                                '' ?>" name="login" placeholder="Login" type="login" required minlength="6">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input class="form-control" value="<?= $_POST['password'] ??
                                '' ?>" name="password" placeholder="Hasło" type="password" required minlength="8">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                </div>
                                <input class="form-control" value="<?= $_POST['email'] ??
                                '' ?>" name="email" placeholder="Email" type="email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user-edit"></i> </span>
                                </div>
                                <input class="form-control" value="<?= $_POST['first_name'] ??
                                '' ?>" name="first_name" placeholder="Imię" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user-edit"></i> </span>
                                </div>
                                <input class="form-control" value="<?= $_POST['last_name'] ??
                                '' ?>" name="last_name" placeholder="Nazwisko" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-venus-mars"></i> </span>
                                </div>
                                <div class="form-control">
                                    <div class="form-check-inline pl-2">
                                        <input checked class="form-check-input" id="male" name="sex" type="radio"
                                               value="male">
                                        <label class="form-check-label" for="male">
                                            Mężczyzna
                                        </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <input class="form-check-input" id="female" name="sex" type="radio"
                                               value="female">
                                        <label class="form-check-label" for="female">
                                            Kobieta
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Zarejestruj
                            </button>
                        </div>
                    </form>
                </article>
            </div>
        </div>
    </div>
</div>
</body>
</html>