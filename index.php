<?php /* index.php - Landing page with benefits + CTA (JS-only redirects) */ ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Daraz Lite – Shop Smart</title>
<style>
:root{
  --bg:#0f172a;--card:#0b1220;--brand:#ff6a00;--brand2:#ff9a44;--txt:#e5e7eb;--muted:#94a3b8;--ok:#22c55e;
}
*{box-sizing:border-box} body{margin:0;font-family:Inter,system-ui,Segoe UI,Arial;background:linear-gradient(135deg,#0f172a 0%,#111827 100%);color:var(--txt)}
.container{max-width:1100px;margin:0 auto;padding:28px}
.nav{display:flex;align-items:center;justify-content:space-between}
.logo{font-weight:800;letter-spacing:.5px}
.badge{background:linear-gradient(90deg,var(--brand),var(--brand2));padding:6px 12px;border-radius:999px;font-size:12px}
.hero{display:grid;grid-template-columns:1.1fr .9fr;gap:28px;align-items:center;margin-top:24px}
.card{background:linear-gradient(180deg,#0b1220 0%,#0b1020 100%);border:1px solid #1f2937;border-radius:18px;padding:24px;box-shadow:0 8px 30px rgba(0,0,0,.35)}
h1{font-size:40px;margin:0 0 12px}
p.lead{font-size:18px;color:var(--muted);line-height:1.7}
.cta{display:flex;gap:12px;margin-top:18px}
.btn{border:0;border-radius:12px;padding:12px 16px;font-weight:700;cursor:pointer;transition:transform .08s ease,opacity .2s}
.btn:active{transform:scale(.98)}
.btn-primary{background:linear-gradient(90deg,var(--brand),var(--brand2));color:#111827}
.btn-ghost{background:#0b1220;color:#e5e7eb;border:1px solid #1f2937}
.grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:28px}
.tile{padding:18px;border-radius:16px;background:#0a0f1c;border:1px solid #1c2435}
.tile h3{margin:0 0 6px;font-size:18px}
.kpis{display:flex;gap:16px;margin-top:18px}
.kpis .k{flex:1;background:#0a0f1c;border:1px solid #1c2435;border-radius:16px;padding:16px;text-align:center}
.k .big{font-size:28px;font-weight:800;background:linear-gradient(90deg,var(--brand),var(--brand2));-webkit-background-clip:text;color:transparent}
.note{margin-top:22px;color:#9ca3af;font-size:13px}
footer{margin:34px 0 10px;text-align:center;color:#93a3b8;font-size:12px}
.hero-illus{aspect-ratio:1/1.05;background:
 radial-gradient(120px 120px at 80% 20%,rgba(255,154,68,.25),transparent 60%),
 radial-gradient(160px 160px at 20% 80%,rgba(255,106,0,.18),transparent 65%),
 linear-gradient(180deg,#0b1325 0%,#0a0f1c 100%);
border:1px solid #1e293b;border-radius:22px}
.list{margin:0;padding-left:18px;color:#cbd5e1;line-height:1.8}
.list li{margin:6px 0}
</style>
</head><body>
<div class="container">
  <div class="nav">
    <div class="logo">🛍️ <span class="badge">Daraz-style</span> <span style="margin-left:8px">Lite</span></div>
    <div>
      <button class="btn btn-ghost" onclick="go('login.php')">Login</button>
      <button class="btn btn-primary" onclick="go('signup.php')">Create Account</button>
    </div>
  </div>

  <div class="hero">
    <div class="card">
      <h1>Deals you love. <span style="background:linear-gradient(90deg,var(--brand),var(--brand2));-webkit-background-clip:text;color:transparent">Delivered fast.</span></h1>
      <p class="lead">Discover trending products, add to cart in one tap, and checkout with a simple dummy payment. Built with beautiful UI and buttery-smooth front-end.</p>
      <div class="cta">
        <button class="btn btn-primary" onclick="go('home.php')">Browse Products</button>
        <button class="btn btn-ghost" onclick="go('dashboard.php')">Sell on Platform</button>
      </div>

      <div class="kpis">
        <div class="k"><div class="big">10k+</div><div>Daily Deals</div></div>
        <div class="k"><div class="big">4.9★</div><div>Buyer Rating</div></div>
        <div class="k"><div class="big">24/7</div><div>Support</div></div>
      </div>

      <p class="note">Benefits: exclusive vouchers, fast checkout, order tracking, and a seller dashboard to grow your shop.</p>
      <ul class="list">
        <li>🎯 Curated homepage: featured & trending products</li>
        <li>🔐 Secure signup/login (front-end demo)</li>
        <li>🧰 Seller dashboard: add/edit/delete products</li>
        <li>🛒 Cart & Dummy Checkout with order history</li>
        <li>📱 Fully responsive with premium feel CSS</li>
      </ul>
    </div>
    <div class="hero-illus card"></div>
  </div>
  <footer>© 2025 Daraz Lite Demo — Front-end only (LocalStorage) • Built for your brief</footer>
</div>
<script>
function go(p){ window.location.href=p; }
</script>
</body></html>
