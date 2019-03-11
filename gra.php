<?php 
session_start();

if (!isset($_SESSION['zalogowany'])){
    header('Location:index.php');
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
    
  <?php 
  echo "<p>Elo " . $_SESSION['user'] . '! [<a href="logout.php">Wyloguj sie!</a>]</p>' ;
        
        echo "<p><b>Drewno: </b>" .$_SESSION['drewno'];
       echo " | <b>Kamień: </b>" .$_SESSION['kamien'] ;
       echo " | <b>Zboże: </b>" .$_SESSION['zboze'] ;
       echo " <p> <b>E-mail: </b>" .$_SESSION['email'] ;
       echo " <br><b>Dni premium: </b>" .$_SESSION['dnipremium'] . "</p>" ;
       
  ?>
      
  </body>

</html>