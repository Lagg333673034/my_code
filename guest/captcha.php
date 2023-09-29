<?php
session_start();
require_once('../_sol.php');

$width = 195;				//Ширина изображения
$height = 50;				//Высота изображения
$font_size = rand(14,16);   //Размер шрифта
$let_amount = rand(5,6);	//Количество символов, которые нужно набрать
$fon_let_amount = 30;		//Количество символов на фоне
$rand2 = mt_rand(1,3);      //случайный шрифт   1-3
//---------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------//
//php 5
//$font = "../fonts/captcha_font".$rand2.".ttf";	//Путь к шрифту

//php 7,8
$font = realpath("../fonts/captcha_font".$rand2.".ttf");    //Путь к шрифту
//---------------------------------------------------------------------------------//
//---------------------------------------------------------------------------------//
//набор символов
$letters = array("1","2","3","4","5","6","7","8","9","0");

$src = imagecreatetruecolor($width,$height);	        //создаем изображение
$fon = imagecolorallocate($src,0,0,0);	//создаем фон
imagefill($src,0,0,$fon);						    //заливаем изображение фоном

for($i=0,$shag=1,$sdvig_x=rand(1,20);$i < $let_amount;$i++,$shag+=0.1)		//то же самое для основных букв
{
    $color = imagecolorallocatealpha($src,
        rand(100,255),
        rand(100,255),
        rand(100,255),
        0);
    $letter = $letters[rand(0,sizeof($letters)-1)];
    $size = rand($font_size*2-3,$font_size*2+3);
    $x = round($i*$shag*$font_size);		//даем каждому символу случайное смещение
    $y = round((($height*2)/3) + 3);
    $cod[] = $letter;   						            //запоминаем код
    imagettftext($src,$size,rand(-25,25),$x+$sdvig_x,$y,$color,$font,$letter);

}

$cod = implode("",$cod);					  //переводим код в строку
$_SESSION["rand"] = md5($cod.$sol_captcha);   // Сохраняем значение переменной  $rand ( капчи ) в сессию

header ("Content-type: image/png"); 		  //выводим готовую картинку
imagepng($src);
imagedestroy($src);

?>