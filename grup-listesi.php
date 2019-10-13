<?php require("inc/header.php"); ?>

<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-9">
      <!-- Site İçeriği Başlangıcı -->
      <ul class="list-group">
      <li class="list-group-item active">Gruplar</li>
      <?php
      $hata = $_GET["hata"];
      $basarili = $_GET["basarili"];//Sil düğmesine tıklandığında dönen veriyi değişkene alıyor
      if($hata){
        echo '<div class="alert alert-danger" role="alert">'.$hata.'</div>';
      }
      else if($basarili){
        echo '<div class="alert alert-success" role="alert">'.$basarili.'</div>';
      }//Sil düğmesine tıklandığında dönen sonucu gösteriyor

      if($_SESSION["kullaniciYetki"] < 1){//oturum açılıp açılmadığını kontrol ediyor
        echo '<meta http-equiv="refresh" content="0;URL=index.php">';
      }
      else{
        try{
          $query = $db->query("SELECT * FROM gruplar
          ")->fetchAll(PDO::FETCH_ASSOC);//Grup listesini çeken sql kodu
          $i=0;//Sayaç için değişken
          foreach ($query as $row) {
            if($row["periyot"] == 2){
              $periyot = "Haftada bir.";
            }
            else if($row["periyot"] == 3){
              $periyot = "Ayda bir";
            }
            else if($row["periyot"] == 4){
              $periyot = "Yılda bir";
            }//periyot verisini veritabanın da rakamlar ile tuttuğumuz için gelen verinin karşılıklarını belirliyoruz
            echo '<div class="list-group-item list-group-item-action">'.++$i.'- <b>Grup: </b>'.$row["grup_ad"].' <b>Periyot: </b><i>'.$row["sure"].'</i> '.$periyot.'</i> <a href="grup-sil.php?id='.$row["grup_id"].'"><button type="button" class="btn-sm btn-primary" >Sil</button></a></div>';//grup bilgilerini ekrana yazıp sil butonuna silinecek grubun IDsini atıyoruz
          }
        }catch(Exception $e) {//hata olursa ekrana yazıyoruz
          echo '<div class="alert alert-success" role="alert"> Bir sorun oluşmuş gibi görünüyor. Anasayfaya dönmek için <a href="index.php">tıklayınız</a>.</div>';
        }
      }
      ?>
      </ul>
      <!-- Site içeriği Sonu -->
    </div>
    <?php require("inc/right-menu.php"); ?>
  </div>
</div>

<?php require("inc/footer.php"); ?>
