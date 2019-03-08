<?php 
session_start();
//jezeli jakies pole jest ustawione to tylko wtedy bede walidowac inputy
if (isset($_POST['email'])){
    //udana walidacja
    $wszystko_OK = true;

    //sprawdzenie poprawnosci nickname
    $nick = $_POST['nick'];

    //sprawdzenie dlugosci nicka
    if (strlen($nick)<3 || (strlen($nick)>20)){
        $wszystko_OK=false;
        $_SESSION['e_nick'] = "Nick musi posiadac od 3 do 20 znakow";
    }
    //sprawdzenie czy nick sklada sie tylko z liter i cyfr bez polskich znakow
    if (ctype_alnum($nick)==false){
        $wszystko_OK=false;
        //jezeli oba warunki sa nie spelnione pokjaze sie tylko blad o tym ostatnim
        $_SESSION['e_nick'] = "Nick moze skladac sie tylko z liter i cyfr bez polskich znakow";
    }

    //sprawdzenie poprawnosci emailu
    $email = $_POST['email'];
    //sanityzacja emaila, usowa niepotrzebne znaki z adresu email
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);
    
    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email)){
        $wszystko_OK = false;
        $_SESSION['e_email']="Podaj poprawny e-mail!";
    }

    if ($wszystko_OK==true){
        //wszystkie testy zaliczone, dodajemy gracza
        echo "udana walidacja";
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
     <meta charset="utf-8">
     <title>Zaloz darmowe konto</title>

     <meta name="description" content="Opis zawartości strony dla wyszukiwarek">
     <meta name="keywords" content="słowa, kluczowe, opisujące, zawartość">
     <meta name="author" content="Jan Programista">

     <meta http-equiv="X-Ua-Compatible" content="IE=edge,chrome=1">
     <link rel="stylesheet" href="style.css" type="text/css">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <script src="https://www.google.com/recaptcha/api.js" async defer></script>
     <script src="skrypt.js"></script>

     <style>
         .error 
         {
             color:red;
             margin-top: 10px;
             margin-bottom: 10px;
         }
     </style>
</head>
<body>
    <form method="POST" action="rejestracja.php">
        Nickname <br> <input type="text" name="nick"><br>
        <?php
            if (isset($_SESSION['e_nick'])){
                echo '<div class="error">' . $_SESSION['e_nick']. '</div>';
                unset($_SESSION['e_nick']);
            }
        ?>
        E-mail <br> <input type="text" name="email"><br>   
        <?php
            if (isset($_SESSION['e_email'])){
                echo '<div class="error">' . $_SESSION['e_email']. '</div>';
                unset($_SESSION['e_email']);
            }
        ?>     
        Twoje hasło <br> <input type="password" name="haslo1"><br>
        Powtórz hasło <br> <input type="password" name="haslo2"><br>
        <label>
        <!-- label zamienia napis akceptuje regulamin na clickable -->
        <input type="checkbox" name="regulamin">Akceptuje regulamin 
        </label>
        <div class="g-recaptcha" data-sitekey="6LecOpYUAAAAAEHb4JF4uVLESZ7RowY_2CuhJVJV"></div>
        <br>
        <input type="submit" value="Zarejestruj sie">
    </form>
</body>
</html>