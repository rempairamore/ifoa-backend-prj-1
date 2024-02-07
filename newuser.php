<?php require_once("assets/php/header.php");
require_once("assets/php/navbar.php");
require_once("assets/php/config.php") ?>


<form method="POST" class="row g-3 needs-validation m-3" action="controller.php?mode=new" enctype="multipart/form-data" novalidate>
    <div class="col-md-4">
        <label for="validationCustom01" class="form-label">Full name</label>
        <input type="text" class="form-control" name="fullname" placeholder="Joe" required>
        <div class="valid-feedback">
            Looks good!
        </div>
    </div>

    <div class="col-md-4">
        <label for="validationCustomUsername" class="form-label">Username</label>
        <div class="input-group has-validation">
            <span class="input-group-text" id="inputGroupPrepend">@</span>
            <input type="text" class="form-control" name="username" aria-describedby="inputGroupPrepend" required>
            <div class="invalid-feedback">
                Please choose a username.
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <label for="validationCustom06" class="form-label">e-Mail</label>
        <input type="email" class="form-control" name="mail" placeholder="nome@example.com" required>
        <div class="invalid-feedback">
            Please provide a valid email.
        </div>
    </div>
    <div class="col-md-3">
        <label for="validationCustom06" class="form-label">Password</label>
        <input type="password" class="form-control" name="password"
            placeholder="deve contenere 8 caratteri, una lettera maiuscola, un numero " required>
        <div class="invalid-feedback">
            Please provide a valid email.
        </div>
    </div>
    <div class="mb-3">
        <label for="formFile" class="form-label">Insert your photo (jpeg or png format file)</label>
        <input class="form-control" type="file" name="fotoFile">
    </div>

    <button class="btn btn-primary" type="submit">Submit form</button>
    </div>
</form>


<?php require_once("assets/php/footer.php"); ?>