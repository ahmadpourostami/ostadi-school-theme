document.addEventListener('DOMContentLoaded',function(){
 document.documentElement.setAttribute('data-ostadi-elements','1');
 let audioPlayer=null;
 document.querySelectorAll('[data-ostadi-audio]').forEach(function(button){
  button.addEventListener('click',function(){
   const url=button.getAttribute('data-ostadi-audio'); if(!url)return;
   if(audioPlayer){audioPlayer.pause();audioPlayer.remove();audioPlayer=null;document.querySelectorAll('[data-ostadi-audio]').forEach(function(b){b.textContent='▶';});}
   audioPlayer=document.createElement('audio'); audioPlayer.src=url; audioPlayer.preload='metadata'; audioPlayer.controls=true; audioPlayer.className='ostadi-inline-player';
   button.parentNode.appendChild(audioPlayer); button.textContent='❚❚'; audioPlayer.play().catch(function(){});
   audioPlayer.addEventListener('ended',function(){button.textContent='▶';});
  });
 });
 document.querySelectorAll('[data-ostadi-carousel]').forEach(function(root){
  const track=root.querySelector('.ostadi-carousel__track'),items=root.querySelectorAll('.ostadi-carousel-card'),prev=root.querySelector('[data-carousel-prev]'),next=root.querySelector('[data-carousel-next]'),dots=root.querySelector('[data-carousel-dots]');
  if(!track||!items.length)return; let index=0;
  function perView(){if(window.innerWidth<=620)return 1;if(window.innerWidth<=1100)return 2;return parseInt(root.getAttribute('data-per-view')||'3',10);}
  function maxIndex(){return Math.max(0,items.length-perView());}
  function render(){const pv=perView();const gap=14;const width=(root.querySelector('.ostadi-carousel__viewport').clientWidth-(pv-1)*gap)/pv;items.forEach(function(item){item.style.flexBasis=width+'px';});index=Math.min(index,maxIndex());const step=width+gap;track.style.transform='translate3d('+ (root.getAttribute('dir')==='rtl' ? index*step : -index*step) +'px,0,0)';if(dots){dots.innerHTML='';for(let i=0;i<=maxIndex();i++){const d=document.createElement('button');d.type='button';d.className=i===index?'is-active':'';d.addEventListener('click',function(){index=i;render();});dots.appendChild(d);}}}
  if(prev)prev.addEventListener('click',function(){index=Math.max(0,index-1);render();}); if(next)next.addEventListener('click',function(){index=Math.min(maxIndex(),index+1);render();}); window.addEventListener('resize',render); render();
 });
 document.querySelectorAll('[data-ostadi-video]').forEach(function(button){
  button.addEventListener('click',function(){const url=button.getAttribute('data-ostadi-video');if(!url)return;const media=button.closest('.ostadi-video-carousel-card__media,.ostadi-media-card__image');if(!media)return;let video=media.querySelector('video');if(!video){video=document.createElement('video');video.className='ostadi-inline-video';video.controls=true;video.preload='metadata';video.src=url;const poster=button.getAttribute('data-poster');if(poster)video.poster=poster;media.innerHTML='';media.appendChild(video);}video.play().catch(function(){});});
 });
});
