<?php
session_start();
require_once("assets/php/config.php");

// var_dump($_REQUEST);

// Se un utente fa una nuova registrazione
if ($_REQUEST["mode"] === 'new') {
    // fare i controlli di validazione dei campi
    $regexemail = '/^((?!\.)[\w\-_.]*[^.])(@\w+)(\.\w+(\.\w+)?[^.\W])$/m';
    preg_match_all($regexemail, htmlspecialchars($_REQUEST['mail']), $matchesEmail, PREG_SET_ORDER, 0);
    $regexPass = '/^((?=\S*?[A-Z])(?=\S*?[a-z])(?=\S*?[0-9]).{6,})\S$/';
    preg_match_all($regexPass, htmlspecialchars($_REQUEST['password']), $matchesPass, PREG_SET_ORDER, 0);

    $firstname = strlen(trim(htmlspecialchars($_REQUEST['fullname']))) > 2 ? trim(htmlspecialchars($_REQUEST['firstname'])) : exit();
    $email = $matchesEmail ? htmlspecialchars($_REQUEST['mail']) : exit();
    $pass = $matchesPass ? htmlspecialchars($_REQUEST['password']) : exit();
    $password = password_hash($pass, PASSWORD_DEFAULT);

    // $target_dir = "http://" . $_SERVER['SERVER_NAME'] . $percorso . '/assets/uploads/';
    // $tutta_dir = $target_dir . "default.png";


    if ($_FILES['fotoFile']['size'] < 1) {
        $target_dir = "http://" . $_SERVER['SERVER_NAME'] . $percorso . '/assets/uploads/';
        $tutta_dir = $target_dir . "default.png";
        
    } else {
        if ($_FILES['fotoFile']['type'] === 'image/jpeg' || $_FILES['fotoFile']['type'] === 'image/png') {
            //    print_r($_FILES['fotoFile']);
            $file_name = $_FILES['fotoFile']['name'];
            $senza_spazi = str_replace(' ', '', $file_name);

            $target_dir = "http://" . $_SERVER['SERVER_NAME'] . $percorso . '/assets/uploads/';
            $tutta_dir = $target_dir . $senza_spazi;
            $upload_dir = 'assets/uploads/' . $senza_spazi;
            // print $tutta_dir;
            if (is_uploaded_file($_FILES['fotoFile']["tmp_name"]) && $_FILES['fotoFile']["error"] === UPLOAD_ERR_OK) {
                if (move_uploaded_file($_FILES['fotoFile']['tmp_name'], $upload_dir)) {
                    echo "mbare tutto appoggio";
                } else {
                    echo "vez c'è qualcosa che non va ecco tutta DIR:    ";
                    print_r("   " . $tutta_dir . "    ");
                    exit("immagine non caricata");
                }
            }
        } else {
            echo "qualcosa è andato storto";
            exit();
        }
        ;
    }

    // Preparazione della query SQL
    $query_creazione_utente = " INSERT INTO users (name, username, email, pwd, image_src) VALUES (
                                    '" . $_REQUEST['fullname'] . "',
                                    '" . $_REQUEST['username'] . "',
                                    '" . $_REQUEST['mail'] . "',
                                    '" . password_hash($_REQUEST['password'], PASSWORD_DEFAULT) . "',
                                    '" . $tutta_dir . "'
                                )";

    // Esecuzione della query
    if ($my_db->query($query_creazione_utente) === TRUE) {
        echo "Nuovo utente creato con successo.<br>";
        session_write_close();
        header('Location: index.php');
        exit();
    } else {
        echo "Errore nella creazione dell'utente: " . $my_db->error . "<br>";
    }
}
;


// Modalità login
if ($_REQUEST["mode"] === 'login') {
    // Funzione per verificare le credenziali
    $sql_query = 'SELECT * FROM users WHERE username ="' . $_REQUEST['username'] . '"';
    $result_user = $my_db->query($sql_query);

    $utente = mysqltoarray($result_user);

    if (isset($utente[0])) {
        // echo "user esiste";
        if (password_verify($_REQUEST['password'], $utente[0]['pwd'])) {
            // echo 'tutto ok';
            // session_start();
            $_SESSION["username"] = $_REQUEST['username'];
            $_SESSION['login'] = 'true';
            $_SESSION["user_id"] = $utente[0]['id'];
            $_SESSION["user_image"] = $utente[0]['image_src'];
            $_SESSION["name_utente"] = $utente[0]['name'];
            $_SESSION["email_utente"] = $utente[0]['email'];

            session_write_close();
            exit(header('Location: index.php'));


        } else {
            // echo "password no buona";
            session_write_close();
            exit(header('Location: login.php?errore=pwd'));

        }
    } else {
        // echo "user non esiste";
        session_write_close();
        exit(header('Location: login.php?error=user'));
    }
    ;

}
;


if ($_REQUEST["mode"] === 'logout') {
    session_destroy();
    session_write_close();
    exit(header('Location: index.php'));


}
;

if ($_REQUEST["mode"] === 'newBook') {
    // fare i controlli di validazione dei campi

    $bookTitle = strlen(trim(htmlspecialchars($_REQUEST['bookTitle']))) > 2 ? trim(htmlspecialchars($_REQUEST['bookTitle'])) : exit("Booktitle no buono");
    $authorName = strlen(trim(htmlspecialchars($_REQUEST['authorName']))) > 2 ? trim(htmlspecialchars($_REQUEST['authorName'])) : exit("Autore nome no buono");
    $year = (is_numeric($_REQUEST['year']) && strlen(trim($_REQUEST['year'])) > 0) ? trim($_REQUEST['year']) : exit("Anno no buono");
    $imageLink = !empty(trim($_REQUEST['imageLink'])) && filter_var(trim($_REQUEST['imageLink']), FILTER_VALIDATE_URL) ? trim($_REQUEST['imageLink']) : "assets/uploads/book.png";



    $sql = "SELECT * FROM libri WHERE isbn = '" . $_REQUEST['isbn'] . "'";

    // Leggo dati da una tabella

    $result = [];
    $res = $my_db->query($sql); // return un mysqli result
    if ($res) { // Controllo se ci sono dei dati nella variabile $res
        //var_dump($res);
        while ($row = $res->fetch_assoc()) { // Trasformo $res in un array associativo
            // $result[] = $row; // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
            array_push($result, $row); // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
        }
    }

    if (empty($result)) {
        echo "ISBN non trovato";
        //controlliamo che l'autore esista
        $check_autore = "SELECT * FROM autori WHERE nome like '%" . $_REQUEST['authorName'] . "%';";
        // print_r($check_autore);
        $result2 = [];
        $res2 = $my_db->query($check_autore); // return un mysqli result
        if ($res2) { // Controllo se ci sono dei dati nella variabile $res
            //var_dump($res);
            while ($row = $res2->fetch_assoc()) { // Trasformo $res in un array associativo
                // $result[] = $row; // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
                array_push($result2, $row); // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
            }
        }
        if (empty($result2)) {
            echo "L'autore non esiste";
            $insert_autore = "INSERT INTO autori (nome) VALUES ('" . $_REQUEST['authorName'] . "');";
            // print_r($insert_autore);
            $my_db->query($insert_autore);
            $id_autore_grep = $my_db->query("SELECT * FROM autori WHERE nome like '%" . $_REQUEST['authorName'] . "%';")->fetch_assoc()["id"];
            $genreId = getGenreId($_REQUEST['genre']);
            
            $inserisci_libro = "INSERT INTO libri (isbn, titolo, anno_pub, id_autore, id_genere, img_src, created_by_user_id ) VALUES 
                                    (" . $_REQUEST['isbn'] . ", '" . $_REQUEST['bookTitle']  
                                    . "', " . $_REQUEST['year'] . ", " . $id_autore_grep . ", " . $genreId . ", '" . $_REQUEST['imageLink'] . "', " . $_SESSION["user_id"] . ");" ;
            
            // print_r($inserisci_libro);
            $my_db->query($inserisci_libro);
            session_write_close();
            header('Location: books.php');
            exit();
            
        } else {
            echo "L'autore esiste";
            $id_autore_grep = $result2[0]['id'];
            $genreId = getGenreId($_REQUEST['genre']);

            $inserisci_libro = "INSERT INTO libri (isbn, titolo, anno_pub, id_autore, id_genere, img_src, created_by_user_id) VALUES 
                                    (" . $_REQUEST['isbn'] . ", '" . $_REQUEST['bookTitle']  
                                    . "', " . $_REQUEST['year'] . ", " . $id_autore_grep . ", " . $genreId . ", '" . $_REQUEST['imageLink'] . "', " . $_SESSION["user_id"] . ");" ;

              

            $my_db->query($inserisci_libro);

            session_write_close();
            header('Location: books.php');
            exit();


        }

    } else {
        echo "ISBN già presente";
        session_write_close();
        header('Location: addbook.php?isbnExist=true');
        exit();
            
    }

};

if (!empty($_REQUEST["isbn"])) {
    // echo "non è vuota";
    if (!empty($_SESSION["login"])) {

        $query_elimina = "DELETE FROM libri WHERE isbn = '" . $_REQUEST['isbn'] . "'";

        $my_db->query($query_elimina);
        session_write_close();
        header('Location: books.php');
        exit();
        
    };
};


// implementare ricerca sul sito
// if ($_REQUEST["mode"] === 'searchBooks') {

//     $search_query = 


// };


if ($_REQUEST["mode"] === 'editBook') {

    $bookTitle = strlen(trim(htmlspecialchars($_REQUEST['bookTitle']))) > 2 ? trim(htmlspecialchars($_REQUEST['bookTitle'])) : exit("Booktitle no buono");
    $authorName = strlen(trim(htmlspecialchars($_REQUEST['authorName']))) > 2 ? trim(htmlspecialchars($_REQUEST['authorName'])) : exit("Autore nome no buono");
    $year = (is_numeric($_REQUEST['year']) && strlen(trim($_REQUEST['year'])) > 0) ? trim($_REQUEST['year']) : exit("Anno no buono");
    $imageLink = !empty(trim($_REQUEST['imageLink'])) && filter_var(trim($_REQUEST['imageLink']), FILTER_VALIDATE_URL) ? trim($_REQUEST['imageLink']) : "assets/uploads/book.png";

    $query_di_edit = '';

    $check_autore = "SELECT * FROM autori WHERE nome like '%" . $_REQUEST['authorName'] . "%';";
        // print_r($check_autore);
        $result2 = [];
        $res2 = $my_db->query($check_autore); // return un mysqli result
        if ($res2) { // Controllo se ci sono dei dati nella variabile $res
            //var_dump($res);
            while ($row = $res2->fetch_assoc()) { // Trasformo $res in un array associativo
                // $result[] = $row; // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
                array_push($result2, $row); // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
            }
        }

        
        if (empty($result2)) {
            echo "L'autore non esiste";
            $insert_autore = "INSERT INTO autori (nome) VALUES ('" . $_REQUEST['authorName'] . "');";
            // print_r($insert_autore);
            $my_db->query($insert_autore);
            $id_autore_grep = $my_db->query("SELECT * FROM autori WHERE nome like '%" . $_REQUEST['authorName'] . "%';")->fetch_assoc()["id"];
            $genreId = getGenreId($_REQUEST['genre']);
            $isbnToBeEdited = mysqli_real_escape_string($my_db, $_SESSION['isbnToBeEdited']);
            
            $edita_libro = "UPDATE libri SET  
            titolo = '" . $_REQUEST['bookTitle'] . "', 
            anno_pub = " . $_REQUEST['year'] . ", 
            id_autore = " . $id_autore_grep . ", 
            id_genere = " . $genreId . ", 
            img_src = '" . $_REQUEST['imageLink'] . "'
            WHERE isbn = '" . $isbnToBeEdited . "';";
            // print_r($inserisci_libro);
            $my_db->query($edita_libro);
            session_write_close();
            header('Location: books.php');
            exit();
            
        } else {
            echo "L'autore esiste";
            $id_autore_grep = $result2[0]['id'];
            $genreId = getGenreId($_REQUEST['genre']);
            
            $isbnToBeEdited = $_SESSION['isbnToBeEdited'];
            
            // Preparazione della query di aggiornamento per il libro esistente
            $edita_libro = "UPDATE libri SET  
                            titolo = '" . $_REQUEST['bookTitle'] . "', 
                            anno_pub = " . $_REQUEST['year'] . ", 
                            id_autore = " . $id_autore_grep . ", 
                            id_genere = " . $genreId . ", 
                            img_src = '" . $_REQUEST['imageLink'] . "'
                            WHERE isbn = '" . $isbnToBeEdited . "';";
            
            echo($edita_libro);
            
            // Esecuzione della query di aggiornamento
            $my_db->query($edita_libro);
            
            if ($my_db->affected_rows > 0) {
                echo "Libro aggiornato con successo.";
            } else {
                echo "Errore nell'aggiornamento del libro o nessuna modifica apportata.";
            }
        
            session_write_close();
            header('Location: books.php');
            exit();


        }



};
