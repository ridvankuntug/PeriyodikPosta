<?php require("funcs/headerphp.php");
$id = $_GET["id"];//grup-listesi.php sayfasından gelen silinecek grubun ID'si

if($_SESSION["kullaniciYetki"] < 2){//Admin tarafından yetki verilmiş mi diye kontrol ediyoruz
  echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}
else if($id < 1){//ID verisi gelmedi ise uyarı veriyoruz
  echo '<meta http-equiv="refresh" content="0;URL=grup-listesi.php?hata=Yanlış%20Id.">';
}
else{
  try{

    $query = $db->prepare("DELETE FROM gruplar WHERE
    grup_id = ?");
    $delete = $query->execute(array(
    $id
    ));//IDye göre silen sql kodu

    if($delete){//Silme işleminin başarılı olup olmadığını kontrol ediyor
      echo '<meta http-equiv="refresh" content="0;URL=grup-listesi.php?basarili=Silindi.">';
    }
    else{
      echo '<meta http-equiv="refresh" content="0;URL=grup-listesi.php?hata=Bir%20Sorun%20Oluştu.">';
    }
  }catch(Exception $e) {
    echo '<meta http-equiv="refresh" content="0;URL=grup-listesi.php?hata=Bir%20Sorun%20Oluştu.">';
  }
}
?>