<?php 
session_start();
//sesja umozliwia przekazywanie zmiennych pomiedzy podstronami w latwy sposob, z uzyciem globalnej tablicy asocjacyjnej o nazwie $_SESSION
//zmienne sa przechowywane po stronie serwera, a klient na swoim komputerze posiada tylko tzw identyfikator sesji PHPSESSID
if ((isset($_SESSION['zalogowany'])) &&  ($_SESSION['zalogowany']==true)){
    header('Location:gra.php');
    //dodaje funkcje exit poniewaz normalnie skrypt by przeszedl caly i nastepnie przekierowal by do innego pliku, szkoda mocy obliczeniowej dlatego exitem koncze przetwarzanie
    exit();
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
      <div class="container">
          <div class="row justify-content-center">
            <form class="form-group zaloguj_form" action="zaloguj.php" method="POST">
                Login: <br/> <input class="form-control" type="text" name="login"> <br/>
                Hasło: <br/> <input class="form-control" type="password" name="haslo"><br/><br/>
                <input class="form-control btn btn-success zaloguj_button" type="submit" value="zaloguj sie">
                <a href ="rejestracja.php" class="btn btn-primary form-control" >Zarejestruj się</a>
            </form>
            <?php 
            // Gdy ktos po raz pierwszy sie pojawi na stronie logowania to zmienna seession nie isnieje i generowalo by to blad. Gdy ktos jest po raz pierwszy to nie ma ustawionej zadnej sesji bo jeszcze niczego nie wyslal
            if (isset($_SESSION['blad'])) echo $_SESSION['blad'];
            ?>
          </div>
        
        </div>
   
  </body>

</html>