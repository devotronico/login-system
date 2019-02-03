import { request } from "./module/request.js";

import { requestTemplate } from "./module/request-template.js";

//document.addEventListener('DOMContentLoaded', function() { 
    
let file, mail, pass, dataObj, dataJson, data;

// selezionare un inseme di elementi e aggiungere a ognuno di essi un evento
function addEventToButton(){

    const buttons = document.querySelectorAll('.bt');
    
    for ( const button of buttons ) { button.addEventListener('click', fn); }
}
addEventToButton();

function fn(e) {


    switch(e.target.id){

        case "signup": console.log("signup");

            e.preventDefault();

            file = "signup.php";
            name = document.querySelector('#name-signup').value;
            mail = document.querySelector('#email-signup').value;
            pass = document.querySelector('#password-signup').value;

            dataObj = {

                name: name,
                mail: mail,
                pass: pass
            }

            dataJson = JSON.stringify(dataObj); // converte l' array di oggetti in formato json

            data = "signup="+dataJson; // aggiungere "jsonSelect=" prima della stringa json altrimenti in php l'array $_POST["jsonSelect"] non viene settato
         
            request(file , data)
            .then((success)=>{

                console.log(success);
                return requestTemplate('signup-email.tpl.html');
            })
            .then((html)=>{

                console.log(html);
                addEventToButton(); // console.log(2);
            })
            .catch(obj => { console.log(obj[0]) })

                
            //     const alerts = document.querySelectorAll(".alert");
            //     for ( const a of alerts ) { a.hidden = true; }

            //     for ( let i=0; i<obj.length; i++ ) {
            //         // console.log(obj[i].status); //
            //         // console.log(obj[i].error); //
            //         // console.log(obj[i].message); //

            //         const alert = document.querySelector(`.alert-${obj[i].error}`);
            //         alert.hidden = false;
            //         alert.innerHTML = obj[i].message;
            //     }


            //     // console.log(obj.status);
            //     // console.log(obj.error);
            //     // console.log(obj.message);
              
           

            // });
        break;



        case "signin":  console.log("signin");
        
            e.preventDefault();

            file = "signin.php";
           
            mail = document.querySelector('#email-signin').value;
            pass = document.querySelector('#password-signin').value;
            
            dataObj = {
                mail: mail,
                pass: pass
            }
           
            dataJson = JSON.stringify(dataObj); // converte l' array di oggetti in formato json
        
            data = "signin="+dataJson; console.log(data);

            request(file , data)   
            .then((success)=>{

                console.log(success);  console.log(1);
                return loadTemplate('home.tpl.html');
            })
            .then((html)=>{

                console.log(html);
                addEventToButton(); console.log(2);
             
            })
            .catch(err => console.log(err));
        break;



        case "logout":   console.log("logout OK");
        
            e.preventDefault();  

            file = "logout.php";

            request(file)
            .then((success)=>{

                console.log(success);
                return loadTemplate('signin-form.tpl.html');
            }) 
            .then((html)=>{

                console.log(html);
                addEventToButton(); console.log(2);
            })
            .catch((err)=>console.log(err))
        break;



        case "pass-emailform":  
        
            e.preventDefault(); 

            console.log("passwordrecovery OK");

            file = "passrecovery.php";
            const template = "passrecovery.tpl.html";

            loadTemplate(template)
            .then((html)=>{

                console.log(html);
                addEventToButton();
            })
            .catch((err)=>console.log(err))
        break;


        
        case "pass-emailcheck":  
        
            e.preventDefault(); 

            console.log("pass-emailcheck OK");

            file = "pass-emailcheck.php";

           
            mail = document.querySelector('#email-signup').value;
           
            dataObj = { mail: mail };

            dataJson = JSON.stringify(dataObj); // converte l' array di oggetti in formato json

            data = "emailcheck="+dataJson; // aggiung

            request(file, data)
            .then((success)=>{

                console.log(success);
               // return loadTemplate('signin-form.tpl.html');
            }) 
            .then((html)=>{

                console.log(html);
                addEventToButton(); 
            })
            .catch((err)=>console.log(err))
        break;




        case "truncate":
            file = "truncate.php";
            request(file)
            .then((success)=>{
                console.log(success);
            })
            .catch(err => console.log(err));
        break;



        case "type-signin":  console.log("type-signin"); 

            e.target.parentNode.classList.add("active");
    
            document.getElementById("type-signup").parentNode.classList.remove("active");

            document.getElementById("form-signin").hidden = false;
            document.getElementById("form-signup").hidden = true;
        break;



        case "type-signup": console.log("type-signup");

            //e.preventDefault();

            e.target.parentNode.classList.add("active");
    
            document.getElementById("type-signin").parentNode.classList.remove("active");

            document.getElementById("form-signin").hidden = true;
            document.getElementById("form-signup").hidden = false;
        break;
    }
}


