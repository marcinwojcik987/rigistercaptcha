<?php
session_start();
if ((!isset($_POST['login'])) || (!isset($_POST['haslo']))){
    header('Location:index.php');    
    exit();
}
require_once "connect.php";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name)or 
die($mysql->error);

$login = $_POST['login'];
$haslo = $_POST['haslo'];

//encje htmla zapobiegajace sql injection
$login = htmlentities($login, ENT_QUOTES, "UTF-8");
$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");

$sql = "SELECT * FROM uzytkownicy WHERE user='$login' AND pass='$haslo'";

//w tym ifie sprawdzam gdy w zapytaniu wystapil blad np czy nie ma literowki w zapytaniu
if ($rezultat = $polaczenie->query($sql)) {
    //ilu userow o tym loginie i hasle
    $ilu_userow = $rezultat->num_rows;
    
    if ($ilu_userow>0) {
        //jezeli jest to znaczy ze udalo sie zalogowac
        //flaga = zmienna typu bool ktora ustawiay jako symbol zajscia czegos w kodzie, tutaj jezeli ktos jest zalogowany
        $_SESSION['zalogowany'] = true;

        $wiersz = $rezultat->fetch_assoc();
        //id uzytkownika przyda sie do zapytan zmieniajacych jakies jego dane profilowe
        $_SESSION['id'] = $wiersz['id'];
        $_SESSION['user'] = $wiersz['user'];
        $_SESSION['drewno'] = $wiersz['drewno'];
        $_SESSION['kamien'] = $wiersz['kamien'];
        $_SESSION['zboze'] = $wiersz['zboze'];
        $_SESSION['email'] = $wiersz['email'];
        $_SESSION['dnipremium'] = $wiersz['dnipremium'];

        //usuwam sesje z bledem poniewaz gdy sie zaloguje wszystko jest okej i nie chce wypluwac komunikatu o bledzie
        unset($_SESSION['blad']);
        //pozbywamy sie z pamieci niepotrzebnych rzeczy bo sa juz w zmiennych z php
        $rezultat->close();        
        header("Location: gra.php");

    } else {
        $_SESSION['blad'] = '<span style="color:red">Nieprawidlowy login lub haslo!</span>';
        header('Location:index.php');
    }
} else {
    echo "literowka w zapytaniu";
}

$polaczenie->close();


?>