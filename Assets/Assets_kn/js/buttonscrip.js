/*function vermas(id){
  if(id=="mas"){
  document.getElementById("desplegar").style.display="block";   
  document.getElementById("mas").style.display="none"; 
  }
  else{
  document.getElementById("desplegar").style.display="none";
  document.getElementById("mas").style.display="inline";
  }
  }*/

  //function vermas(hideText_btns)

  let hideText_btns = document.getElementById('hideText_btns');
  let hideText = document.getElementById('hideText');
  
  hideText_btns.addEventListener('click', toggleText);   

   function toggleText(){
    hideText.classList.toggle('show');
    if(hideText.classList.contains('show')){
      hideText_btns.innerHTML = 'Leer menos';
    }else{
      hideText_btns.innerHTML = 'Leer mas';
    }

   }
// boton 2
   let htb2 = document.getElementById('btn2');
   let ht2 = document.getElementById('ht2');

   htb2.addEventListener('click', toggleText2);   

   function toggleText2(){
    ht2.classList.toggle('show');
    if(ht2.classList.contains('show')){
      htb2.innerHTML = 'Leer menos';
    }else{
      htb2.innerHTML = 'Leer mas';
    }

   }
//boton 3
let htb3 = document.getElementById('btn3');
let ht3 = document.getElementById('ht3');

htb3.addEventListener('click', toggleText3);   

function toggleText3(){
 ht3.classList.toggle('show');
 if(ht3.classList.contains('show')){
   htb3.innerHTML = 'Leer menos';
 }else{
   htb3.innerHTML = 'Leer mas';
 }

}

//boton 5
htb5 = document.getElementById('btn5');
ht5 = document.getElementById('ht5');

htb5.addEventListener('click', toggleText5);   

function toggleText5(){
 ht5.classList.toggle('show');
 if(ht5.classList.contains('show')){
   htb5.innerHTML = 'Leer menos';
 }else{
   htb5.innerHTML = 'Leer mas';
 }

}
