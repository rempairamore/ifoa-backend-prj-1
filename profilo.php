<?php require_once("assets/php/header.php");
require_once("assets/php/navbar.php");
require_once("assets/php/config.php") ?>





    <?php
    session_start();
    if ($_SESSION['login'] === 'true') {

        ?>
        <div class="w-100 mt-5 d-flex justify-content-center">
            <div class="row w-75 d-flex align-items-center">
                <!-- Colonna Immagine a Sinistra -->
                <div class="col-md-3">
                    <img src="<?= $_SESSION['user_image'] ?>" class="img-fluid" alt="Profile Image" style="width: 200px; height: 200px; border-radius: 50%;">
                </div>

                <!-- Colonna Dettagli Utente a Destra -->
                <div class="col-md-9">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" value="<?= $_SESSION['name_utente'] ?>">
                    </div>
                    <button type="button" class="btn btn-primary mb-5">Update Name</button>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" placeholder="<?= $_SESSION['username'] ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" placeholder="<?= $_SESSION['email_utente'] ?>" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="passwordChange" class="form-label">Change Password</label>
                        <input type="password" class="form-control" id="passwordChange" placeholder="New Password">
                    </div>
                    <button type="button" class="btn btn-primary">Update Password</button>
                </div>
            </div>
        </div>




        <?php


    } else {
        echo "<p class='m-4'>Please consider login (or create a new account).</p>";
    }
    ;
    ?>





<?php require_once("assets/php/footer.php"); ?>