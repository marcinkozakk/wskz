<?php
session_start();
if (!isset($_SESSION['userId'])) {
    header('Location: /auth/index.php');
    exit;
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
<div class="container-fluid mt-4">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-md-8">
            <div class="text-center">
                <div class="card">
                    <h1 class="display-3 card-header">Witaj!</h1>
                    <div class="card-body">
                        <h1 class="card-title"><?= $_SESSION['userName'] ?></h1>
                        <div class="card-text">
                            Zaznaczyłeś, że twoja płeć to <br>
                            <span class="h5">
                                <?= $_SESSION['sex'] === 'male' ? 'mężczyzna' : 'kobieta' ?>
                            </span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="/auth/logout.php" class="btn btn-info">Wyloguj</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
