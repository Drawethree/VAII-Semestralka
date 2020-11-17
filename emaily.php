<?php

ob_start();
session_start();

include_once "MySQLDatabase.php";
include_once "DBStorage.php";
include_once "Email.php";

$database = new MySQLDatabase();
$storage = new DBStorage($database);

$emails = $storage->getAll();

$cookie_name = "shown-emails";

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
            <li class="nav-item active">
                <a class="nav-link" href="emaily.php">Emaily</a>
            </li>
        </ul>
    </div>
</nav>

<?php
if (isset($_POST['delete']) && !empty($_POST['id'])) {
    if ($storage->deleteEmail($_POST['id'])) {
        ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            E-mail bol vymazaný.
        </div>
        <?php
        header('Refresh: 1');
        exit();
    } else {
        ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            E-mail sa nepodarilo vymazať.
        </div>
    <?php }
}
?>

<?php

if (empty($emails)) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        Neboli najdene žiadne e-maily
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

<?php } else {
    $ids = array();
    foreach ($emails as $email) {
        $ids[] = $email->getId();
        $new = (isset($_COOKIE[$cookie_name]) && !in_array($email->getId(), unserialize($_COOKIE['shown-emails'])));
        ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="card bg-light <?php if ($new) { ?> border-success <?php } ?>">
                    <div class="card-header"><?= $email->getName() ?> <?php if ($new) { ?>
                            <span class="badge badge-success">Nový</span> <?php } ?> </div>
                    <div class="card-body">
                        <h6 class="card-title text-muted"><?= $email->getEmail() ?></h6>
                        <h6 class="card-subtitle text-muted"><?= $email->getCreatedAt() ?></h6>
                        <p class="card-text"><?= $email->getText() ?></p>

                        <form method="post">
                            <input type="hidden" name="id" value="<?= $email->getId() ?>">
                            <div class="form-group">
                                <input type="submit" class="btn btn-outline-danger btn-sm" name="delete"
                                       value="Vymazať"></a>
                            </div>
                        </form>

                        <form method="post" action="editEmail.php">
                            <input type="hidden" name="id" value="<?= $email->getId() ?>">
                            <div class="form-group">
                                <input type="submit" class="btn btn-outline-primary btn-sm" name="edit"
                                       value="Upraviť"></a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    <?php }
}

if (isset($ids) && !empty($ids)) {
    setcookie($cookie_name, serialize($ids), time() + 3600);
}

$database->close();

?>

</body>
</html>

