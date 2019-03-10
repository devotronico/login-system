
function removeAlerts() {

    const alerts = document.querySelectorAll(".alert");
    for ( const alert of alerts ) { alert.hidden = true; }
}

// TODO: disattivare anche i campi input name, email, password
function deactivateButton(type) {

// const arr = [ "truncate", "logout", "verify"];
// let newArr = arr.filter((a) => a > 12);
// console.log(newArr); // return [20, 30]
// posts.filter((post) => post.img !== null && post.likes > 50);

    const lista = ["signin", "signup"];
    if ( lista.indexOf(type) === -1 ) return;

    // if ( type !== "truncate" && type !== "logout" && type !== "verify" ) {

    removeAlerts();

    if ( type === "signup" ) {
        const name = document.querySelector("#name-"+type); // id: name-signin
        name.setAttribute("disabled","true");
    }
    const email = document.querySelector("#email-"+type); // id: email-signin
    email.setAttribute("disabled","true");

    const password = document.querySelector("#password-"+type); // id: password-signin
    password.setAttribute("disabled","true");

    const button = document.querySelector("#"+type);
    button.setAttribute("disabled","true");
    button.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbspLoading...`;
    // }
}

function activateButton(arg) {

    let inputs = document.getElementsByTagName('INPUT');
    for(var i = 0; i < inputs.length; i++) {

        inputs[i].disabled = false;
    }

    const element = document.querySelector("#"+arg);
    element.removeAttribute("disabled");

    if (typeof arg !== 'string') {  element.innerText = arg; }
    element.innerText = arg.charAt(0).toUpperCase() + arg.slice(1);
}

function singleError(obj) {

    removeAlerts();
    activateButton(obj.page);

    const alert = document.querySelector(`.alert-${obj.page}-${obj.type}`); // alert-danger alert-signin-email // alert-signup-email
    // const alert = document.querySelector(`.alert-${obj.error}`); // alert-danger alert-signin-email
    if ( alert === null ) { return; }
    alert.hidden = false;
    alert.innerHTML = obj.message;
}


// TODO: permettere all' utente di inviare un messaggio al webmaster e riportare gli errori
function getFatalError(obj, message) {

    removeAlerts();
    activateButton(obj.page);

    const alert = document.querySelector(".alert-fatal-error");
    alert.hidden = false;

    const mess = document.createElement("p");
    mess.innerText = message +' codice errore: '+obj.code;

    const boxBtn = document.querySelector(".box-btn-fatal-error"); // bottone verify

    alert.insertBefore(mess, boxBtn);
}



function sendVerifiedEmail(obj) {

    removeAlerts();
    activateButton(obj.page);

    const alert = document.querySelector(".alert-verify-email");
    alert.hidden = false;

    const mess = document.createElement("p");
    mess.innerText = obj.message;

    const boxBtn = document.querySelector(".box-btn-verify-email"); // bottone verify
    // const verifyBtn = document.querySelector("#verify"); // bottone verify
   // verifyBtn.hidden = false;

   // alert.appendChild(mess);
    alert.insertBefore(mess, boxBtn);


    const valueMailSignin = document.querySelector('#email-signin').value;   console.log(valueMailSignin);
    document.querySelector("#email-verify").value = valueMailSignin;
}

function multiError(arrOfobj) {

    removeAlerts();
     console.log(arrOfobj[0].page);
     //console.log(arrOfobj[1][1].message);
    // activateButton(arrOfobj.page);
    activateButton(arrOfobj[0].page);
   

    for ( let i = 0; i < arrOfobj[1].length; i++ ) {

        const alert = document.querySelector(`.alert-${arrOfobj[0].page}-${arrOfobj[1][i].type}`); // alert-signup-name
        alert.hidden = false;
        alert.innerHTML = arrOfobj[1][i].message;
    }
}

export { deactivateButton, activateButton, singleError, multiError, getFatalError,sendVerifiedEmail };