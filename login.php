<?php /* login.php - LocalStorage login, then redirect to home.php */ ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Login • Daraz Lite</title>
<style>
:root{--bg:#0f172a;--card:#0b1220;--brand:#ff6a00;--brand2:#ff9a44;--txt:#e5e7eb;--muted:#94a3b8}
body{margin:0;font-family:Inter,system-ui;background:linear-gradient(135deg,#0f172a 0%,#0e1323 100%);color:var(--txt)}
.wrap{max-width:420px;margin:40px auto;padding:20px}
.card{background:#0b1220;border:1px solid #1f2937;border-radius:18px;padding:22px}
h1{margin:0 0 8px} p{color:var(--muted)}
label{display:block;margin:12px 0 6px}
input{width:100%;padding:12px;border-radius:12px;border:1px solid #263245;background:#0a0f1c;color:#e5e7eb}
.btn{width:100%;margin-top:14px;padding:12px;border:0;border-radius:12px;font-weight:800;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#0b1220;cursor:pointer}
.top{display:flex;justify-content:space-between;margin-bottom:12px}
.link{margin-top:12px;text-align:center}
a{color:#ffb36a;text-decoration:none}
</style>
</head><body>
<div class="wrap">
  <div class="top">
    <button onclick="go('index.php')" style="background:#0b1220;border:1px solid #223148;border-radius:10px;padding:8px 12px;cursor:pointer">← Home</button>
    <div>New here? <a href="signup.php">Create account</a></div>
  </div>
  <div class="card">
    <h1>Welcome back</h1>
    <p>Login to continue shopping.</p>
    <label>Email</label><input id="email" type="email" placeholder="you@example.com">
    <label>Password</label><input id="pass" type="password" placeholder="••••••••">
    <button class="btn" onclick="login()">Login</button>
    <div id="msg" style="margin-top:10px;color:#ffd2a0"></div>
  </div>
</div>
<script>
function go(p){location.href=p}
const get=(k,d)=>JSON.parse(localStorage.getItem(k)||JSON.stringify(d));
const set=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
function login(){
  const email=document.getElementById('email').value.trim().toLowerCase();
  const pass=document.getElementById('pass').value;
  const users=get('users',[]);
  const u=users.find(x=>x.email===email && x.password===pass);
  const msg=document.getElementById('msg');
  if(!u){ msg.textContent="Invalid credentials."; return;}
  set('session',{userId:u.id}); msg.textContent="Logged in! Redirecting…"; setTimeout(()=>go('home.php'),600);
}
</script>
</body></html>
