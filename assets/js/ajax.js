const cart=document.getElementById("shopping-cart");
function addCart(id_item, value=1, action="none"){
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
    // action => 1-> sumar , 2->restar
    xmlHttp.send("item="+ id_item+"&v="+value+"&act="+action);
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

iLikeProduct=(id_prod,btn)=>{
    xmlHttp= new XMLHttpRequest();
    xmlHttp.open("POST",'index.php?c=user&a=i_like_product');
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.onreadystatechange = ()=>{
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var res=xmlHttp.responseText;
            if(res){
                btn.classList="btn-like flex-center "+res;
                console.log(res)
                // cart.children[1].innerHTML=res;
            }
        }
    };
    xmlHttp.send("idp="+id_prod);
}


const tableItems=document.getElementById("table-items-shop");
const foot=document.getElementById("footer-modal");

function getPorductsSelected(){
    xmlHttp= new XMLHttpRequest();
    xmlHttp.open("POST",'index.php?c=cart&a=get');
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");

    xmlHttp.onreadystatechange = ()=>{
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var products=JSON.parse(xmlHttp.responseText);
            console.log(products)
            if(products.length>0){
                let subtotal=0;
                output="";
                for(let prod of products){
                    let precioTotal=(((100-prod.product.discount)/100)*prod.product.price*prod.cant);
                    subtotal+=precioTotal;
                    output+="<tr>"+
                            "<td>"+prod.product.name_prod+"</td>"+
                            "<td>$ "+parseInt(prod.product.price).toFixed(2)+"</td>"+
                            "<td>"+prod.product.discount+"%</td>"+
                            "<td><input type='number' value='"+prod.cant+"' onchange='changeValue("+prod.product.id_prod+","+prod.product.discount+","+prod.product.price+","+prod.product.quantity+", this);' min=1 max="+prod.product.quantity+"></td>"+
                            "<td>$ "+(precioTotal).toFixed(2)+"</td>"+
                            "<td><button class='btn-remove-item' onclick='removeItem(this.parentNode.parentNode,"+prod.product.id_prod+")'>x<button></td>"+
                            "</tr>";
                }
                foot.innerHTML="<p class='flex space-around'>"+
                                    "<span>Subtotal</span><span>$ "+subtotal.toFixed(2)+"</span>"+
                                "</p>"+
                                "<p class='flex space-around'>"+
                                    "<span>Iva 12%</span><span>$ "+(subtotal*0.12).toFixed(2)+"</span>"+
                                "</p>"+
                                "<p class='flex space-around'>"+
                                    "<span>Total</span><span>$ "+(subtotal*1.12).toFixed(2)+"</span>"+
                                "</p>";
                tableItems.tBodies[0].innerHTML=output;

                removeClass('#window-modal-items','hidden');
            }
        }
    };
    xmlHttp.send();
}

changeValue=(id_prod,discount, price,max, input)=>{

    input.value = input.value > 1? input.value:1;
    input.value = input.value > max? max:input.value;
    let precioTotal=(((100-discount)/100)*price*input.value);
    input.parentNode.parentNode.children[4].innerHTML="$ "+precioTotal.toFixed(2);
    addCart(id_prod,input.value, "change");
}

removeItem=(row, id_item)=>{
    xmlHttp= new XMLHttpRequest();
    xmlHttp.open("POST",'index.php?c=cart&a=removeItem');
    xmlHttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
    xmlHttp.onreadystatechange = ()=>{
        if(xmlHttp.readyState == 4 && xmlHttp.status == 200){
            var res=xmlHttp.responseText;
            console.log(res)
            if(res){
                row.parentNode.removeChild(row);
                queryCartCantItems()
            }
        }
    };
    xmlHttp.send("item="+ id_item);
}

queryCartCantItems();
