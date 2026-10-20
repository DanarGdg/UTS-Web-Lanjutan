<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function acakCaptcha() {
    $alphabet = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

    //untuk menyatakan $pass sebagai array
    $pass = array();

    //masukkan -2 dalam string length
    $panjangAlpha = strlen($alphabet) - 2;
    for ($i = 0; $i < 5; $i++) {
        $n = rand(0, $panjangAlpha);
        $pass[] = $alphabet[$n];
    }

    //ubah array menjadi string
    return implode($pass);
}

// untuk mengacak captcha
$code = acakCaptcha();
$_SESSION["code"] = $code;

//lebar dan tinggi captcha
$wh = imagecreatetruecolor(173, 50);

//background color biru
$bgc = imagecolorallocate($wh, 22, 86, 165);

//text color abu-abu
$fc = imagecolorallocate($wh, 223, 230, 233);

imagefill($wh, 0, 0, $bgc);

//( $image , $fontsize , $string , $fontcolor )
imagestring($wh, 10, 50, 15, $code, $fc);

// Cegah cache gambar
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

//buat gambar
header('Content-Type: image/jpeg');
imagejpeg($wh);
imagedestroy($wh);
?>

