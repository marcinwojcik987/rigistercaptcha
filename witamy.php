<?php 
session_start();
//sesja umozliwia przekazywanie zmiennych pomiedzy podstronami w latwy sposob, z uzyciem globalnej tablicy asocjacyjnej o nazwie $_SESSION
//zmienne sa przechowywane po stronie serwera, a klient na swoim komputerze posiada tylko tzw identyfikator sesji PHPSESSID
if (!isset($_SESSION['udana_rejestracja'])) {
    header('Location:index.php');
    //dodaje funkcje exit poniewaz normalnie skrypt by przeszedl caly i nastepnie przekierowal by do innego pliku, szkoda mocy obliczeniowej dlatego exitem koncze przetwarzanie
    exit();
} else {
  unset($_SESSION['udana_rejestracja']);
}
?>
<!DOCTYPE html>
<html lang="pl">
  <head>
     <meta charset="utf-8">
     <title>Moja witryna</title>

     <meta name="description" content="Opis zawartości strony dla wyszukiwarek">
     <meta name="keywords" content="słowa, kluczowe, opisujące, zawartość">
     <meta name="author" content="Jan Programista">

     <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
     <link rel="stylesheet" href="style.css" type="text/css">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

     <script src="skrypt.js"></script>
  </head>
  <body>
    Dzieki za rejestracje, mozesz sie juz logowac
<a href="index.php">Zaloguj sie na swoje konto </a><br><br>

   
  </body>

</html>