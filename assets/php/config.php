<?php

// session_start();

//Variabili d'ambiente
$percorso = '';

$config = [
    'mysql_host' => 'localhost',
    'mysql_user' => 'php_user',
    'mysql_password' => 'password'
];

$my_db = new mysqli(
    $config['mysql_host'],
    $config['mysql_user'],
    $config['mysql_password']
);

if ($my_db->connect_error) {
    die($my_db->connect_error);
} else {

    $sql = 'CREATE DATABASE IF NOT EXISTS gestione_libreria_mp;';
    
    $query = "SHOW DATABASES LIKE 'gestione_libreria_mp'";
    $result = $my_db->query($query);

    if ($result->num_rows == 0) {
        $nonEsiste = "ok";
        
    }
    
    $my_db->query($sql);
    $my_db->query('USE gestione_libreria_mp');

    $creazione_tabella_autori = "CREATE TABLE IF NOT EXISTS autori(
        id INT PRIMARY KEY AUTO_INCREMENT, 
        nome VARCHAR(500) NOT NULL,
        anno_nascita INT ,
        city VARCHAR(255)  
        )";
    $creazione_tabella_generi = "CREATE TABLE IF NOT EXISTS generi(
        id INT PRIMARY KEY, 
        genere VARCHAR(500) NOT NULL
        )";
    $creazione_tabella_libri = "CREATE TABLE IF NOT EXISTS libri(
        id INT PRIMARY KEY AUTO_INCREMENT,
        isbn BIGINT UNIQUE NOT NULL,
        titolo VARCHAR(500) NOT NULL,
        anno_pub INT NOT NULL,
        id_autore INT NOT NULL,
        id_genere INT NOT NULL,
        created_by_user_id INT NOT NULL,
        img_src VARCHAR(800),
        FOREIGN KEY (id_autore) REFERENCES autori(id) ON DELETE CASCADE ON UPDATE CASCADE,
        FOREIGN KEY (id_genere) REFERENCES generi(id) ON DELETE CASCADE ON UPDATE CASCADE
        )";
    $creazione_tabella_users = "CREATE TABLE IF NOT EXISTS users(
                                id INT PRIMARY KEY AUTO_INCREMENT,
                                name VARCHAR(255) NOT NULL,
                                username VARCHAR(40) NOT NULL,
                                email VARCHAR(300) NOT NULL UNIQUE,
                                pwd VARCHAR(255) NOT NULL,
                                image_src VARCHAR(500)
                                )";

    $creazione_generi = "INSERT IGNORE INTO generi(id, genere) VALUES 
                        (1, 'Fiction'), 
                        (2, 'Non-Fiction'), 
                        (3, 'Fantasy'), 
                        (4, 'Mystery'), 
                        (5, 'Thriller')";



    $my_db->query($creazione_tabella_autori);
    $my_db->query($creazione_tabella_generi);
    $my_db->query($creazione_tabella_libri);
    $my_db->query($creazione_tabella_users);
    $my_db->query($creazione_generi);

    if($nonEsiste === "ok") {
        $insert_user_example = "INSERT INTO users (id, name, username, email, pwd, image_src) VALUES (1, 'Mario Petrella', 'mario', 'mariopet92@gmail.com', '$2y$10$35S24eYCY9VxqWYdNQoOauH2YqwpBqzBuSzQOCl4qy/IVBsJVzstW', 'assets/img/default.png')";
        $insert_autori_example = "INSERT INTO autori (id, nome) VALUES (1, 'Dario Bressanini'), (2, 'Luigi Pirandello'), (3, 'Luca Boiardi');";
        $insert_libri_example = "INSERT INTO libri (isbn, titolo, anno_pub, id_autore, id_genere, created_by_user_id, img_src) VALUES 
        (9788858016022, 'La scienza della carne', 2015, 1, 2, 1, 'https://m.media-amazon.com/images/I/61l7zdi8j9L._SL1194_.jpg'),
        (9788867582280, 'Uno, nessuno e centomila', 1938, 2, 5, 1, 'https://m.media-amazon.com/images/I/61lME-Io+HL._SL1180_.jpg'),
        (9788867582310, 'Il fu Mattia Pascal', 1950, 2, 5, 1, 'https://m.media-amazon.com/images/I/71kqovIXGfL._SL1500_.jpg'),
        (9788836010790, 'Investire in bitcoin e criptovalute', 2022, 3, 2, 2, 'https://m.media-amazon.com/images/I/71p06gHoeiL._SL1500_.jpg');";

        $my_db->query($insert_user_example);
        $my_db->query($insert_autori_example);
        $my_db->query($insert_libri_example);

    }

        

}
;


function mysqltoarray($oggetto)
{
    $result = [];
    if ($oggetto) { // Controllo se ci sono dei dati nella variabile $res
        while ($row = $oggetto->fetch_assoc()) { // Trasformo $res in un array associativo
            $result[] = $row; // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
            //array_push($contacts, $row); // estraggo ogni singola riga che leggo dal DB e la inserisco in un array
        }
    }
    return $result;
}


//funzione per trasformare genere in ID
function getGenreId($genre)
{
    $genreId = null; // Inizializza a null per gestire il caso di default

    // Usa switch per mappare il genere al suo ID
    switch ($genre) {
        case 'fiction':
            $genreId = 1;
            break;
        case 'non-fiction':
            $genreId = 2;
            break;
        case 'fantasy':
            $genreId = 3;
            break;
        case 'mystery':
            $genreId = 4;
            break;
        case 'thriller':
            $genreId = 5;
            break;
        default:
            // Opzionalmente, gestisci il caso in cui il genere non corrisponde a nessuno dei valori previsti
            // Per esempio, potresti restituire null o lanciare un'eccezione
            break;
    }

    return $genreId;
}

