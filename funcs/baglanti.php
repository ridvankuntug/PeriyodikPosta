<?php
$host = "localhost";//Server adı
$dbname = "periyodikposta";//Veritabanı adı
$kullanici = "root";//Veritabanı kullanıcı adı
$sifre = "";//Veritabanı şifresi

try{
    $db = new PDO("mysql:host=$host;dbname=$dbname; charset=utf8", "$kullanici", "$sifre");//Pdo sınıfı ile veri tabanı bağlantısını yukarıda girdiğimiz değişkenlere göre yapıyoruz
}
catch (PDOException $e){//Hata varsa yakalıyoruz ve $e değişkenine atıyoruz
    print $e->getMessage();//Hatayı ekrana yazıyoruz
}