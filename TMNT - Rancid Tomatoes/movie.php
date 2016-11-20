<?php
/**
 * Created by PhpStorm.
 * User: Gregoris
 * Date: 11/20/2016
 * Time: 4:16 PM
 */
$movie = $_GET["film"];
$title=$movie;

$myfile = fopen($movie."/info.txt", "r");
// Output one line until end-of-file
$count=0;
while(!feof($myfile)) {
    $info[$count]=fgets($myfile);
    $count++;
}
if ($info[2]>=60){
    $rateimg='fresh.jpg';
}
else{
    $rateimg='rottenbig.png';
}
fclose($myfile);

$myfile = fopen($movie."/overview.txt", "r");
// Output one line until end-of-file
$overview='';
while(!feof($myfile)) {
    $overview=$overview.'<dt>'.fgets($myfile).'</dt>';
}
fclose($myfile);

$count_files=0;
$flag=0;
$reviews0='';
$reviews1='';
foreach (glob($movie."/review*.txt") as $filename) {
    $count_files++;

    $myfile = fopen($filename, "r");
    // Output one line until end-of-file
    $count_line=0;
    while(!feof($myfile)) {
        $lines[$count_line]=fgets($myfile);
        $count_line++;
    }
    fclose($myfile);
    if ($flag==0){
        $flag=1;
        $reviews0=$reviews0.'<div class="reviewquote">';

        if (strpos($lines[1], 'ROTTEN', 0)=== 0){
            $reviews0=$reviews0.'<img class="likeimg" src="images/rotten.gif" alt="rotten">';
        }
        else {
            $reviews0=$reviews0.'<img class="likeimg" src="images/fresh.gif" alt="fresh">';
        }

        $reviews0=$reviews0.$lines[0].'</div><div class="personalquote"><img class="personimg" src="images/critic.gif" alt="critic">'
            .$lines[2].'<br>'.$lines[3].'</div>';
    }
    else{
        $flag=0;
        $reviews1=$reviews1.'<div class="reviewquote">';
        if (strpos($lines[1], 'ROTTEN', 0)=== 0){
            $reviews1=$reviews1.'<img class="likeimg" src="images/rotten.gif" alt="rotten">';
        }
        else {
            $reviews1=$reviews1.'<img class="likeimg" src="images/fresh.gif" alt="fresh">';
        }

        $reviews1=$reviews1.$lines[0].'</div><div class="personalquote"><img class="personimg" src="images/critic.gif" alt="critic">'
            .$lines[2].'<br>'.$lines[3].'</div>';
    }
}
?>


<!DOCTYPE html>
<html><head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title> <?=$info[0]?> - Rancid Tomatoes</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="movie.css">
    <link rel="shortcut icon" type="image/gif" href="images/rotten.gif">
</head>
<body>
<div id="banner"><img src="images/banner.png" alt="banner"></div>
<h1><?=$info[0]?> (<?=$info[1]?>)</h1>
<div id="overall">
    <div id="Overview">
        <img src="<?=$movie?>/overview.png" alt="overview">
        <dl class="OverViewdl">
            <?=$overview?>
        </dl>
    </div>
    <div id="reviews">
        <div id="reviewsbar">
            <img id="reviewsbarimg" src="images/<?=$rateimg?>" alt="overview">
            <div id="rate"><?=$info[2]?>%</div>
        </div>
        <div class="reviewcol">
            <?=$reviews0?>
        </div>
        <div class="reviewcol">
            <?=$reviews1?>
        </div>
    </div>
    <div id="bottombar">
        (1-<?=$count_files?>) of <?=$count_files?>
    </div>
</div>
<div id="w3ccheck">
    <a href="http://validator.w3.org/check/referer"><img src="images/w3c-html.png" alt="Valid HTML5"></a> <br>
    <a href="http://jigsaw.w3.org/css-validator/check/referer"><img src="images/w3c-css.png" alt="Valid CSS"></a>
</div>

</body></html>