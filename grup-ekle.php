<?php require("inc/header.php"); ?>

<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-9">
      <!-- Site İçeriği Başlangıcı -->
      <?php
        if($_SESSION["kullaniciYetki"] < 2){//Kullıcıya admin tarafından yetki verilip verilmediğini kontrol ediyor
          echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
        else{//Yetki varsa sayfa içeriği görüntüleniyor
      ?>
      <script type="text/javascript">
        function grupKaydet1(){

          var ad = $("#ad").val();
          var sure = $("#sure").val();
          var e = document.getElementById("periyot");
          var periyot = e.options[e.selectedIndex].value;

          $.post('grup-kaydet.php', {ad: ad, sure: sure, periyot: periyot}, function (gelen_cevap) {
              success:$('#sonucForm').html(gelen_cevap);
          });
        }
      </script><!-- grup-kaydet.php sayfasına eklenecek grup bilgilerini yollayan jquery kodu -->
      <form class="col-6">
        <h5>Mail Grubu Bilgileri</h5>
        <div class="form-group">
          <label for="ad">Grup Adı:</label>
          <input type="text" class="form-control" id="ad" name="ad">
        </div>
        <div class="form-group">
          <label for="periyot">Periyodu</label>
          <div class="row">
            <div class="col">
              <input type="number" class="form-control" id="sure" name="sure">
            </div>
            <div class="col">
              <select class="custom-select"  id="periyot" name="periyot">
                <option value="2">Hafta</option>
                <option value="3">Ay</option>
                <option value="4" selected>Yıl</option>
              </select>
            </div>
          </div>
        </div>
        <div class="form-group" id="sonucForm"></div>
        <div class="form-group">
          <input type="button" class="btn btn-primary" onclick="grupKaydet1()" value="Kaydet"><!-- Doldurulan form bilgilerini fonksiyona gönderen buton -->
        </div>
      </form><!-- Eklenecek grup bilgilerini doldurduğumuz form -->
        <?php } ?>
      <!-- Site içeriği Sonu -->
    </div>
    <?php require("inc/right-menu.php"); ?>
  </div>
</div>

<?php require("inc/footer.php"); ?>