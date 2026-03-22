<?php
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
include 'database.php';
// echo $actual_link; 

$judul = explode('/lengkap/', $actual_link);
// echo $judul[1];
$content = file_get_contents($sumber_data.'/anime/'.$judul[1]);

preg_match('#<title>(.*)</title>#', $content, $title_fix);
$title = str_replace($nama_website_sumber_data, $nama_website, $title_fix[1]);

$r = get_meta_tags($sumber_data);
$meta_deskripsi = str_replace($nama_website_sumber_data, $nama_website, $r['description']);

include '_phpquery.php';
// Inisialisasi phpQuery
$doc = phpQuery::newDocument($content);
// Ambil semua tag img
$images = $doc->find('img');
$img = explode('srcset="', $images);
$img = explode(' 225w', $img['1']);
$meta_image = $img['0'];



preg_match('#<div id="venkonten">(.*)</div>#', $content, $match);
$result = str_replace($sumber_data.'/episode', $domain.'/play', $match[1]);
$result = str_replace($sumber_data.'/anime', $domain.'/episode', $result);
$result = str_replace($sumber_data.'/genres', $domain.'/genres', $result);
$result = str_replace('Otaku Desu', $nama_website, $result);


$complete = $result;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
    <style type="text/css">


    </style>
</head>
<body>


    <?php include 'header.php'; ?>

    <div class="container" style="margin-bottom: 50px;">
        <section class="col-md-12">
            <div class="iklan-banner">
                <?php include 'ads.php' ?>
            </div>
            <?php echo $complete; ?>
        </section>
        
    </div>
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
