// RICHIESTA FILE DI JSON --------------------------------------------------
function request(file, data=null){

    return new Promise((resolve, reject) =>{

    const xhttp = new XMLHttpRequest();

    xhttp.onreadystatechange = function(){
        if (this.readyState == 4 ) {
            if (this.status == 200) {
  
            let str = xhttp.responseText;  // console.log(str);
    
            let obj = JSON.parse(str);   console.log(obj);
    
         /*
            if(obj.hasOwnProperty("success")){
               // console.log(obj.action);
                switch ( obj.action ) {
                    case "count":  console.log("count"); break;
                    case "select":  console.log("select"); break;
                }
            }*/

/*
            if(obj.hasOwnProperty("success")){

                resolve("Success: "+obj.success);
               
            } else if(obj.hasOwnProperty("error")){ 
           
                 reject("Errore: "+obj.error );

            } else if(obj.hasOwnProperty("empty")){ 

                reject("Empty: "+obj.empty);
                // clearTable(); 
                //reject("Errore: "+obj.empty ); 
            } else if(obj.hasOwnProperty("view")){ 

                resolve(obj);   // fillViewModal(obj);  

            } else if(obj.hasOwnProperty("count")){ 
    
                resolve(obj);
            } else {
             
                resolve(obj);
            }
            */
                 
        } else { reject("Errore code:"+this.status);}
    }
        
    };
    xhttp.open("POST", "server/"+file, true);
    xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhttp.send(data);
    });
}
    

export { request };
