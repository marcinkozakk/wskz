<?php
require 'src/User.php';

if (!empty($_POST)) {
    User::remind($_POST['email']);
    $sent = true;
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
            <div class="card mt-4">
                <article class="card-body">
                    <h4 class="card-title text-center mb-4 mt-1">Podaj swój email</h4>
                    <?= isset($sent) && $sent === true
                        ? '<p class="text-success text-center">Jeżeli taki użytkownik istnieje, została do niego wysłana wiadomość z dalszymi instrukcjami</p>'
                        : null ?>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                                </div>
                                <input class="form-control" name="email" placeholder="Email" type="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary btn-block" type="submit">Przypomnij
                            </button>
                        </div>
                    </form>
                </article>
            </div>
        </div>
    </div>
</div>
</body>
