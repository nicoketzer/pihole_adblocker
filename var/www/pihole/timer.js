//Dieser Handler überschreibt den Orginalen von refresh.js somit muss auch die "start()" funktion hier aufgerufen werden
window.onload = function (){
    start_timer(0);
    start();
}
function start_timer(old_time){
  document.getElementById('timer').innerHTML = Number(old_time+1);
        setTimeout(function (){
                start_timer(old_time+1);
        },1000);
}

