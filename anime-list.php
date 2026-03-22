<?php
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
include 'database.php';
// echo $actual_link; 

$content = file_get_contents($sumber_data.'/anime-list');

preg_match('#<title>(.*)</title>#', $content, $title_fix);
$title = str_replace($nama_website_sumber_data, $nama_website, $title_fix[1]);

$r = get_meta_tags($sumber_data);
$meta_deskripsi = str_replace($nama_website_sumber_data, $nama_website, $r['description']);
// $meta_image = $r['msapplication-tileimage'];
$meta_image = $domain."/img/".$logo;
// print_r($r);


preg_match('#<div class="daftarkartun">(.*)</div>#', $content, $match);
$result = str_replace($sumber_data.'/anime', $domain.'/episode', $match[1]);
$result = str_replace($nama_website_sumber_data, $nama_website, $result);


$complete = $result;
// echo $complete;
?>

<!DOCTYPE html>
<html lang="en">
<head>
 <?php include 'head.php'; ?>
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <section class="col-md-12">
            <h2>Anime List</h2>
            <?php echo $complete; ?>
        </section>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
