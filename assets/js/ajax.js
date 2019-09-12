const cart=document.getElementById("shopping-cart");
function addCart(id_item){
    xmlHttp= new XMLHttpRequest();
    xmlHttp.open("POST",'index.php?c=cart&a=addItem');
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xmlHttp.onreadystatechange = ()=>{
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var res=xmlHttp.responseText;
            if(res){
                cart.children[1].innerHTML=res;
            }
        }
    };
    xmlHttp.send("item="+ id_item);
}
function queryCartCantItems(){
    xmlHttp= new XMLHttpRequest();
    xmlHttp.open("POST",'index.php?c=cart&a=count');
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xmlHttp.onreadystatechange = ()=>{
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var res=xmlHttp.responseText;
            if(res){
                cart.children[1].innerHTML=res;
            }
        }
    };
    xmlHttp.send();
}
queryCartCantItems();