<?php
$slug = $_GET['slug'] ?? '';
if (!$slug) die('Slug tidak valid');

$html = file_get_contents("https://otakudesu.blog/episode/$slug/");
if (!$html) die('Gagal');

preg_match('#<title>(.*?)</title>#', $html, $t);
$title = str_replace(' | Otaku Desu', '', $t[1] ?? '');

// Ambil semua data-content
preg_match_all('#data-content="([^"]+)"[^>]*>([^<]+)<#', $html, $m);

$servers = [];
foreach ($m[1] as $i => $b64) {
    $data = json_decode(base64_decode($b64), true);
    if (!$data) continue;
    $servers[] = ['label' => trim($m[2][$i]), 'q' => $data['q'], 'data' => $data];
}

// Ambil action dari JS
preg_match('#action:"([a-f0-9]{32})"}\)\.done.*?action:"([a-f0-9]{32})"#s', $html, $actions);
$nonce_action = $actions[1] ?? 'aa1208d27f29ca340c92c66d1926f13f';
$embed_action = $actions[2] ?? '2a3505c93b0035d3f455df82bf976b84';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Download <?= htmlspecialchars($title) ?></title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { background: #0f0f0f; color: #fff; font-family: sans-serif; padding: 16px; }
h2 { font-size: 14px; color: #aaa; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid #333; }
.res-group { margin-bottom: 14px; }
.res-title { color: #e63946; font-weight: bold; margin-bottom: 8px; font-size: 13px; }
.btn-grid { display: flex; flex-wrap: wrap; gap: 8px; }
.dl-btn { background: #2a2a2a; color: #fff; padding: 8px 14px; border-radius: 6px; font-size: 12px; border: 1px solid #444; cursor: pointer; }
.dl-btn:hover, .dl-btn.loading { background: #e63946; }
#modal { display:none; position:fixed; inset:0; background:rgba(0,0,0,0.8); z-index:99; align-items:center; justify-content:center; }
#modal.show { display:flex; }
#modal-inner { background:#1a1a1a; padding:20px; border-radius:10px; text-align:center; max-width:300px; }
#modal-inner a { display:block; background:#e63946; color:#fff; padding:10px; border-radius:6px; text-decoration:none; margin-top:10px; }
</style>
</head>
<body>
<h2>⬇ <?= htmlspecialchars($title) ?></h2>

<?php
$grouped = [];
foreach ($servers as $s) {
    $grouped[$s['q']][] = $s;
}
foreach ($grouped as $res => $items): ?>
<div class="res-group">
    <div class="res-title"><?= htmlspecialchars($res) ?></div>
    <div class="btn-grid">
        <?php foreach ($items as $item): ?>
        <button class="dl-btn" onclick="getLink(this, <?= htmlspecialchars(json_encode($item['data'])) ?>)">
            <?= htmlspecialchars($item['label']) ?>
        </button>
        <?php endforeach; ?>
    </div>
</div>
<?php endforeach; ?>

<div id="modal">
    <div id="modal-inner">
        <p id="modal-text">Memuat link...</p>
        <a id="modal-link" href="#" target="_blank" style="display:none">Buka Link Download</a>
        <button onclick="document.getElementById('modal').classList.remove('show')" style="margin-top:10px;background:#333;color:#fff;border:none;padding:8px 16px;border-radius:6px;cursor:pointer">Tutup</button>
    </div>
</div>

<script>
const NONCE_ACTION = '<?= $nonce_action ?>';
const EMBED_ACTION = '<?= $embed_action ?>';
let nonce = null;

async function getNonce() {
    if (nonce) return nonce;
    const r = await fetch('/get-dl.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'action=' + NONCE_ACTION
    });
    const d = await r.json();
    nonce = d.data;
    return nonce;
}

async function getLink(btn, data) {
    document.getElementById('modal').classList.add('show');
    document.getElementById('modal-text').textContent = 'Memuat link...';
    document.getElementById('modal-link').style.display = 'none';
    
    const n = await getNonce();
    const params = new URLSearchParams({...data, nonce: n, action: EMBED_ACTION});
    const r = await fetch('/get-dl.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id='+data.id+'&i='+data.i+'&q='+data.q
    });
    const d = await r.json();
    const url = d.url;
    
    
    
    if (url) {
        document.getElementById('modal-text').textContent = 'Link siap!';
        const link = document.getElementById('modal-link');
        link.href = url;
        link.style.display = 'block';
    } else {
        document.getElementById('modal-text').textContent = 'Gagal mendapatkan link';
    }
}
</script>
</body>
</html>
