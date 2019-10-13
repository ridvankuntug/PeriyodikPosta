<?php require("inc/header.php"); ?><!--TODO:-->

<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-9">
      <!-- Site İçeriği Başlangıcı -->
      <?php
        if($_SESSION["kullaniciYetki"] < 2){
          echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
        else{
      ?>
      <script type="text/javascript">
        function kisiKaydet1(){

          var ad = $("#ad").val();
          var eposta = $("#eposta").val();
          var gun = $("#gun").val();
          var ay = $("#ay").val();
          var yil = $("#yil").val();
          var g = document.getElementById("grup");
          var grup = g.options[g.selectedIndex].value;

          $.post('kisi-kaydet.php', {ad: ad, eposta: eposta, gun: gun, ay: ay, yil: yil, grup: grup}, function (gelen_cevap) {
              success:$('#sonucForm').html(gelen_cevap);
          });
        }
      </script><!-- Formdan gelen verileri kisi-kaydet.php sayfasına yönlendiren jquery kodu -->
      <form class="col-6">
        <h5>Kişi Bilgileri</h5>
        <div class="form-group">
          <label for="ad">İsim:</label>
          <input type="text" class="form-control" id="ad" name="ad">
        </div>
        <div class="form-group">
          <label for="eposta">E-Posta:</label>
          <input type="email" class="form-control" id="eposta" name="eposta">
        </div>
        <div class="form-group">
          <label for="baslagic">Başlangıç Tarihi:</label>
          <div class="row">
            <div class="col">
              <select class="custom-select"  id="gun" name="gun">
                <?php
                date_default_timezone_set('Europe/Istanbul');//Sisteme Türkiye saati olduğunu belirtiyoruz
                for($i = 01 ; $i <= 31 ; $i++){
                  if($i == date(d)){
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                  }
                  else{
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                }
                ?><!-- Select iteminde 1den 31 e kadar günleri sıralıyoruz ve bu günün tarihini seçiyoruz -->
              </select>
            </div>
            <div class="col">
              <select class="custom-select"  id="ay" name="ay">
                <?php
                $ay = array(" ", "Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık");
                for($i = 1 ; $i <= 12 ; $i++){
                  if($i == date(m)){
                    echo '<option value="'.$i.'" selected>'.$ay[$i].'</option>';
                  }
                  else{
                    echo '<option value="'.$i.'">'.$ay[$i].'</option>';
                  }
                }
                ?><!-- Select iteminde ayları sıralıyoruz ve bu günün tarihini seçiyoruz -->
              </select>
            </div>
            <div class="col">
              <select class="custom-select"  id="yil" name="yil">
                <?php
                for($i = 2019 ; $i <= 2050 ; $i++){
                  if($i == date(Y)){
                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                  }
                  else{
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                }
                ?><!-- Select iteminde yılları sıralıyoruz ve bu günün tarihini seçiyoruz -->
              </select>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="grup">Grubu:</label>
          <select class="custom-select"  id="grup" name="grup">
            <?php
              try{
                $query = $db->query("SELECT * FROM gruplar WHERE
                grup_id
                ")->fetchAll(PDO::FETCH_ASSOC);
                $i=0;
                foreach ($query as $row) {
                  if($row["periyot"] == 2){
                    $periyot = "Haftada bir.";
                  }
                  else if($row["periyot"] == 3){
                    $periyot = "Ayda bir";
                  }
                  else if($row["periyot"] == 4){
                    $periyot = "Yılda bir";
                  }//Veritabanında periyotlar rakam olarak tutulduğu için karşılıklarını yazıyoruz
                  echo '<option value="'.$row["grup_id"].'">'.++$i.'. Grup: '.$row["grup_ad"].' - Periyot: '.$row["sure"].' '.$periyot.'</option>';
                }
              }catch(Exception $e) {
                echo '<option>"Bir Sorun oluşmuş gibi görünüyor."</option>';
              }
            ?>
          </select><!-- Select itemi içine grup bilgilerini yazıyoruz -->
        </div>
        <div class="form-group" id="sonucForm"></div><!--  kisi-kaydet.php sayfasından gelen sonucu yazdırıyor-->
        <div class="form-group">
          <input type="button" class="btn btn-primary" onclick="kisiKaydet1()" value="Kaydet"><!-- Form bilgilerini Jquery fonksiyonuna yolluyoruz -->
        </div>
      </form>
        <?php } ?>
      <!-- Site içeriği Sonu -->
    </div>
    <?php require("inc/right-menu.php"); ?><!--TODO:-->
  </div>
</div>

<?php require("inc/footer.php"); ?><!--TODO:-->