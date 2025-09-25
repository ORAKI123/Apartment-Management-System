// small helpers
function showNotification(title, text) {
  const box = document.createElement('div');
  box.style.position='fixed'; box.style.right='20px'; box.style.bottom='20px'; box.style.background='#fff3cd'; box.style.padding='12px'; box.style.border='1px solid #ffd966'; box.style.borderRadius='8px'; box.innerHTML='<strong>'+title+'</strong><div>'+text+'</div><button onclick="this.parentElement.remove()" style="margin-top:8px">Close</button>';
  document.body.appendChild(box);
  setTimeout(()=>box.remove(),7000);
}
