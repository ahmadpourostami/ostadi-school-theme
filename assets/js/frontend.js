document.addEventListener('DOMContentLoaded',function(){
 document.documentElement.setAttribute('data-ostadi-elements','1');
 let player=null;
 document.querySelectorAll('[data-ostadi-audio]').forEach(function(button){
  button.addEventListener('click',function(){
   const url=button.getAttribute('data-ostadi-audio');
   if(!url)return;
   if(player){player.pause();player.remove();player=null;document.querySelectorAll('[data-ostadi-audio]').forEach(function(b){b.textContent='▶';});}
   player=document.createElement('audio');
   player.src=url;player.preload='metadata';player.controls=true;player.className='ostadi-inline-player';
   button.parentNode.appendChild(player);
   button.textContent='❚❚';
   player.play().catch(function(){});
   player.addEventListener('ended',function(){button.textContent='▶';});
  });
 });
});