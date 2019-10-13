<?php require("inc/header.php"); ?>

<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-9">
      <!-- Site İçeriği Başlangıcı -->
      <ul class="list-group">
      <li class="list-group-item active">Kullanıcılar</li>
      <?php
      $hata = $_GET["hata"];
      $basarili = $_GET["basarili"];//Yetki ve sil düğmesine tıklandığında dönen veriyi değişkene alıyor
      if($hata){
        echo '<div class="alert alert-danger" role="alert">'.$hata.'</div>';
      }
      else if($basarili){
        echo '<div class="alert alert-success" role="alert">'.$basarili.'</div>';
      }//Yetki ve sil düğmesine tıklandığında dönen sonucu gösteriyor

      if($_SESSION["kullaniciYetki"] < 5){//Sayfaya sadece admin erişebiliyor
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
      }
      else{
        try{
          $query = $db->query("SELECT * FROM kullanici
          ")->fetchAll(PDO::FETCH_ASSOC);//Kullanıcı listesini çeken sql kodu
          $i=0;//Sayaç için değişken
          foreach ($query as $row) {
            if($row["kullanici_yetki"] <5){
              echo '<div class="list-group-item list-group-item-action">'.++$i.'- <b>İsim: </b>'.$row["kullanici_ad"].' <b>E-Posta: </b>'.$row["kullanici_eposta"].' <b>Yetki: </b>'.$row["kullanici_yetki"].' <a href="kullanici-yetkilendir.php?yetki='.$row["kullanici_id"].'"><button type="button" class="btn-sm btn-primary" >Yetki Ver</button></a><a href="kullanici-yetkilendir.php?sil='.$row["kullanici_id"].'"><button type="button" class="btn-sm btn-primary" >Sil</button></a></div>';
            }//Admin dışındaki herkesi listeliyoruz
          }
        }catch(Exception $e) {//hata olursa ekrana yazıyoruz
          echo '<div class="alert alert-success" role="alert"> Bir sorun oluşmuş gibi görünüyor. Anasayfaya dönmek için <a href="index.php">tıklayınız</a>.</div>';
        }
      }
      ?>
      </ul>
      <!-- Site içeriği Sonu -->
    </div>
    <?php require("inc/right-menu.php"); ?><!--TODO:-->
  </div>
</div>

<?php require("inc/footer.php"); ?><!--TODO:-->
