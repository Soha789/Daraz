<?php /* home.php - Browse products, search/filters, add to cart, view orders */ ?>
<!DOCTYPE html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Home • Daraz Lite</title>
<style>
:root{--bg:#0f172a;--card:#0b1220;--brand:#ff6a00;--brand2:#ff9a44;--txt:#e5e7eb;--muted:#94a3b8;--line:#1f2a3a}
*{box-sizing:border-box} body{margin:0;font-family:Inter,system-ui;background:#0f172a;color:var(--txt)}
.nav{display:flex;gap:12px;align-items:center;justify-content:space-between;padding:16px 22px;border-bottom:1px solid var(--line);position:sticky;top:0;background:rgba(15,23,42,.8);backdrop-filter:blur(6px)}
.brand{font-weight:900}
.nav .actions button{margin-left:8px}
.btn{border:1px solid #223148;background:#0b1220;color:#e5e7eb;border-radius:10px;padding:8px 12px;cursor:pointer}
.btn.primary{border:0;background:linear-gradient(90deg,var(--brand),var(--brand2));color:#111827;font-weight:800}
.wrap{max-width:1200px;margin:0 auto;padding:18px}
.controls{display:grid;grid-template-columns:1.2fr 1fr 1fr .8fr .8fr;gap:10px}
input,select{width:100%;padding:10px;border-radius:10px;border:1px solid #223148;background:#0a0f1c;color:#e5e7eb}
.grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(230px,1fr));gap:16px;margin-top:16px}
.card{background:#0b1220;border:1px solid #1e293b;border-radius:16px;overflow:hidden;display:flex;flex-direction:column}
.thumb{height:150px;background:radial-gradient(140px 90px at 70% 20%,rgba(255,154,68,.25),transparent 55%),#0a0f1c;border-bottom:1px solid #1e293b}
.content{padding:12px;display:flex;flex-direction:column;gap:6px}
.price{font-weight:900;background:linear-gradient(90deg,var(--brand),var(--brand2));-webkit-background-clip:text;color:transparent}
.badge{font-size:12px;color:#cbd5e1}
footer{margin:18px 0 30px;text-align:center;color:#8ea0b7}
.order-box{margin-top:16px;background:#0b1220;border:1px solid #203048;border-radius:16px;padding:12px}
@media(max-width:840px){.controls{grid-template-columns:1fr 1fr 1fr;}}
</style>
</head><body>
<div class="nav">
  <div class="brand">🛒 Daraz Lite</div>
  <div class="actions">
    <button class="btn" onclick="go('dashboard.php')">Dashboard</button>
    <button class="btn" onclick="go('cart.php')">Cart (<span id="cartCount">0</span>)</button>
    <button class="btn" onclick="ordersToggle()">My Orders</button>
    <button class="btn primary" onclick="logout()">Logout</button>
  </div>
</div>

<div class="wrap">
  <div class="controls">
    <input id="q" placeholder="Search products by name…">
    <select id="cat"><option value="">All Categories</option></select>
    <select id="brand"><option value="">All Brands</option></select>
    <input id="maxPrice" type="number" placeholder="Max price">
    <select id="rating">
      <option value="">Any rating</option>
      <option>4+</option><option>3+</option><option>2+</option>
    </select>
  </div>
  <div style="margin-top:10px;display:flex;gap:10px">
    <button class="btn" onclick="applyFilters()">Apply Filters</button>
    <button class="btn" onclick="resetFilters()">Reset</button>
  </div>

  <div id="grid" class="grid"></div>

  <div id="orders" class="order-box" style="display:none">
    <h3>My Orders</h3>
    <div id="orderList" style="font-size:14px;color:#cbd5e1"></div>
  </div>

  <footer>Products persist via LocalStorage. Add items in Dashboard; they appear here instantly.</footer>
</div>

<script>
function go(p){location.href=p;}
const get=(k,d)=>JSON.parse(localStorage.getItem(k)||JSON.stringify(d));
const set=(k,v)=>localStorage.setItem(k,JSON.stringify(v));
function sessionUser(){const s=get('session',null); if(!s){go('login.php');return null} const u=get('users',[]).find(x=>x.id===s.userId); if(!u){go('login.php');return null} return u;}
const user=sessionUser();

// seed demo products once
(function seed(){
  if(get('seededHome',false)) return;
  const demo=[
    {id:'p1',title:'Wireless Earbuds Pro',price:149,category:'Electronics',brand:'Soundly',rating:4.6,desc:'ANC, 30h battery',img:'',stock:24},
    {id:'p2',title:'Non-Stick Frying Pan 28cm',price:39,category:'Home & Kitchen',brand:'Chefio',rating:4.3,desc:'Even heat, easy clean',img:'',stock:50},
    {id:'p3',title:'Men’s Running Shoes',price:79,category:'Fashion',brand:'FlyStep',rating:4.5,desc:'Breathable mesh',img:'',stock:35},
    {id:'p4',title:'Smartwatch S4',price:199,category:'Electronics',brand:'Pulse',rating:4.2,desc:'Heart rate, GPS',img:'',stock:12},
  ];
  if(get('products',[]).length===0){ set('products',demo); }
  set('seededHome',true);
})();

function cartCount(){
  const s=get('session',null); if(!s) return 0;
  const key='cart_'+s.userId; return get(key,[]).reduce((a,i)=>a+i.qty,0);
}
function refreshCartCount(){ document.getElementById('cartCount').textContent=cartCount(); }

// build filter dropdowns
function buildFilters(){
  const prods=get('products',[]);
  const cats=[...new Set(prods.map(p=>p.category))].sort();
  const brands=[...new Set(prods.map(p=>p.brand))].sort();
  const cSel=document.getElementById('cat'); cSel.innerHTML='<option value="">All Categories</option>'+cats.map(c=>`<option>${c}</option>`).join('');
  const bSel=document.getElementById('brand'); bSel.innerHTML='<option value="">All Brands</option>'+brands.map(b=>`<option>${b}</option>`).join('');
}

function render(){
  const grid=document.getElementById('grid'); const prods=get('products',[]);
  const q=document.getElementById('q').value.toLowerCase();
  const cat=document.getElementById('cat').value; const brand=document.getElementById('brand').value;
  const rating=document.getElementById('rating').value; const maxP=parseFloat(document.getElementById('maxPrice').value||'Infinity');
  const list=prods.filter(p=>
    (!q||p.title.toLowerCase().includes(q)) &&
    (!cat||p.category===cat) &&
    (!brand||p.brand===brand) &&
    (!rating||p.rating>=parseInt(rating)) &&
    (p.price<=maxP)
  );
  grid.innerHTML=list.map(p=>cardHTML(p)).join('') || `<div class="card" style="padding:20px">No products match your filters.</div>`;
}

function cardHTML(p){
  return `
  <div class="card">
    <div class="thumb" role="img" aria-label="${p.title}"></div>
    <div class="content">
      <div class="badge">${p.category} • ★${p.rating}</div>
      <strong>${p.title}</strong>
      <div class="price">$${p.price}</div>
      <small style="color:#9fb3cc">${p.desc}</small>
      <div style="margin-top:8px;display:flex;gap:8px">
        <button class="btn" onclick="view('${p.id}')">View</button>
        <button class="btn primary" onclick="add('${p.id}')">Add to Cart</button>
      </div>
    </div>
  </div>`;
}

function view(id){
  const p=get('products',[]).find(x=>x.id===id);
  if(!p) return;
  alert(`${p.title}\n\n${p.desc}\n\nPrice: $${p.price}\nRating: ${p.rating}★`);
}
function add(id){
  const s=get('session',null); if(!s) return go('login.php');
  const key='cart_'+s.userId; const cart=get(key,[]);
  const row=cart.find(i=>i.productId===id); if(row) row.qty++; else cart.push({productId:id,qty:1});
  set(key,cart); refreshCartCount();
}

function resetFilters(){ document.getElementById('q').value=''; document.getElementById('cat').value=''; document.getElementById('brand').value=''; document.getElementById('maxPrice').value=''; document.getElementById('rating').value=''; render();}
function applyFilters(){ render(); }
function logout(){ localStorage.removeItem('session'); go('login.php'); }

function ordersToggle(){
  const box=document.getElementById('orders'); box.style.display=box.style.display==='none'?'block':'none';
  if(box.style.display==='block') renderOrders();
}
function renderOrders(){
  const s=get('session',null); const orders=get('orders',[]).filter(o=>o.userId===s.userId).sort((a,b)=>b.createdAt-a.createdAt);
  const el=document.getElementById('orderList');
  if(orders.length===0){ el.innerHTML='No orders yet. Checkout to create your first order.'; return;}
  el.innerHTML=orders.map(o=>`<div style="padding:8px 0;border-bottom:1px dashed #23314a">
    <strong>#${o.id}</strong> • ${new Date(o.createdAt).toLocaleString()} • <span style="color:#a8ffcb">${o.status}</span> • Total: $${o.total.toFixed(2)}
    <div style="opacity:.85">Items: ${o.items.map(i=>i.title+' ×'+i.qty).join(', ')}</div>
  </div>`).join('');
}

buildFilters(); render(); refreshCartCount();
</script>
</body></html>
