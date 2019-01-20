import { request } from "./module/request.js";

//document.addEventListener('DOMContentLoaded', function() { 
    
let file, mail, pass, dataObj, dataJson, data;

// selezionare un inseme di elementi e aggiungere a ognuno di essi un evento
const buttons = document.querySelectorAll('.bt');

for ( const button of buttons ) { button.addEventListener('click', fn); }


function fn(e) {

console.log(1);
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

            request(file , data); console.log(data);
        
        break;


        case "signin": console.log("signin");
        
            e.preventDefault();

            file = "signin.php";

            mail = document.querySelector('#email').value;
            pass = document.querySelector('#password').value;

            dataObj = {
                mail: mail,
                pass: pass
            }

            dataJson = JSON.stringify(dataObj); // converte l' array di oggetti in formato json

            data = "signin="+dataJson; // aggiungere "jsonSelect=" prima della stringa json altrimenti in php l'array $_POST["jsonSelect"] non viene settato

            request(file , data); console.log(data);
        
        break;


        case "logout": console.log("logout");
        
            e.preventDefault();

            file = "logout.php";

            // const test = "test";
    
            // dataObj = {
            //     test: test
               
            // }

            dataJson = JSON.stringify(); // converte l' array di oggetti in formato json
            // dataJson = JSON.stringify(dataObj); 

            data = "logout={test: test1}"; // aggiungere "jsonSelect=" prima della stringa json altrimenti in php l'array $_POST["jsonSelect"] non viene settato

            request(file , data); console.log(data);
        
        break;



        case "truncate":
            file = "truncate.php";
            request(file)
            .then((success)=>{
            console.log(success);
            // preparePage(1);
            // clearTable(); 
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

            e.preventDefault();

            e.target.parentNode.classList.add("active");
    
            document.getElementById("type-signin").parentNode.classList.remove("active");

            
            document.getElementById("form-signin").hidden = true;
            document.getElementById("form-signup").hidden = false;
        break;



    }
}






// });