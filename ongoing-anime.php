<?php
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
include 'database.php';

$judul = explode('/page/', $actual_link);
if(isset($judul[1]) != '') {
    $content = file_get_contents($sumber_data.'/ongoing-anime/page/'.$judul[1]);
}else{
    $content = file_get_contents($sumber_data.'/ongoing-anime/');
}

preg_match('#<title>(.*)</title>#', $content, $title_fix);
$title = str_replace($nama_website_sumber_data, $nama_website, $title_fix[1]);

$r = get_meta_tags($sumber_data);
$meta_deskripsi = str_replace($nama_website_sumber_data, $nama_website, $r['description']);
$meta_image = $domain."/img/".$logo;

preg_match('#<div class="rapi">(.*)</div>#', $content, $match);
$result = str_replace($sumber_data.'/ongoing-anime', $domain.'/ongoing-anime', $match[1]);
$result = str_replace($sumber_data.'/anime', $domain.'/episode', $result);
$result = str_replace($nama_website_sumber_data, $nama_website, $result);

$complete = $result;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include 'head.php'; ?>
</head>
<body>


    <?php include 'header.php'; ?>

    <div class="container" style="margin-bottom: 20px;">
        <section class="col-md-12">
            <div class="iklan-banner">
                <?php include 'ads.php' ?>
            </div>
            <h2 style="margin-top: 50px;">ON-GOING ANIME</h2>
            <?php echo $complete; ?>
        </section>

    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
