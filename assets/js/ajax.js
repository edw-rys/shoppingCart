const cart=document.getElementById("shopping-cart");

function addCart(id_item, value=1, action="none"){
    let cart=new FormData();
    cart.set("item",id_item);
    cart.set("v",value);
    // action => 1-> sumar , 2->restar
    cart.set("act",action);
    fetch(`${URL_APP}cart/addItem`,{method:"POST",body:cart})
    .then(res=>res.text())
    .then(res=>{ queryCartCantItems() })
    .catch(err=>console.log(err));
}
function queryCartCantItems(){
    fetch(`${URL_APP}cart/count`)
    .then(res=>res.text())
    .then(res=>{   cart.children[1].innerHTML=res; })
    .catch(err=>console.log(err));
}

iLikeProduct=(id_prod,btn)=>{
    let cart=new FormData();
    cart.set("idp",id_prod);
    fetch(`${URL_APP}user/i_like_product`,{method:"POST",body:cart})
    .then(res=>{return res.text() })
    .then(res=>{ 
        if(res){
            btn.classList="btn-like flex-center "+res;
        }
    })
    .catch(err=>console.log(err));
}


const tableItems=document.getElementById("table-items-shop");
const foot=document.getElementById("footer-modal");
const windowModal=document.getElementById("windowModal");

function getPorductsSelected(){
    fetch(`${URL_APP}cart/get`)
    .then(res=>res.text())
    .then(view=>{   
        windowModal.querySelector("._body").innerHTML=view;
        windowModal.classList.remove("hidden")
    })
    .catch(err=>console.log(err));

    
}

changeValue=(id_prod,discount, price,max, input)=>{
    input.value = input.value > 1? input.value:1;
    input.value = input.value > max? max:input.value;
    let precioTotal=(((100-discount)/100)*price*input.value);
    input.parentNode.parentNode.children[4].innerHTML="$ "+precioTotal.toFixed(2);
    addCart(id_prod,input.value, "change");
}

removeItem=(row, id_item)=>{
    let cart=new FormData();
    cart.set("item",id_item);
    fetch(`${URL_APP}cart/removeItem`,{method:"POST",body:cart})
    .then(res=>{return res.text() })
    .then(res=>{ 
        console.log(res);
        if(res){
            row.parentNode.removeChild(row);
            queryCartCantItems();
        }
    })
    .catch(err=>console.log(err));
}

// Panel insert product
activePanelInsertProduct=(action="insert")=>{
    fetch(`${URL_APP}product/view_insert`)
    .then(res=>{return res.text() })
    .then(view=>{ 
        if(view){
            windowModal.querySelector("._body").innerHTML=view;
                windowModal.classList.remove("hidden");
        }
    })
    .catch(err=>console.log(err));
}
queryCartCantItems();
