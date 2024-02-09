<?php require_once("assets/php/header.php");
require_once("assets/php/navbar.php");
require_once("assets/php/config.php") ?>


<h2 class="m-4 text-center">Book Form</h2>
<?php
if ($_REQUEST['isbnExist'] === 'true') {
    ?>
    <h4 class="m-4 text-warning text-center">ISBN already in the system, must be UNIQUE!</h4>
    <?php
}

if (!empty($_REQUEST['editBook'])) {

    $sql = 'SELECT * FROM libri INNER JOIN autori ON libri.id_autore = autori.id WHERE isbn =' . $_REQUEST['editBook'];

    $result = [];
    $res = $my_db->query($sql); // return un mysqli result
    if ($res) { // Controllo se ci sono dei dati nella variabile $res
        //var_dump($res);
        while ($row = $res->fetch_assoc()) { // Trasformo $res in un array associativo
            // $result[] = $row; // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
            array_push($result, $row); // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
        }
    }

    $num_genere = intval($result[0]['id_genere']);
    // var_dump($num_genere);


    ?>
    <h4 class="m-4 text-warning text-center">Edit Book</h4>
    <div class="container d-flex justify-content-center mt-5">
        <form class="w-50" method="POST" action="controller.php?mode=editBook">
            <div class="mb-3">
                <p class="my-3 fw-bold fs-5" >ISBN-13:
                    <?= $result[0]['isbn'] ?>
                    <?php 
                    session_start();
                    $_SESSION['isbnToBeEdited'] = $result[0]['isbn'];
                    session_write_close();
                    ?>
                </p>
            </div>
            <div class="mb-3">
                <label for="bookTitle" class="form-label">Book Title</label>
                <input type="text" class="form-control" id="bookTitle" name="bookTitle" value="<?= $result[0]['titolo'] ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" value="<?= $result[0]['anno_pub'] ?>"
                    required>
            </div>
            <div class="mb-3">
                <label for="authorName" class="form-label">Author Name</label>
                <input type="text" class="form-control" id="authorName" name="authorName" value="<?= $result[0]['nome'] ?>"
                    required>
            </div>

            <div class="mb-3">
                <label for="imageLink" class="form-label">Image URL</label>
                <input type="url" class="form-control" id="imageLink" name="imageLink" required
                    value="<?= $result[0]['img_src'] ?>">
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <select class="form-select" id="genre" name="genre" required>
                    <option selected>Choose...</option>
                    <option value="fiction" <?php if ($num_genere === 1) { ?> selected<?php } ?>>Fiction</option>
                    <option value="non-fiction" <?php if ($num_genere === 2) { ?> selected<?php } ?>>Non-Fiction</option>
                    <option value="fantasy" <?php if ($num_genere === 3) { ?> selected<?php } ?>>Fantasy</option>
                    <option value="mystery" <?php if ($num_genere === 4) { ?> selected<?php } ?>>Mystery</option>
                    <option value="thriller" <?php if ($num_genere === 5) { ?> selected<?php } ?>>Thriller</option>
                    <option value="romance" <?php if ($num_genere === 6) { ?> selected<?php } ?>>Romance</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Submit</button>
        </form>
    </div>
    <?php
} else {
    ?>

    <div class="container d-flex justify-content-center mt-5">
        <form class="w-50" method="POST" action="controller.php?mode=newBook">
            <div class="mb-3">
                <label for="bookTitle" class="form-label">Book Title</label>
                <input type="text" class="form-control" id="bookTitle" name="bookTitle"
                    placeholder="Uno, nessuno e centomila" required>
            </div>
            <div class="mb-3">
                <label for="year" class="form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" placeholder="1999" required>
            </div>
            <div class="mb-3">
                <label for="authorName" class="form-label">Author Name</label>
                <input type="text" class="form-control" id="authorName" name="authorName" placeholder="George Orwell"
                    required>
            </div>
            <div class="mb-3">
                <label for="isbn" class="form-label">ISBN-13</label>
                <input type="text" class="form-control" id="authorName" name="isbn" placeholder="0123456789123" required>
            </div>
            <div class="mb-3">
                <label for="imageLink" class="form-label">Image URL</label>
                <input type="url" class="form-control" id="imageLink" name="imageLink" required
                    placeholder="https://example.com/path/to/image.jpg">
            </div>

            <div class="mb-3">
                <label for="genre" class="form-label">Genre</label>
                <select class="form-select" id="genre" name="genre" required>
                    <option selected>Choose...</option>
                    <option value="fiction">Fiction</option>
                    <option value="non-fiction">Non-Fiction</option>
                    <option value="fantasy">Fantasy</option>
                    <option value="mystery">Mystery</option>
                    <option value="thriller">Thriller</option>
                    <option value="romance">Romance</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Submit</button>
        </form>
    </div>
    <?php
}
;




require_once("assets/php/footer.php"); ?>