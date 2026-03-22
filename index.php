<?php include 'database.php';
// echo $sumber_data; 
$actual_link = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$content = file_get_contents($sumber_data);

preg_match('#<div class="venz">(.*)</div>#', $content, $match);
$complete = $match[1];
// echo $complete;

preg_match('#<title>(.*)</title>#', $content, $title_fix);
$title = str_replace($nama_website_sumber_data, $nama_website, $title_fix[1]);

$r = get_meta_tags($sumber_data);
$meta_deskripsi = str_replace($nama_website_sumber_data, $nama_website, $r['description']);
$meta_image = $domain."/img/".$logo;





preg_match_all('/\b' . preg_quote('<div class="venz">', '') . '\b/i', $content, $matches);

preg_match_all('/<li>(.*?)<\/li>/', $complete, $matches);
$cc = array_pop($matches);

preg_match_all('/<h2(.*)class(.*)=(.*)"jdlflm">(.*)<\/h2>/U', $complete, $result_judul_complete);
$judul_complete = array_pop($result_judul_complete);
$total_complete = count($judul_complete);
$content_genres = file_get_contents($sumber_data.'/genre-list');

preg_match('#<div class="venser">(.*)</div>#', $content_genres, $match_genres);
$result_genres = str_replace('/genres', $domain.'/genres', $match_genres[1]);
$complete_genres = $result_genres;


?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php include 'head.php'; ?>
</head>
<body>
 <?php include 'header.php'; ?>

 <div class="container home">
    <section class="col-md-12">
        <div class="iklan-banner">
            <?php 
            $count = count($banner_iklan);
            for ($i=0; $i < $count; $i++) { 
                if ($banner_iklan[$i][1] != "") {
                    if ($banner_iklan[$i][0] != "") { ?>
                        <a href="<?php echo $banner_iklan[$i][0]; ?>"><img src="<?php echo $domain."/img/".$banner_iklan[$i][1]; ?>" style="width: 100%; margin-top: 5px;"></a>
                    <?php }else{ ?>
                        <img src="<?php echo $domain."/img/".$banner_iklan[$i][1]; ?>" style="width: 100%; margin-top: 5px;">
                    <?php }
                }
            } ?>
        </div>
        <h2 class="judul-kategori">GENRE LIST</h2>
        <div class="row">
            <?php echo $complete_genres; ?>
        </div>
    </section>
    <section class="col-md-12">
        <h2 class="judul-kategori">ON-GOING ANIME</h2>
        <div class="row">
            <?php for ($i=0; $i < 15; $i++) { ?>
                <div class="col-md-2 col-sm-6" style="margin-bottom: 20px;">
                    <div class="list-movie" style="position: relative;">
                        <?php
                        $result[$i] = str_replace($sumber_data.'/anime', $domain.'/episode', $cc[$i]);
                        echo $result[$i];
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <section class="col-md-12">
        <h2 class="judul-kategori">COMPLETE ANIME</h2>
        <div class="row">
            <?php for ($i=15; $i < $total_complete; $i++) { ?>
                <div class="col-md-2 col-sm-6" style="margin-bottom: 20px;">
                    <div class="list-movie" style="position: relative;">
                        <?php
                        $result[$i] = str_replace($sumber_data.'/anime', $domain.'/episode', $cc[$i]);
                        echo $result[$i];
                        ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
