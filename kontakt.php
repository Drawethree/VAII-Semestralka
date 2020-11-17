<?php

include_once "MySQLDatabase.php";
include_once "DBStorage.php";
$mysqlDatabase = new MySQLDatabase();
$storage = new DBStorage($mysqlDatabase);

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

    <link href="style.css" rel="stylesheet">
</head>

<body>

<?php
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['text'])) {
    if ($_POST['name'] == '') { ?>
        <div class="alert alert-warning" role="alert">
            Prosím zadajte Vaše meno.
        </div>
    <?php } else if ($_POST['email'] == '') { ?>
        <div class="alert alert-warning" role="alert">
            Prosím zadajte Váš e-mail.
        </div>
    <?php } else if ($_POST['text'] == '') { ?>
        <div class="alert alert-warning" role="alert">
            Prosím zadajte text.
        </div>
    <?php } else {
        $email = new Email(-1,$_POST['name'], $_POST['email'], $_POST['text'],-1);
        if ($storage->saveEmail($email)) {
            ?>
            <div class="alert alert-success" role="alert">
                E-mail bol odoslaný!
            </div>
            <?php
        } else {
            ?>
            <div class="alert alert-warning" role="alert">
                E-mail sa nepodarilo odoslať.
            </div>
        <?php }
    }
}
?>

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
            <li class="nav-item active">
                <a class="nav-link" href="kontakt.php">Kontakt</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="emaily.php">Emaily</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container contact-form">
    <form method="post">
        <h3>Kontaktujte Ma</h3>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input type="text" name="name" class="form-control" placeholder="Meno" value="" required/>
                </div>
                <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="E-mail" value="" required/>
                </div>
                <div class="form-group">
                    <textarea name="text" class="form-control" placeholder="Správa" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" name="btnSubmit" class="btnContact" value="Odoslať"/>
                </div>
            </div>
        </div>
    </form>
</div>

</body>

</html>
