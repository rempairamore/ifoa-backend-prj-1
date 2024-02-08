<?php require_once("assets/php/header.php"); require_once("assets/php/navbar.php"); require_once("assets/php/config.php") ?>

<div class="sezioneBooks">
  <?php
  if ($_SESSION['login'] === 'true') {
    // Leggo dati da una tabella
  
    $sql = 'SELECT libri.isbn, libri.titolo, libri.anno_pub, libri.img_src, libri.created_by_user_id, autori.nome, generi.genere FROM libri INNER JOIN autori ON libri.id_autore = autori.id JOIN generi ON libri.id_genere = generi.id WHERE libri.created_by_user_id = ' . $_SESSION["user_id"];
    $result = [];
    $res = $my_db->query($sql); // return un mysqli result
    if ($res) { // Controllo se ci sono dei dati nella variabile $res
      //var_dump($res);
      while ($row = $res->fetch_assoc()) { // Trasformo $res in un array associativo
        // $result[] = $row; // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
        array_push($result, $row); // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
      }
    }

  } else {
    echo "<p class='m-4'>Please consider login (or create a new account).</p>";
  }
  ;



  ?>

  <div class="row row-cols-1 row-cols-md-4 g-4 mb-5 mt-4 mx-3">
    <?php
    if (isset($result)) {
      foreach ($result as $key => $value) { ?>
        <div class="col">
          <div class="card">
            <img src="<?= $value['img_src'] ?>" class="card-img-top img-fluid" style="height: 400px; object-fit: fit;"
              alt="...">
            <div class="card-body">
              <h5 class="card-title">
                <?= $value['titolo'] ?>
              </h5>
              <p class="card-text">
                <?= ucfirst(strtolower($value['nome'])) . ", " . $value['anno_pub'] ?>
              </p>
              <p class="card-text" style="font-size: 0.8em; font-weight: 200;">
                ISBN:
                <?= $value['isbn'] ?>
              </p>
              <p class="card-text"><small class="text-body-secondary">
                  Genre: <b> <?= $value['genere'] ?> </b>
                </small></p>
              <button type="button" class="btn btn-danger" onclick="window.location.href='controller.php?isbn=<?= $value['isbn'] ?>';">Delete Book</button>

            </div>
          </div>
        </div>
        <?php
      }
    }

    ?>
  </div>
</div>




<?php require_once("assets/php/footer.php"); ?>