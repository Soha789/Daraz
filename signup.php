<?php /* signup.php - LocalStorage signup, then redirect to home.php */ ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Create Account • Daraz Lite</title>
<style>
:root{--bg:#0f172a;--card:#0b1220;--brand:#ff6a00;--brand2:#ff9a44;--txt:#e5e7eb;--muted:#94a3b8}
body{margin:0;font-family:Inter,system-ui;background:radial-gradient(1200px 800px at -20% -20%,rgba(255,106,0,.08),transparent 60%),#0f172a;color:var(--txt)}
.wrap{max-width:420px;margin:40px auto;padding:20px}
.card{background:#0b1220;border:1px solid #1f2937;border-radius:18px;padding:22px;box-shadow:0 8px 30px rgba(0,0,0,.35)}
h1{margin:0 0 8px} p{color:var(--muted)}
label{display:block;margin:12px 0 6px}
input{width:100%;padding:12px;border-radius:12px;border:1px solid #263245;background:#0a0f1c;color:#e5e7eb}
.btn{width:100%;margin-top:14px;padding:12px;border:0;border-radius:12px;font-weight:800;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#0b1220;cursor:pointer}
.link{margin-top:12px;text-align:center;color:#cbd5e1}
a{color:#ffb36a;text-decoration:none}
.top{display:flex;justify-content:space-between;align-items:center;margin-bottom:12px}
.back{background:#0b1220;border:1px solid #223148;border-radius:10px;padding:8px 12px;cursor:pointer}
</style>
</head><body>
<div class="wrap">
  <div class="top">
    <button class="back" onclick="go('index.php')">← Home</button>
    <div>Already have an account? <a href="login.php">Login</a></div>
  </div>
  <div class="card">
    <h1>Create your account</h1>
    <p>Join to track orders, save your cart, and access seller tools.</p>
    <label>Name</label><input id="name" placeholder="Your name">
    <label>Email</label><input id="email" placeholder="you@example.com" type="email">
    <label>Password</label><input id="pass" placeholder="••••••••" type="password">
    <button class="btn" onclick="signup()">Sign up</button>
    <div id="msg" style="margin-top:10px;color:#ffd2a0"></div>
  </div>
</div>
<script>
function go(p){location.href=p}
const get=(k,d)=>JSON.parse(localStorage.getItem(k)||JSON.stringify(d));
const set=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
function uid(){return 'u_'+Math.random().toString(36).slice(2,10)}
function signup(){
  const name=document.getElementById('name').value.trim();
  const email=document.getElementById('email').value.trim().toLowerCase();
  const pass=document.getElementById('pass').value;
  const msg=document.getElementById('msg');
  if(!name||!email||pass.length<4){ msg.textContent="Please fill all fields (password ≥ 4 chars)."; return;}
  const users=get('users',[]);
  if(users.some(u=>u.email===email)){ msg.textContent="Email already registered. Try login."; return;}
  const user={id:uid(),name,email,password:pass,createdAt:Date.now()};
  users.push(user); set('users',users); set('session',{userId:user.id});
  msg.textContent="Account created! Redirecting…"; setTimeout(()=>go('home.php'),600);
}
</script>
</body></html>
