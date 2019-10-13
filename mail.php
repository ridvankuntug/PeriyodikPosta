<?php
require("funcs/headerphp.php");//Sql, Session gibi sistemlerin çalışmaswı için gerekli fonksiyonları çağırıyor
date_default_timezone_set('Europe/Istanbul');//Türkiye saati olduğunu gösteriyor

include 'PHPMailer\class.phpmailer.php';//Mail göndermemiz için gereken hazır sınıfı çağırıyoruz
include 'PHPMailer\language\phpmailer.lang-tr.php';//Hata mesajlarını türkçeye çeviriyor

try{
  $query = $db->query("SELECT *
  FROM kisiler
  JOIN gruplar ON kisiler.grup_id = gruplar.grup_id
  ")->fetchAll(PDO::FETCH_ASSOC);//Kişileri ve bağlı oldukları grupları getiriyor
  $i=0;
  foreach ($query as $row) {
    $ad = $row["kisi_ad"];
    $eposta = $row["eposta"];
    $is = $row["grup_ad"];//Kullanım kolaylığı için aldığı verileri değişkenlere atıyoruz

    if($row["periyot"] == 2){//Periyot 2 ise haftalık sistem çalışıyor
      for($i=1 ; $i<1920 ; $i++){//1920 hafta geriye giderek mail günü olan kullanıcı var mı kontrol ediyor
        if(date("Y-m-d", strtotime("-".$row["sure"]*$i.' week')) == $row["baslangic"]){//Günümüzün tarihini veritabanındaki sure değeri ile döngünün i değişkenini çarparak zamnı geriye doğru sarıyor ve eşleşme bulduğunda çalışıyor
          $zaman = 'bu gün';//işin bu gün olduğunu belirtiyor
          mailGonder($ad, $eposta, $is, $zaman);//mail gönder fonksiyonuna gerekli verileri gönderiyor
        }
        if(date("Y-m-d", strtotime("-".$row["sure"]*$i.' week +1 day')) == $row["baslangic"]){
          $zaman = 'yarın';
          mailGonder($ad, $eposta, $is, $zaman);
        }//Aynı işlemleri 1 gün önceden haber verecek şekilde uyguluyor
      }
    }
    else if($row["periyot"] == 3){
      for($i=1 ; $i<480 ; $i++){
        if(date("Y-m-d", strtotime("-".$row["sure"]*$i.' month')) == $row["baslangic"]){
          $zaman = 'bu gün';
          mailGonder($ad, $eposta, $is, $zaman);
        }//Aynı işlemleri aylık olarak uyguluyor
        if(date("Y-m-d", strtotime("-".$row["sure"]*$i.' month +3 day')) == $row["baslangic"]){
          $zaman = '3 gün sonra';
          mailGonder($ad, $eposta, $is, $zaman);;
        }//Ama bukez 3 gün önce haber veriyor
      }
    }
    else if($row["periyot"] == 4){
      for($i=1 ; $i<40 ; $i++){
        if(date("Y-m-d", strtotime("-".$row["sure"]*$i.' year')) == $row["baslangic"]){
          $zaman = 'bu gün';
          mailGonder($ad, $eposta, $is, $zaman);
        }//Aynı işlemleri Yıllık olacak şekilde uyguluyor
        if(date("Y-m-d", strtotime("-".$row["sure"]*$i.' year +1 week')) == $row["baslangic"]){
          $zaman = 'haftaya';
          mailGonder($ad, $eposta, $is, $zaman);
        }//Ama bu kez 1 hafta önce haber veriyor
      }
    }
  }
}catch(Exception $e) {
  echo $e;
}

function mailGonder($mAd, $mEposta, $mIs, $mZaman){//PHPMailer sınıfının kullanmamızı istediği kalıp
  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SMTPAuth = true;
  $mail->Host = 'smtp.gmail.com';//Gmail kullandığımız için Gmail'in smtp serverını yazıyoruz
  $mail->Port = 587;//Google smtp tls portu
  $mail->SMTPSecure = 'tls';//kullandığımız sistemde ssl olmadığı için tls kullanıyoruz
  $mail->Username = 'isgharranuniv@gmail.com';//Gönderici e-posta adresi
  $mail->Password = 'isg.harran63';//Gönderici e-posta şifresi
  $mail->SetFrom($mail->Username, 'ISG Harran');//Gönderen adı
  $mail->AddAddress($mEposta, $mAd);//Alıcı e-posta ve adı
  $mail->CharSet = 'UTF-8';//Karakter seti
  $mail->Subject = 'ISG Harran Periyodik Hatırlatma Sistemi';//E-posta konusu
  $content = '<div style="background: #eee; padding: 10px; font-size: 14px">Sayın '.$mAd.', Lütfen '.$mZaman.' '.$mIs.' kontrolünüzü unutmayın</div>';//E-posta içeriği
  $mail->MsgHTML($content);//Bütün verileri değişkene alıyoruz
  if($mail->Send()) {//Verileri PHPMailer sınıfına gönderiyoruz ve sonucu alıyoruz
      echo $mEposta.': Gönderildi </br>';//Gönderilen e-postaları listeliyoruz
  } else {
      // bir sorun var, sorunu ekrana bastıralım
      echo $mEposta.': '.$mail->ErrorInfo.' </br>';//Gönderilemeyen e-postaları listeliyoruz
  }
}


?>