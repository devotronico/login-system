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

            file = "signup";
            name = document.querySelector('#name-signup').value;
            mail = document.querySelector('#email-signup').value;
            pass = document.querySelector('#password-signup').value;

            dataObj = {

                name: name,
                mail: mail,
                pass: pass
            }

            dataJson = JSON.stringify(dataObj); // converte l' array di oggetti in formato json

            data = file+"="+dataJson; // aggiungere "jsonSelect=" prima della stringa json altrimenti in php l'array $_POST["jsonSelect"] non viene settato

            request(file , data)
            .then((message)=>{

                return requestTemplate('signup-email.tpl.html', message);
            })
            .then((html)=>{

                console.log(html);

                addEventToButton(); // console.log(2);
            })
            .catch(error => { console.log(error) })

        break;



        case "signin":  console.log("signin");

            e.preventDefault();

            file = "signin";

            const token = document.querySelector('#token-signin').value;
            mail = document.querySelector('#email-signin').value;
            pass = document.querySelector('#password-signin').value;

            dataObj = {
                token: token,
                mail: mail,
                pass: pass
            }

            dataJson = JSON.stringify(dataObj); // converte l' array di oggetti in formato json

            data = file+"="+dataJson; // console.log(data);

            request(file , data)
            .then((message)=>{

                return requestTemplate('home.tpl.html', message);
            })
            .then((message)=>{

                console.log(message);
                const el = document.querySelector(".message-template");
                el.innerHTML = message;
                addEventToButton();

            })
            .catch(err => console.log(err));
        break;


        case "verify": // console.log("verify");

            e.preventDefault();

            file = "verify";

            mail = document.querySelector('#email-verify').value;

            dataObj = { mail: mail }

            dataJson = JSON.stringify(dataObj);

            data = file+"="+dataJson; console.log(data);

            request(file , data)
            .then((message)=>{

                return requestTemplate('verify.tpl.html', message);
            })
            .then((html)=>{

                console.log(html);
                addEventToButton();
            })
            .catch(err => console.log(err));
        break;



        case "logout":

            e.preventDefault();

            file = "logout";

            dataObj = { mail: "dan@mail.it" }

            dataJson = JSON.stringify(dataObj);

            data = file+"="+dataJson; console.log(data);

            request(file, data)
            .then((message)=>{

                return requestTemplate('home.tpl.html', message);

                // return requestTemplate('signin-form.tpl.html', message);
            })
            .then((message)=>{

                console.log(message);
                document.querySelector(".message-template").innerHTML = message;
                addEventToButton();
            })
            .catch((err)=>console.log(err))
        break;



        case "pass-emailform":

            e.preventDefault();

            file = "passrecovery";
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

            file = "pass-emailcheck";


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

            file = "truncate";

            request(file)
            .then((message)=>{

                return requestTemplate('truncate.tpl.html', message);
            })
            .then((html)=>{

                console.log(html);
                addEventToButton();
            })
            .catch(obj => { console.log(obj[0]) })
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


