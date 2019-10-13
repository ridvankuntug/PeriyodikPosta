<?php require("funcs/headerphp.php");
$yetki = $_GET["yetki"];
$sil = $_GET["sil"];//kullanıcı-yetkileri.php sayfasından gelen veriler

if($_SESSION["kullaniciYetki"] < 5){//İşlemi sadece admin yaptı ise gerçekleşiyor
  echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}
else if($yetki > 1){//Yetki işlemi mi yapılacağını kontrol ediyor
  try{
    $query = $db->prepare("UPDATE kullanici SET
    kullanici_yetki = :yeni_yetki
    WHERE kullanici_id = :id");
    $update = $query->execute(array(
      "yeni_yetki" => 2,
      "id" => $yetki
    ));//Kullanıcı yetkisini 2 olarak güncelliyor
    if ($update){//İşlem başarılı mı diye kontrol ediyor
      echo '<meta http-equiv="refresh" content="0;URL=kullanici-yetkileri.php?basarili=Yetki verildi.">';
    }
    else{
      echo '<meta http-equiv="refresh" content="0;URL=kullanici-yetkileri.php?hata=Bir%20Sorun%20Oluştu.">';
    }
  }catch(Exception $e) {
    echo '<meta http-equiv="refresh" content="0;URL=kullanici-yetkileri.php?hata=Bir%20Sorun%20Oluştu.">';
  }
}
else if($sil > 1){//Silme işlemi mi yapılacağını kontrol ediyor
  try{
    $query = $db->prepare("DELETE FROM kullanici WHERE
    kullanici_id = ?");
    $delete = $query->execute(array(
      $sil
    ));//Sil değişkeni içerisinde gelen IDli kişiyi siliyor

    if($delete){//İşlem başarılı mı diye kontrol ediyor
      echo '<meta http-equiv="refresh" content="0;URL=kullanici-yetkileri.php?basarili=Silindi.">';
    }
    else{
      echo '<meta http-equiv="refresh" content="0;URL=kullanici-yetkileri.php?hata=Bir%20Sorun%20Oluştu.">';
    }
  }catch(Exception $e) {
    echo '<meta http-equiv="refresh" content="0;URL=kullanici-yetkileri.php?hata=Bir%20Sorun%20Oluştu.">';
  }
}
else{
  echo '<meta http-equiv="refresh" content="0;URL=kullanici-yetkileri.php?hata=Yanlış%20Id.">';
}
?>