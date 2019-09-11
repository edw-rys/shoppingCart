const carousel=document.querySelector(".carousel").firstElementChild;
var numItem=carousel.childElementCount
var carouselAvance=0;
rightControl=()=>{
    if(carouselAvance<=((numItem-1)*100*-1))return;
    carouselAvance-=100;
    carousel.style.marginLeft=carouselAvance+"%";
}
leftControl=()=>{
    if(carouselAvance==0)return;
    carouselAvance+=100;
    carousel.style.marginLeft=carouselAvance+"%";
}