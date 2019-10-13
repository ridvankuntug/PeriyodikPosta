<?php
  include("funcs/headerphp.php");//Gerekli php fonksiyonlarını yazdığımız sayfadan çağırıyor

  $eposta1 = $_POST["eposta1"];
  $sifre1 = $_POST["sifre1"];//giris.php sayfasından gelen kullanıcı verileri

  if(!filter_var($eposta1, FILTER_VALIDATE_EMAIL)){//Eposta biçimini kontrol ediyoruz
    echo '<div class="alert alert-danger" role="alert"> E-Posta biçimi yanlış. </div>';
  }
  else if($eposta1 == "" || $sifre1 == ""){//Eposta ve şifre alanlarına giriş yapılıp yapılmadığını kontrol ediyoruz
    echo '<div class="alert alert-danger" role="alert"> Boş bıraktığınız alanlar var. </div>';
  }
  else{
    try{
      $sifre1 = sha1(md5($sifre1));//Kullanıcı şifresi veritabanında şifreli tutulduğu için kontrolü yaparken de tekrar şifreliyoruz
      $select = $db->query("SELECT * FROM kullanici WHERE
        kullanici_eposta = '$eposta1' AND kullanici_sifre = '$sifre1'
      ")->fetch(PDO::FETCH_ASSOC);//Bu kullanıcı adı ile şifresi eşleşiyor mu diye kontrol ediyoruz
      if($select){
        $_SESSION["kullaniciAdi"] = ucwords(strtolower($select["kullanici_ad"]));
        $_SESSION["kullaniciYetki"] = $select["kullanici_yetki"];
        $_SESSION["kullaniciID"] = $select["kullanici_id"];//Daha sonra lazım olacak verileri her seferinde veritabanına gitmemek için global Session değişkenlerine atıyoruz
        echo '<div class="alert alert-success" role="alert"> Hoşgeldin ' .$_SESSION["kullaniciAdi"]. '. Birazdan anasayfaya yönlendirileceksin. Ya da beklemek istemiyorsan <a href="index.php">tıkla</a>.</div>';//giris.php sayfasında görünecek olan hoşgeldin mesajı
        echo '<meta http-equiv="refresh" content="3;URL=index.php">';//3sn bekleyip anasaydfaya yönlendiriyoruz
      }
      else{
        echo '<div class="alert alert-danger" role="alert"> Kullanıcı bulunamadı. </div>';//giris.php sayfasında görünecek olan uyarı mesajı
      }
    }
    catch(Exception $e) {
      echo '<div class="alert alert-danger" role="alert"> Kullanıcı bulunamadı. </div>';//giris.php sayfasında görünecek olan uyarı mesajı
    }
  }

?>