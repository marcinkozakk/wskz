<?php
$status = 'setNew';
if ($_POST) {
    require 'src/Database.php';
    $db = new Database();
    $db->connect();
    if ($db->checkAndSetNewPassword($_POST['id'], $_POST['s'], $_POST['password'])) {
        $status = 'ok';
    } else {
        $status = 'bad';
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
            <div class="card mt-4">
                <article class="card-body">
                    <?php if ($status === 'setNew'): ?>
                        <h4 class="card-title text-center mb-4 mt-1">
                            Podaj nowe hasło</h4>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                            <input name="id" type="hidden" value="<?= $_GET['id'] ?? '' ?>">
                            <input name="s" type="hidden" value="<?= $_GET['s'] ?? '' ?>">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                    </div>
                                    <input class="form-control" name="password" placeholder="Hasło" type="password" minlength="8" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-block" type="submit">Zmień
                                </button>
                            </div>
                        </form>
                    <?php elseif ($status === 'ok'): ?>
                        <h4 class="card-title text-center mb-4 mt-1">
                            Hasło zostało zmienione
                        </h4>
                        <a class="btn btn-link" href="/auth">Wróć do logowania</a>
                    <?php else: ?>
                        <h4 class="card-title text-center mb-4 mt-1">
                            Nie można było zmienić hasła, sprawdź czy link jest prawidłowy
                        </h4>
                        <a class="btn btn-link" href="/auth">Wróć do logowania</a>
                    <?php endif; ?>
                </article>
            </div>
        </div>
    </div>
</div>
</body>

