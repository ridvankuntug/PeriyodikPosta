<?php require("inc/header.php"); ?><!--TODO:-->

<div class="container" style="margin-top:30px">
  <div class="row">
    <div class="col-sm-9">
      <!-- Site İçeriği Başlangıcı -->
      <?php
        if($_SESSION["kullaniciYetki"] > 0){//Kullanıcı zaten oturum açmış ise anasayfaya dönüyor
          echo '<meta http-equiv="refresh" content="0;URL=index.php">';
        }
        else{
      ?>
      <script type="text/javascript">
        function uyeOl1(){

          var isim1 = $("#isim1").val();
          var eposta1 = $("#eposta1").val();
          var sifre1 = $("#sifre1").val();
          var sifre2 = $("#sifre2").val();

          $.post('uye-ol-kontrol.php', {isim1: isim1, eposta1: eposta1, sifre1: sifre1, sifre2: sifre2}, function (gelen_cevap) {
              success:$('#sonucForm').html(gelen_cevap);
          });
        }
      </script><!-- Kullanıcı bilgilerini uye-ol-kontrol.php sayfasına gönderen Jquery kodu -->
      <form class="col-6">
        <div class="form-group">
          <label for="isim1">Ad Soyad</label>
          <input type="text" class="form-control"  id="isim1" name="isim1" placeholder="Tam Adınız" required>
        </div>
        <div class="form-group">
          <label for="eposta1">E-Posta</label>
          <input type="email" class="form-control" id="eposta1" name="eposta1" aria-describedby="emailHelp" placeholder="E-Postanız" required>
          <small id="emailHelp" class="form-text text-muted">E-Posta adresinizi başkaları ile paylaşmayız.</small>
        </div>
        <div class="form-group">
          <label for="sifre1">Şifre</label>
          <input type="password" class="form-control" id="sifre1" name="sifre1" placeholder="Şifreniz" required>
        </div>
        <div class="form-group">
          <label for="sifre2">Şifre</label>
          <input type="password" class="form-control" id="sifre2" name="sifre2" placeholder="Şifreniz Tekrar" required>
        </div>
        <div class="form-group" id="sonucForm"></div>
        <div class="form-group">
          <input type="button" class="btn btn-primary" onclick="uyeOl1()" value="Kaydol">
        </div>
      </form><!-- Üye bilgileri formu -->
        <?php } ?>

      <!-- Site içeriği Sonu -->
    </div>
    <?php require("inc/right-menu.php"); ?><!--TODO:-->
  </div>
</div>

<?php require("inc/footer.php"); ?><!--TODO:-->
