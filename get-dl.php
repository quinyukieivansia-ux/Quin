<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$id = intval($_POST['id'] ?? 0);
$i = intval($_POST['i'] ?? 0);
$q = $_POST['q'] ?? '';

if (!$id || !$q) { echo json_encode(['url'=>null]); exit; }

$opts = ['http'=>['method'=>'POST','header'=>'Content-Type: application/x-www-form-urlencoded','content'=>'action=aa1208d27f29ca340c92c66d1926f13f']];
$nonce = json_decode(file_get_contents('https://otakudesu.blog/wp-admin/admin-ajax.php', false, stream_context_create($opts)))->data ?? null;
if (!$nonce) { echo json_encode(['url'=>null,'err'=>'no nonce']); exit; }

$post = http_build_query(['id'=>$id,'i'=>$i,'q'=>$q,'nonce'=>$nonce,'action'=>'2a3505c93b0035d3f455df82bf976b84']);
$opts2 = ['http'=>['method'=>'POST','header'=>'Content-Type: application/x-www-form-urlencoded','content'=>$post]];
$r = file_get_contents('https://otakudesu.blog/wp-admin/admin-ajax.php', false, stream_context_create($opts2));
$html = base64_decode(json_decode($r)->data ?? '');

preg_match('#src="(https://[^"]+)"#', $html, $m);
$url = $m[1] ?? null;

echo json_encode(['url' => $url]);
