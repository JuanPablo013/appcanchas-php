let step=1;const initialStep=1,finalStep=3,game={id:"",nombre:"",fecha:"",hora:"",servicios:[]};function startApp(){showSection(),tabs(),pagerButtons(),nextPage(),previousPage(),consultAPI(),clientId(),clientName(),selectDate(),selectTime(),showSummary()}function showSection(){const e=document.querySelector(".show");e&&e.classList.remove("show");const t=`#step-${step}`;document.querySelector(t).classList.add("show");const n=document.querySelector(".current");n&&n.classList.remove("current");document.querySelector(`[data-step="${step}"]`).classList.add("current")}function tabs(){document.querySelectorAll(".tabs button").forEach((e=>{e.addEventListener("click",(function(e){step=parseInt(e.target.dataset.step),showSection(),pagerButtons()}))}))}function pagerButtons(){const e=document.querySelector("#previous"),t=document.querySelector("#next");1===step?(e.classList.add("hide"),t.classList.remove("hide")):3===step?(e.classList.remove("hide"),t.classList.add("hide"),showSummary()):(e.classList.remove("hide"),t.classList.remove("hide")),showSection()}function previousPage(){document.querySelector("#previous").addEventListener("click",(function(){step<=initialStep||(step--,pagerButtons())}))}function nextPage(){document.querySelector("#next").addEventListener("click",(function(){step>=finalStep||(step++,pagerButtons())}))}async function consultAPI(){try{const e="/api/services",t=await fetch(e);showServices(await t.json())}catch(e){console.log(e)}}function showServices(e){e.forEach((e=>{const{id:t,nombre:n,precio:o}=e,c=document.createElement("P");c.classList.add("service-name"),c.textContent=n;const a=document.createElement("P");a.classList.add("price-service"),a.textContent=`$${o}`;const s=document.createElement("DIV");s.classList.add("service"),s.dataset.idService=t,s.onclick=function(){selectService(e)},s.appendChild(c),s.appendChild(a),document.querySelector("#services").appendChild(s)}))}function selectService(e){const{id:t}=e,{servicios:n}=game,o=document.querySelector(`[data-id-service="${t}"]`);n.some((e=>e.id===t))?(game.servicios=n.filter((e=>e.id!==t)),o.classList.remove("selected")):(game.servicios=[...n,e],o.classList.add("selected"))}function clientId(){game.id=document.querySelector("#id").value}function clientName(){game.nombre=document.querySelector("#name").value}function selectDate(){document.querySelector("#date").addEventListener("input",(function(e){const t=new Date(e.target.value).getUTCDay();[1].includes(t)?(e.target.value="",showAlert("No hay servicio los lunes","error",".form")):game.fecha=e.target.value}))}function selectTime(){document.querySelector("#hour").addEventListener("input",(function(e){const t=e.target.value.split(":")[0];t<9||t>=22?(e.target.value="",showAlert("Hora no válida","error",".form")):game.hora=e.target.value}))}function showAlert(e,t,n,o=!0){const c=document.querySelector(".alert");c&&c.remove();const a=document.createElement("DIV");a.textContent=e,a.classList.add("alert"),a.classList.add(t);document.querySelector(n).appendChild(a),o&&setTimeout((()=>{a.remove()}),3e3)}function showSummary(){const e=document.querySelector(".summary-content");for(;e.firstChild;)e.removeChild(e.firstChild);if(Object.values(game).includes("")||0===game.servicios.length)return void showAlert("Faltan datos: fecha, hora o servicios","error",".summary-content",!1);const{nombre:t,fecha:n,hora:o,servicios:c}=game,a=document.createElement("H3");a.textContent="Resumen de Servicios",e.appendChild(a),c.forEach((t=>{const{id:n,precio:o,nombre:c}=t,a=document.createElement("DIV");a.classList.add("service-container");const s=document.createElement("P");s.textContent=c;const r=document.createElement("P");r.innerHTML=`<span>Precio:</span> $${o}`,a.appendChild(s),a.appendChild(r),e.appendChild(a)}));const s=document.createElement("H3");s.textContent="Resumen del partido",e.appendChild(s);const r=document.createElement("P");r.innerHTML=`<span>Nombre:</span> ${t}`;const i=new Date(n),d=i.getMonth(),l=i.getDate(),u=i.getFullYear(),m=new Date(Date.UTC(u,d,l)).toLocaleDateString("es-CO",{weekday:"long",year:"numeric",month:"long",day:"numeric"}),p=document.createElement("P");p.innerHTML=`<span>Fecha:</span> ${m}`;const h=document.createElement("P");h.innerHTML=`<span>Hora:</span> ${o} Horas`;const v=document.createElement("BUTTON");v.classList.add("button"),v.textContent="Reservar Partido",v.onclick=reserveGame,e.appendChild(r),e.appendChild(p),e.appendChild(h),e.appendChild(v)}async function reserveGame(){const{id:e,nombre:t,fecha:n,hora:o,servicios:c}=game,a=c.map((e=>e.id)),s=new FormData;s.append("usuarioId",e),s.append("hora",o),s.append("fecha",n),s.append("servicios",a);try{const e="/api/games",t=await fetch(e,{method:"POST",body:s}),n=await t.json();console.log(n.resultado),n.resultado&&Swal.fire({icon:"success",title:"Reservación creada",text:"Tu reservación fue creada correctamente",button:"OK"}).then((()=>{window.location.reload()}))}catch(e){Swal.fire({icon:"error",title:"Error",text:"Hubo un error al guardar la reservación"}).then((()=>{window.location.reload()}))}}document.addEventListener("DOMContentLoaded",(function(){startApp()}));