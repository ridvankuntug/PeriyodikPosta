<?php
  require("funcs/headerphp.php");//Daha önce yazdığımız gerekli php fonksiyonlarını çağırıyor
  session_destroy();//Global Session değişkenlerimizi sıfırlıyor
  echo '<input type="button" class="btn btn-primary" value="Çıkılıyor">';
  echo '<meta http-equiv="refresh" content="0;URL=index.php">';//Anasayfaya dönüyor
?>