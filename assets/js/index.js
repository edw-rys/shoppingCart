toggle=(query, class_)=>{
    var element=document.querySelector(query);
    if(element!=null){
        element.classList.toggle(class_);
    }
}
addClass=(query, class_)=>{
    var element=document.querySelector(query);
    if(element!=null){
        element.classList.add(class_);
    }
}
removeClass=(query, class_)=>{
    var element=document.querySelector(query);
    if(element!=null){
        element.classList.remove(class_);
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

preview=(input, query)=>{
    if(input.files && input.files[0]){	
        this.queryimginsert=query;
        var reader=new FileReader();
        reader.onload=function(e){
            var panel=document.querySelector(self.queryimginsert);
            panel.innerHTML="<img src='"+ e.target.result+"'>";
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function checkFile(){
    var fileInput =document.getElementById('file-img');
    var filePath=fileInput .value;
    var allowedExtensions = /(.jpg|.jpeg|.png|.gif|.jfif)$/i;
    console.log(filePath);
    return allowedExtensions.exec(filePath);
}