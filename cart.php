<?php /* cart.php - View/edit cart, proceed to checkout */ ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Your Cart • Daraz Lite</title>
<style>
:root{--bg:#0f172a;--card:#0b1220;--brand:#ff6a00;--brand2:#ff9a44;--txt:#e5e7eb;--line:#1f2a3a}
body{margin:0;font-family:Inter,system-ui;background:#0f172a;color:var(--txt)}
.nav{display:flex;justify-content:space-between;align-items:center;padding:16px 22px;border-bottom:1px solid var(--line)}
.btn{border:1px solid #223148;background:#0b1220;color:#e5e7eb;border-radius:10px;padding:8px 12px;cursor:pointer}
.btn.primary{border:0;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#111827;font-weight:800}
.wrap{max-width:900px;margin:0 auto;padding:18px}
.card{background:#0b1220;border:1px solid #1e293b;border-radius:16px;padding:16px}
.row{display:grid;grid-template-columns:1fr .3fr .3fr .3fr;gap:10px;padding:10px 0;border-bottom:1px dashed #223148;align-items:center}
.row.head{font-weight:800}
.total{display:flex;justify-content:space-between;align-items:center;margin-top:12px}
</style>
</head><body>
<div class="nav">
  <div>🧺 Your Cart</div>
  <div>
    <button class="btn" onclick="go('home.php')">Continue Shopping</button>
    <button class="btn primary" onclick="checkout()">Proceed to Checkout</button>
  </div>
</div>
<div class="wrap">
  <div class="card">
    <div class="row head"><div>Item</div><div>Qty</div><div>Price</div><div>Action</div></div>
    <div id="rows"></div>
    <div class="total">
      <div>Items: <span id="count">0</span></div>
      <div style="font-weight:900">Total: $<span id="total">0</span></div>
    </div>
  </div>
</div>
<script>
function go(p){location.href=p}
const get=(k,d)=>JSON.parse(localStorage.getItem(k)||JSON.stringify(d));
const set=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
function sessionUser(){const s=get('session',null); if(!s){go('login.php');return null} const u=get('users',[]).find(x=>x.id===s.userId); if(!u){go('login.php');return null} return s;}
const s=sessionUser(); const key='cart_'+s.userId;

function render(){
  const rows=document.getElementById('rows'); const cart=get(key,[]); const prods=get('products',[]);
  let total=0,count=0;
  rows.innerHTML=cart.map(it=>{
    const p=prods.find(x=>x.id===it.productId); if(!p) return '';
    const line=p.price*it.qty; total+=line; count+=it.qty;
    return `<div class="row">
      <div>${p.title}</div>
      <div><button class="btn" onclick="qty('${p.id}',-1)">−</button> ${it.qty} <button class="btn" onclick="qty('${p.id}',1)">+</button></div>
      <div>$${line.toFixed(2)}</div>
      <div><button class="btn" onclick="rem('${p.id}')">Remove</button></div>
    </div>`;
  }).join('') || `<div style="padding:12px">Your cart is empty.</div>`;
  document.getElementById('total').textContent=total.toFixed(2);
  document.getElementById('count').textContent=count;
}
function qty(id,delta){
  const cart=get(key,[]); const row=cart.find(i=>i.productId===id); if(!row) return;
  row.qty+=delta; if(row.qty<=0) cart.splice(cart.findIndex(i=>i.productId===id),1);
  set(key,cart); render();
}
function rem(id){
  const cart=get(key,[]).filter(i=>i.productId!==id); set(key,cart); render();
}
function checkout(){
  if(get(key,[]).length===0) return alert('Cart is empty.');
  go('checkout.php');
}
render();
</script>
</body></html>
