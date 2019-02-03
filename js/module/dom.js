
function removeAlerts() {

    const alerts = document.querySelectorAll(".alert");
    for ( const alert of alerts ) { alert.hidden = true; }
}


function deactivateButton(button) {

    removeAlerts();

    const element = document.querySelector("#"+button);
    element.setAttribute("disabled","true");
    element.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbspLoading...`;
}

function activateButton(text) {

    const element = document.querySelector("#signup");
    element.removeAttribute("disabled");
    element.innerHTML = text;
}

function singleError(obj) {

    removeAlerts();

    const alert = document.querySelector(`.alert-${obj.error}`);
    alert.hidden = false;
    alert.innerHTML = obj.message;
}

function multiError(arrOfobj) {

    removeAlerts();

    for ( let i=0; i<arrOfobj.length; i++ ) {

        const alert = document.querySelector(`.alert-${arrOfobj[i].error}`);
        alert.hidden = false;
        alert.innerHTML = arrOfobj[i].message;
    }
}

export { deactivateButton, activateButton, singleError, multiError };