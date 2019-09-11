const letrasNumEspacio = new RegExp(/^[\w\-\s]+$/ );
const validaUrl = new RegExp(/(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/ );
const imgFormat=new RegExp(/\.(jpg|png|gif)$/i);
const soloNum=new RegExp(/^[0-9]+$/);
//k
const sololetras = new RegExp(/^[\u00F1A-Za-z _]*[\u00F1A-Za-z][\u00F1A-Za-z _]*$/);

const numDecimal=new RegExp(/^(0|[1-9]\d*)(\.\d+)?$/ );
const alphareg = /^[A-Za-z]*\s()[A-Za-z]*$/g;
const emailreg = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
const expUsername=/^[a-z0-9ü][a-z0-9ü_]{3,15}$/;
const regexp_password = /^(?=.*\d)(?=.*[\u0021-\u002b\u003c-\u0040])(?=.*[A-Z])(?=.*[a-z])\S{6,16}$/;
const regexobj=/^[a-zA-Z0-9üáéíóú][a-zA-Z0-9ü+ _áéíóú-]{3,30}$/;
const regexobjPrepare=/^[a-zA-Z0-9üáéíóú][a-zA-Z0-9ü+ _.,:;áéíóú-]{3,900}$/;


function validateNewUser(){
    var mensaje=[];
    // removeErr("#panelErr");
    var form = document.querySelector("#form-signup");
    var name=form.name;
	var lastName=form.lastname;
	var username=form.username;
	var password=form.password;
	var birthday=document.querySelector("input[name='birthday']");
	var gender=form.gender;
	var country=document.querySelector("select[name='county']");
    var email=form.email;
    if(name.value.length<3){
        mensaje.push("Escriba su nombre, su nombre debe tener más de 3 caracteres.");
    }else if(!letrasNumEspacio.test(name.value)){
        mensaje.push("Su nombre tiene caracteres erróneos.");
    }

    if(lastName.value.length<3){
        mensaje.push("Escriba su segundo nombre, su nombre debe tener más de 3 caracteres.");
    }else if(!letrasNumEspacio.test(name.value)){
        mensaje.push("Su segundo Nombre tiene caracteres erróneos.");
    }

    if(!username.value){
        mensaje.push("Escriba su nombre de usuario");
    }else if(!expUsername.test(username.value)){
        mensaje.push("Su nombre de usuario tiene caracteres no permitidos.");
    }

    // if(birthday){
        fecha=birthday.value.split("-");
		var fechaCompare = new Date(parseInt(fecha[0])//año
								,parseInt(fecha[1]-1),//mes
								parseInt(fecha[2]));//dia
        //Comprobamos si existe la fecha
		if (isNaN(fechaCompare)){
			mensaje.push("La fecha es incorrecta.");
		}else if(fechaCompare.getFullYear() >= (new Date().getFullYear()-18))
				mensaje.push("El usuario debe ser mayor de edad.");
    // }


    if(gender.value!=2 && gender.value!=1){
        mensaje.push("Seleccione su género.");
    }
    if(!email.value){
        mensaje.push("Escriba su dirección de correo electrónico.");
    }else if(!emailreg.test(email.value) ){
        mensaje.push("Digíte un correo electrónico válido.");
    }
    if(country.value==0){
        mensaje.push("Seleccione el país.");
    }
    if(!regexp_password.test(password.value)){
        mensaje.push("La contraseña debe tener al entre 6 y 16 caracteres, al menos un dígito, al menos una minúscula, al menos una mayúscula y al menos un caracter no alfanumérico. ");
    }
    if(mensaje.length==0) return true;
    controlPanelMssg({tittle:"Error",content:mensaje,type:"error"});    
    return false;
}

