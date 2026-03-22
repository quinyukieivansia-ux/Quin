<?php
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
include 'database.php';
// echo $sumber_data; 

$judul = explode('search', $actual_link);
// echo $judul[1];
$content = file_get_contents($sumber_data.'/'.$judul[1]);

preg_match('#<title>(.*)</title>#', $content, $title_fix);
$title = str_replace($nama_website_sumber_data, $nama_website, $title_fix[1]);

$r = get_meta_tags($sumber_data);
$meta_deskripsi = str_replace($nama_website_sumber_data, $nama_website, $r['description']);
$meta_image = $domain."/img/".$logo;

preg_match('#<div class="venser">(.*)</div>#', $content, $match);
$result = str_replace($sumber_data.'/episode', $domain.'/play', $match[1]);
$result = str_replace($sumber_data.'/anime', $domain.'/episode', $result);
$result = str_replace($sumber_data.'/genres', $domain.'/genres', $result);


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

    <div class="container" style="margin-bottom: 50px;">
        <section class="col-md-12">
            <h2 style="margin-top: 50px; text-transform: uppercase;">Search : <?php echo $_GET['s']; ?></h2>
            <?php echo $complete; ?>
        </section>
        
    </div>
    
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
