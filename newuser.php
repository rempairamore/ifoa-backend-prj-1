<?php require_once("assets/php/header.php");
require_once("assets/php/navbar.php");
require_once("assets/php/config.php") ?>

<div class="d-flex m-4">
    <form method="POST" class="needs-validation m-3 w-100 " action="controller.php?mode=new" enctype="multipart/form-data">
        <div class="row g-3"> <!-- Aggiungi qui la classe row per iniziare la griglia -->

            <div class="col-md-6"> <!-- Cambia in col-md-6 per avere due campi per riga -->
                <label for="validationCustom01" class="form-label">Full name</label>
                <input type="text" class="form-control" name="fullname" placeholder="Joe Pippo" required>
                <div class="valid-feedback">
                    Looks good!
                </div>
            </div>

            <div class="col-md-6"> <!-- Cambia in col-md-6 per avere due campi per riga -->
                <label for="validationCustomUsername" class="form-label">Username</label>
                <div class="input-group has-validation">
                    <span class="input-group-text" id="inputGroupPrepend">@</span>
                    <input type="text" class="form-control" name="username" aria-describedby="inputGroupPrepend" required>
                    <div class="invalid-feedback">
                        Please choose a username.
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <label for="validationCustom06" class="form-label">E-mail</label>
                <input type="email" class="form-control" name="mail" placeholder="nome@example.com" required>
                <div class="invalid-feedback">
                    Please provide a valid email.
                </div>
            </div>

            <div class="col-md-6">
                <label for="validationCustom06" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" required pattern="(?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,}">
                <div class="invalid-feedback">
                    Password must include at least 6 characters, with an uppercase, a lowercase, and a number.
                </div>
                <p class="mt-2">Min 6 chars, with uppercase, lowercase, number</p>
            </div>

            <!-- Questo campo può rimanere a tutta larghezza perché generalmente i campi file sono visualizzati singolarmente -->
            <div class="col-12">
                <label for="formFile" class="form-label">Insert your photo (jpeg or png format file)</label>
                <input class="form-control" type="file" name="fotoFile">
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">Submit form</button>
            </div>
        </div>
    </form>
</div>


<?php require_once("assets/php/footer.php"); ?>