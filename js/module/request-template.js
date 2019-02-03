function requestTemplate(template){

    return new Promise((resolve, reject) =>{

        const xhr = typeof XMLHttpRequest != 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        xhr.open('get', "layout/"+template, true);
        xhr.onreadystatechange = function() {

            if (xhr.readyState == 4 ) { 

                if (this.status >= 200 && this.status < 300) { 

                    document.querySelector(".wrapper").innerHTML = xhr.responseText; 
                    //resolve(xhr.responseType);
                    resolve("test");
                } else {
                    reject("Errore: html non caricato" );
                }
            }
        }
        xhr.send();
    });
}


export { requestTemplate };