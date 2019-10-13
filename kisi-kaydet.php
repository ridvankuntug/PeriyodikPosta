<?php require("funcs/headerphp.php");


$ad = $_POST["ad"];
$eposta = $_POST["eposta"];
$gun = $_POST["gun"];
$ay = $_POST["ay"];
$yil = $_POST["yil"];
$tarih = $yil.'-'.$ay.'-'.$gun;
$grup = $_POST["grup"];//kisi-ekle.php sayfasından gelen veriler

if($_SESSION["kullaniciYetki"] < 2){//Admin yetki vermiş mi
  echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}
else if($ad == "" || $eposta == "" || $grup == ""){//Boş bırakılan alan var mı
  echo '<div class="alert alert-danger" role="alert"> Boş bıraktığınız alanlar var. </div>';
}
else{

  try{
    $query = $db->prepare("INSERT INTO kisiler SET
      kisi_ad = ?,
      eposta = ?,
      baslangic = ?,
      grup_id = ?");
    $insert = $query->execute(array(
      $ad,
      $eposta,
      $tarih,
      $grup,
    ));//Kaydı yapan sql kodu

    if($insert){//Kayıt başarılı mı kontrolü
      echo '<div class="alert alert-success" role="alert"> Kayıt başarılı. Kişi listesini görüntülemek için <a href="kisi-listesi.php">tıklayınız</a>.</div>';
    }
    else{
      echo '<div class="alert alert-danger" role="alert"> Bir sorun oluştu.</div>';
    }
  }catch(Exception $e) {
    echo '<div class="alert alert-danger" role="alert"> Bir sorun oluştu. </div>';
  }
}
?>