toggle=(query, class_)=>{
    var element=document.querySelector(query);
    if(element!=null){
        element.classList.toggle(class_);
    }
}
const panel=document.getElementById("panelMssg");

controlPanelMssg=(values)=>{
    panel.classList.remove("hidden");
    panel.classList.add(values.type);
    if(values.tittle)
        panel.firstElementChild.firstElementChild.innerHTML=values.tittle;
    if(values.content){
        var output="";
        for(let val of values.content){
            output+="<p>"+val+"</p>";
        }
        panel.children[1].firstElementChild.innerHTML=output;
    } 
}
controlPanelMssgClear=()=>{
    panel.classList="hiddren";
    panel.children[1].firstElementChild.innerHTML="";
    panel.firstElementChild.firstElementChild.innerHTML="";
}