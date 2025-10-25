<?php /* thankyou.php - Simple confirmation page */ ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Thank You • Daraz Lite</title>
<style>
:root{--bg:#0f172a;--card:#0b1220;--brand:#22c55e;--txt:#e5e7eb}
body{margin:0;font-family:Inter,system-ui;background:radial-gradient(900px 600px at 20% 0%,rgba(34,197,94,.12),transparent 60%),#0f172a;color:var(--txt)}
.wrap{max-width:600px;margin:60px auto;padding:24px}
.card{background:#0b1220;border:1px solid #1f2937;border-radius:18px;padding:24px;text-align:center}
h1{margin:0 0 8px}
.badge{display:inline-block;margin-top:8px;background:#092213;border:1px solid #134e31;color:#b7ffd4;padding:6px 10px;border-radius:999px}
.btn{margin-top:16px;border:0;border-radius:12px;padding:12px 16px;background:linear-gradient(90deg,#ff6a00,#ff9a44);color:#0b1220;font-weight:800;cursor:pointer}
</style>
</head><body>
<div class="wrap">
  <div class="card">
    <h1>✅ Order Placed!</h1>
    <p>Thanks for your purchase. Your order is being processed.</p>
    <div id="oid" class="badge"></div>
    <div style="margin-top:10px;color:#9bb0c7">Track it anytime from <b>Home → My Orders</b>.</div>
    <button class="btn" onclick="go('home.php')">Back to Home</button>
  </div>
</div>
<script>
function go(p){location.href=p}
const q=new URLSearchParams(location.search); const id=q.get('order')||'—';
document.getElementById('oid').textContent='Order ID: '+id;
</script>
</body></html>
