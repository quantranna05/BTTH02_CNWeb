document.addEventListener('DOMContentLoaded',function(){
    const alerts=document.querySelectorAll('.alert');
    alerts.forEach(a=>setTimeout(()=>a.style.display='none',3000));
});
