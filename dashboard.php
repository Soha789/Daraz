<?php /* dashboard.php - Seller product management (LocalStorage) */ ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Dashboard • Daraz Lite</title>
<style>
:root{--bg:#0f172a;--card:#0b1220;--brand:#ff6a00;--brand2:#ff9a44;--txt:#e5e7eb;--line:#1f2a3a}
body{margin:0;font-family:Inter,system-ui;background:#0f172a;color:var(--txt)}
.nav{display:flex;justify-content:space-between;align-items:center;padding:16px 22px;border-bottom:1px solid var(--line)}
.btn{border:1px solid #223148;background:#0b1220;color:#e5e7eb;border-radius:10px;padding:8px 12px;cursor:pointer}
.btn.primary{border:0;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#111827;font-weight:800}
.wrap{max-width:1100px;margin:0 auto;padding:18px}
.grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.card{background:#0b1220;border:1px solid #1e293b;border-radius:16px;padding:16px}
label{display:block;margin:10px 0 6px}
input,select,textarea{width:100%;padding:10px;border-radius:10px;border:1px solid #223148;background:#0a0f1c;color:#e5e7eb}
.table{margin-top:10px;border:1px solid #1e293b;border-radius:14px;overflow:hidden}
.row{display:grid;grid-template-columns:1.6fr .7fr .9fr .7fr .8fr .8fr;gap:10px;padding:10px;border-bottom:1px dashed #223148;align-items:center}
.row.head{background:#0a0f1c;font-weight:800}
.actions button{margin-right:8px}
@media(max-width:980px){.grid{grid-template-columns:1fr}.row{grid-template-columns:1.6fr .7fr .9fr .7fr .8fr}}
</style>
</head><body>
<div class="nav">
  <div>📦 Seller Dashboard</div>
  <div>
    <button class="btn" onclick="go('home.php')">Home</button>
    <button class="btn" onclick="go('cart.php')">Cart</button>
    <button class="btn primary" onclick="logout()">Logout</button>
  </div>
</div>
<div class="wrap">
  <div class="grid">
    <div class="card">
      <h3>Add / Edit Product</h3>
      <input id="pid" type="hidden">
      <label>Title</label><input id="title">
      <label>Price ($)</label><input id="price" type="number">
      <label>Category</label><input id="category" placeholder="Electronics, Fashion, Home & Kitchen…">
      <label>Brand</label><input id="brand" placeholder="Brand name">
      <label>Rating (0–5)</label><input id="rating" type="number" step="0.1" value="4.5">
      <label>Stock</label><input id="stock" type="number" value="10">
      <label>Description</label><textarea id="desc" rows="3"></textarea>
      <div style="display:flex;gap:8px;margin-top:12px">
        <button class="btn primary" onclick="saveProd()">Save</button>
        <button class="btn" onclick="clearForm()">Clear</button>
      </div>
      <div id="msg" style="margin-top:8px;color:#ffd2a0"></div>
    </div>
    <div class="card">
      <h3>Tips</h3>
      <ul style="line-height:1.9;color:#cbd5e1">
        <li>Add great titles (brand + key feature)</li>
        <li>Keep price realistic; rating ≤ 5.0</li>
        <li>Edits update instantly on <b>Home</b></li>
      </ul>
    </div>
  </div>

  <div class="table">
    <div class="row head"><div>Title</div><div>Price</div><div>Category</div><div>Brand</div><div>Rating</div><div>Actions</div></div>
    <div id="rows"></div>
  </div>
</div>

<script>
function go(p){location.href=p}
const get=(k,d)=>JSON.parse(localStorage.getItem(k)||JSON.stringify(d));
const set=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
function sessionUser(){const s=get('session',null);if(!s){go('login.php');return null} const u=get('users',[]).find(x=>x.id===s.userId);if(!u){go('login.php');return null} return u;}
sessionUser();

function uid(){return 'p_'+Math.random().toString(36).slice(2,9)}
function saveProd(){
  const id=document.getElementById('pid').value || uid();
  const p={
    id,
    title:val('title'), price:parseFloat(val('price')||'0'),
    category:val('category'), brand:val('brand'),
    rating:parseFloat(val('rating')||'0'), stock:parseInt(val('stock')||'0'),
    img:'', desc:val('desc')
  };
  if(!p.title||!p.category){return msg('Title & Category required');}
  const list=get('products',[]);
  const i=list.findIndex(x=>x.id===id);
  if(i>-1) list[i]=p; else list.push(p);
  set('products',list); msg('Saved!'); render(); clearForm();
}
function val(id){return document.getElementById(id).value.trim()}
function clearForm(){['pid','title','price','category','brand','rating','stock','desc'].forEach(i=>{document.getElementById(i).value='';});document.getElementById('rating').value='4.5';document.getElementById('stock').value='10'}
function msg(t){document.getElementById('msg').textContent=t; setTimeout(()=>msg(''),1200);}

function render(){
  const rows=document.getElementById('rows');
  const list=get('products',[]);
  rows.innerHTML=list.map(p=>`
    <div class="row">
      <div>${p.title}</div><div>$${p.price}</div><div>${p.category}</div><div>${p.brand}</div><div>★${p.rating}</div>
      <div class="actions">
        <button class="btn" onclick="edit('${p.id}')">Edit</button>
        <button class="btn" onclick="delProd('${p.id}')">Delete</button>
      </div>
    </div>`).join('') || `<div style="padding:14px">No products yet. Add your first one.</div>`;
}
function edit(id){
  const p=get('products',[]).find(x=>x.id===id); if(!p) return;
  ['pid','title','price','category','brand','rating','stock','desc'].forEach(k=>document.getElementById(k).value=p[k]??'');
}
function delProd(id){
  if(!confirm('Delete this product?')) return;
  const list=get('products',[]).filter(x=>x.id!==id); set('products',list); render();
}
function logout(){ localStorage.removeItem('session'); go('login.php'); }
render();
</script>
</body></html>
