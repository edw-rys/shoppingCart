var productos=[
    {
        name:"img 1",
        urlImg:'assets/img/gallery/g1.jpg',
        like:"like"
    },
    {
        name:"img 2",
        urlImg:'assets/img/gallery/g2.jpg',
        like:"no-like"
    },
    {
        name:"img 3",
        urlImg:'assets/img/gallery/g3.jpg',
        like:"like"
    },
    {
        name:"img 4",
        urlImg:'assets/img/gallery/g4.jpg',
        like:"like"
    },
    {
        name:"img 5",
        urlImg:'assets/img/gallery/g5.jpg',
        like:"no-like"
    },
    {
        name:"img 6",
        urlImg:'assets/img/gallery/g6.jpg',
        like:"no-like"
    },
    {
        name:"img 7",
        urlImg:'assets/img/gallery/g7.jpg',
        like:"like"
    }
];

cargarProductos=()=>{
    var value="";
    for(let producto of productos){
        value+="<div class='producto'><img src='"+producto.urlImg+"' alt='"+producto.name+"'>"+
            "<div class='detail'><span>"+producto.name+"</span><button class='btn-like "+producto.like+"'>< 3</button></div></div>"
    }
    var productos_=document.getElementById("productos");
    if(productos_){
        productos_.innerHTML=value;
    }
}
cargarProductos();