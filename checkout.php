<?php /* checkout.php - Dummy payment, place order, redirect to thankyou.php */ ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Checkout • Daraz Lite</title>
<style>
:root{--bg:#0f172a;--card:#0b1220;--brand:#ff6a00;--brand2:#ff9a44;--txt:#e5e7eb;--line:#1f2a3a}
body{margin:0;font-family:Inter,system-ui;background:#0f172a;color:var(--txt)}
.nav{display:flex;justify-content:space-between;align-items:center;padding:16px 22px;border-bottom:1px solid var(--line)}
.btn{border:1px solid #223148;background:#0b1220;color:#e5e7eb;border-radius:10px;padding:10px 14px;cursor:pointer}
.btn.primary{border:0;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#111827;font-weight:800}
.wrap{max-width:820px;margin:0 auto;padding:18px}
.grid{display:grid;grid-template-columns:1.1fr .9fr;gap:16px}
.card{background:#0b1220;border:1px solid #1e293b;border-radius:16px;padding:16px}
label{display:block;margin:10px 0 6px}
input{width:100%;padding:10px;border-radius:10px;border:1px solid #223148;background:#0a0f1c;color:#e5e7eb}
.sum{font-size:14px;color:#cbd5e1}
</style>
</head><body>
<div class="nav">
  <div>💳 Checkout</div>
  <div><button class="btn" onclick="go('cart.php')">Back to Cart</button></div>
</div>
<div class="wrap">
  <div class="grid">
    <div class="card">
      <h3>Shipping</h3>
      <label>Full Name</label><input id="name">
      <label>Address</label><input id="addr">
      <label>City</label><input id="city">
      <label>Phone</label><input id="phone">
    </div>
    <div class="card">
      <h3>Payment (Dummy)</h3>
      <label>Card Number</label><input placeholder="4111 1111 1111 1111">
      <label>Expiry</label><input placeholder="12/29">
      <label>CVC</label><input placeholder="123">
      <div class="sum" id="summary" style="margin-top:12px"></div>
      <button class="btn primary" style="width:100%;margin-top:12px" onclick="pay()">Pay & Place Order</button>
      <div id="msg" style="margin-top:8px;color:#ffd2a0"></div>
    </div>
  </div>
</div>
<script>
function go(p){location.href=p}
const get=(k,d)=>JSON.parse(localStorage.getItem(k)||JSON.stringify(d));
const set=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
function sessionUser(){const s=get('session',null); if(!s){go('login.php');return null} return s;}
const s=sessionUser(); const key='cart_'+s.userId;

function calc(){
  const cart=get(key,[]); const prods=get('products',[]);
  let total=0; const items=cart.map(it=>{ const p=prods.find(x=>x.id===it.productId); const line=p?p.price*it.qty:0; total+=line; return {...it,title:p?p.title:'Deleted',price:p?p.price:0}; });
  return {total,items};
}
function render(){ const {total,items}=calc(); document.getElementById('summary').textContent=`${items.length} items • Total $${total.toFixed(2)} (incl. dummy tax)`; }
function oid(){return 'ORD-'+Math.random().toString(36).slice(2,8).toUpperCase()}
function pay(){
  const {total,items}=calc(); if(items.length===0) return go('cart.php');
  const name=document.getElementById('name').value.trim(); const addr=document.getElementById('addr').value.trim();
  const city=document.getElementById('city').value.trim(); const phone=document.getElementById('phone').value.trim();
  if(!name||!addr||!city||!phone){ document.getElementById('msg').textContent='Please complete shipping info.'; return; }
  const order={id:oid(),userId:s.userId,items, total, status:'Pending', createdAt:Date.now()};
  const orders=get('orders',[]); orders.push(order); set('orders',orders);
  set(key,[]); // clear cart
  // simple status progression simulation
  setTimeout(()=>{ advance(order.id,'Shipped'); },300);
  setTimeout(()=>{ advance(order.id,'Delivered'); },1200);
  go('thankyou.php?order='+order.id);
}
function advance(id,status){
  const orders=get('orders',[]); const o=orders.find(x=>x.id===id); if(o){o.status=status; set('orders',orders);}
}
render();
</script>
</body></html>
