// RICHIESTA FILE DI JSON --------------------------------------------------
function request(file, data=null){

    return new Promise((resolve, reject) =>{
// var xhr = typeof XMLHttpRequest != 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    const xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 ) {
            if (this.status == 200) {
  
            let str = xhttp.responseText;  // console.log(str);
    
            let obj = JSON.parse(str);   console.log(obj);
    

            if(obj.hasOwnProperty("success")){

                resolve("Success: "+obj.success);
               
            } else if(obj.hasOwnProperty("error")){ 
           
                 reject("Errore: "+obj.error );
            } 
                 
        } else { reject("Errore code:"+this.status);}
    }
        
    };
    xhttp.open("POST", "server/"+file, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(data);
    });
}
    

export { request };
