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

    //sprawdzenie czy oba hasla sa takie same oraz walidacja hasla
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];
    if ((strlen($haslo1)<8 || strlen($haslo1)>20)){
        $wszystko_OK=false;
        $_SESSION['e_haslo'] = "Haslo musi miec od 8 do 20 znakow";
    }

    if ($haslo1!=$haslo2){
        $wszystko_OK=false;
        $_SESSION['e_haslo'] = "Hasla sie nie zgadzajo";
    }

    $haslo_hash=password_hash($haslo1, PASSWORD_DEFAULT);
    // echo $haslo_hash; exit();

 
    //czy zostal zaakceptowany regulamin
    
    if (!isset($_POST['regulamin'])) {
        $wszystko_OK=false;
        $_SESSION['e_regulamin'] = "Akceptacja regulaminu jest wymagana";
    }

    //weryfikacja captchy

    $sekret = "6LecOpYUAAAAAGC1QJ7FBy5aSLdjCG_HKlq91rLH";
    
    $sprawdz = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$sekret.'&response='.$_POST['g-recaptcha-response']);

    $odpowiedz = json_decode($sprawdz);
    
    if ($odpowiedz->success==false){
        $wszystko_OK=false;
        $_SESSION['e_captcha'] = "Potwierdz ze nie jestes botem";
    }

    require_once "connect.php";
        //sprobuj sie polaczyc
    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        //jezeli wystapil jakis blad to rzuc bledem
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception (mysqli_connect_errno());
        }
        else {
            //czy email juz istnieje
            $rezultat = $polaczenie->query("SELECT id FROM uzytkownicy WHERE email='$email'");

            if (!$rezultat) throw new Exception($polaczenie->error);

            $ile_takich_maili = $rezultat->num_rows;
            if($ile_takich_maili>0) {
                $wszystko_OK=false;
                $_SESSION['e_email'] = "Istnieje juz konto o tym adresie email";
            }

            if ($wszystko_OK==true){
                //wszystkie testy zaliczone, dodajemy gracza
                echo "udana walidacja";
                
                if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$nick', '$haslo_hash', '$email', 100, 100, 100, 14)")){
                    $_SESSION['udana_rejestracja']==true;
                    header("Location:witamy.php");
                }
            }

            $polaczenie->close();
        }
    }
        //zlap blad ktory wystapil
    catch (Exception $e) {
        echo '<span style="color:red">Blad serwera, sorry gosciu!</span>';
        // echo "<br> Info dla mnie: ".$e;
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
        <?php
            if (isset($_SESSION['e_haslo'])){
                echo '<div class="error">' . $_SESSION['e_haslo']. '</div>';
                unset($_SESSION['e_haslo']);
            }
        ?> 
        Powtórz hasło <br> <input type="password" name="haslo2"><br>
          
        <label>
        <!-- label zamienia napis akceptuje regulamin na clickable -->
        <input type="checkbox" name="regulamin">Akceptuje regulamin 
        </label>
        <?php
            if (isset($_SESSION['e_regulamin'])){
                echo '<div class="error">' . $_SESSION['e_regulamin']. '</div>';
                unset($_SESSION['e_regulamin']);
            }
        ?>
        <div class="g-recaptcha" data-sitekey="6LecOpYUAAAAAEHb4JF4uVLESZ7RowY_2CuhJVJV"></div>
        <?php
            if (isset($_SESSION['e_captcha'])){
                echo '<div class="error">' . $_SESSION['e_captcha']. '</div>';
                unset($_SESSION['e_captcha']);
            }
        ?>
        <br>
        <input type="submit" value="Zarejestruj sie">
    </form>
</body>
</html>