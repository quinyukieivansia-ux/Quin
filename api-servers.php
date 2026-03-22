<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$slug = $_GET['slug'] ?? '';
if (!$slug) { echo json_encode(['servers' => []]); exit; }

$html = file_get_contents("https://otakudesu.blog/episode/$slug/");
if (!$html) { echo json_encode(['servers' => []]); exit; }

// Get nonce
$opts = ['http'=>['method'=>'POST','header'=>'Content-Type: application/x-www-form-urlencoded','content'=>'action=aa1208d27f29ca340c92c66d1926f13f']];
$r = file_get_contents('https://otakudesu.blog/wp-admin/admin-ajax.php', false, stream_context_create($opts));
$nonce = json_decode($r)->data ?? null;
if (!$nonce) { echo json_encode(['servers' => []]); exit; }

// Ambil semua data-content
preg_match_all('#data-content="([^"]+)"[^>]*>([^<]+)<#', $html, $m);

$servers = [];
foreach ($m[1] as $i => $b64) {
    $data = json_decode(base64_decode($b64), true);
    if (!$data) continue;
    
    $label = trim($m[2][$i]) . ' (' . ($data['q'] ?? '') . ')';
    
    // Fetch embed URL
    $post = http_build_query([...$data, 'nonce'=>$nonce, 'action'=>'2a3505c93b0035d3f455df82bf976b84']);
    $opts2 = ['http'=>['method'=>'POST','header'=>'Content-Type: application/x-www-form-urlencoded','content'=>$post]];
    $r2 = file_get_contents('https://otakudesu.blog/wp-admin/admin-ajax.php', false, stream_context_create($opts2));
    $embed_html = base64_decode(json_decode($r2)->data ?? '');
    
    preg_match('#src="([^"]+)"#', $embed_html, $src);
    if ($src[1]) {
        $servers[] = ['label' => $label, 'url' => $src[1]];
    }
}

echo json_encode(['servers' => $servers]);
