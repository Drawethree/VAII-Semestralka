<?php

include_once "MySQLDatabase.php";
include_once "DBStorage.php";
include_once "Email.php";

$database = new MySQLDatabase();
$storage = new DBStorage($database);

$id = -1;
if (isset($_POST['id'])) {
    $id = $_POST['id'];
}
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <title>Ján Kluka · Developer · Entertainer · Student</title>
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- jQuery and JS bundle w/ Popper.js -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>

    <script src="script.js"></script>
    <link href="style.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand">
        <img src="img/profilovka.png" width="30" height="30" alt="">
    </a>
    <a class="navbar-brand">Ján Kluka</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault"
            aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Domov <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="o-mne.html">O Mne</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kontakt.php">Kontakt</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="emaily.php">Emaily</a>
            </li>
        </ul>
    </div>
</nav>

<?php
if (isset($_POST['new-name']) && isset($_POST['new-email']) && isset($_POST['new-text'])) {
    if ($_POST['new-name'] == '') { ?>
        <div class="alert alert-warning" role="alert">
            Prosím zadajte meno.
        </div>
    <?php } else if ($_POST['new-email'] == '') { ?>
        <div class="alert alert-warning" role="alert">
            Prosím zadajtee-mail.
        </div>
    <?php } else if ($_POST['new-text'] == '') { ?>
        <div class="alert alert-warning" role="alert">
            Prosím zadajte text.
        </div>
    <?php } else {
        if ($storage->updateEmail($id,$_POST['new-name'], $_POST['new-email'], $_POST['new-text'])) {
            ?>
            <div class="alert alert-success" role="alert">
                E-mail bol upravený!
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning" role="alert">
                E-mail sa nepodarilo upraviť.
            </div>
        <?php }
        header( "refresh:1;url=emaily.php");
        die();
    }
}
?>

<?php
try {
    $email = $storage->getById($id);
} catch (TypeError $exception) {
    header( "refresh:1;url=emaily.php");
    die();
    ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        E-mail s id <?= $id ?> nebol najdeny.
    </div>
    <?php return;
} ?>

<div class="container contact-form">
    <form method="post">
        <h3>Úprava Emailu</h3>
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" name="id" value="<?= $email->getId() ?>">
                <div class="form-group">
                    <input type="text" name="new-name" class="form-control" placeholder="<?= $email->getName() ?>" required
                           value="<?= $email->getName() ?>"/>
                </div>
                <div class="form-group">
                    <input type="email" name="new-email" class="form-control" placeholder="<?= $email->getEmail() ?>" required
                           value="<?= $email->getEmail() ?>"/>
                </div>
                <div class="form-group">
                    <textarea name="new-text" class="form-control" placeholder="<?= $email->getText() ?>" required
                              rows="3"><?= $email->getText() ?></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnSubmit" class="btn btn-outline-primary btn-block" value="Upraviť"/>
                </div>
                <div class="form-group">
                    <a href="emaily.php"><input type="button" name="btnBack" class="btn btn-outline-danger btn-block" value="Späť"/></a>
                </div>
            </div>
        </div>
    </form>
</div>

</body>
</html>

