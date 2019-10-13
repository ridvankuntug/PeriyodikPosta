<?php require("funcs/headerphp.php");


$ad = $_POST["ad"];
$sure = $_POST["sure"];
$periyot = $_POST["periyot"];//grup-ekle.php sayfasından gelen veriler

if($_SESSION["kullaniciYetki"] < 2){//Admin tarafından yetki verilmiş mi kontrolü
  echo '<meta http-equiv="refresh" content="0;URL=index.php">';
}
else if($ad == "" || $sure == "" || $periyot == ""){//Boş bırakılan alan kontrolü
  echo '<div class="alert alert-danger" role="alert"> Boş bıraktığınız alanlar var. </div>';
}
else{

  try{
    $query = $db->prepare("INSERT INTO gruplar SET
      grup_ad = ?,
      sure = ?,
      periyot = ?");
    $insert = $query->execute(array(
      $ad,
      $sure,
      $periyot,
    ));//Sql veri kaydı

    if($insert){
      echo '<div class="alert alert-success" role="alert"> Kayıt başarılı. Grup listesini görüntülemek için <a href="grup-listesi.php">tıklayınız</a>.</div>';
    }//kayıt başarılı mı kontrol ediyoruz
    else{
      echo '<div class="alert alert-danger" role="alert"> Bir sorun oluştu.</div>';
    }//değilse uyarı veriyoruz
  }catch(Exception $e) {
    echo '<div class="alert alert-danger" role="alert"> Bir sorun oluştu. </div>';
  }//hata varsa uyarı veriyoruz
}

?>