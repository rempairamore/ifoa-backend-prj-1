<?php require_once("assets/php/header.php");
require_once("assets/php/navbar.php");
require_once("assets/php/config.php") ?>


<h2 class="m-4 text-center">Book Form</h2>
<?php
if($_REQUEST['isbnExist'] === 'true') {
    ?>
    <h4 class="m-4 text-warning text-center">ISBN already in the system, must be UNIQUE!</h4> <?php
}?>

<div class="container d-flex justify-content-center mt-5">
    <form class="w-50" method="POST" action="controller.php?mode=newBook">
        <div class="mb-3">
            <label for="bookTitle" class="form-label">Book Title</label>
            <input type="text" class="form-control" id="bookTitle" name="bookTitle" placeholder="Uno, nessuno e centomila" required>
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Year</label>
            <input type="number" class="form-control" id="year" name="year" placeholder="1999" required>
        </div>
        <div class="mb-3">
            <label for="authorName" class="form-label">Author Name</label>
            <input type="text" class="form-control" id="authorName" name="authorName" placeholder="George Orwell" required>
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
                <option value="thriller">Romance</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mb-4">Submit</button>
    </form>
</div>




<?php require_once("assets/php/footer.php"); ?>