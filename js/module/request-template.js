function loadTemplate(template){

    return new Promise((resolve, reject) =>{

        const xhr = typeof XMLHttpRequest != 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        xhr.open('get', "layout/"+template, true);
        xhr.onreadystatechange = function() {

            if (xhr.readyState == 4 ) { 

                if (xhr.status == 304 || xhr.status == 200) { 

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
    // return new Promise((resolve, reject) =>{

    //     const xhr = typeof XMLHttpRequest != 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
    //     xhr.open('get', "layout/"+template, true);
    //     xhr.onreadystatechange = function() {

    //         if (xhr.readyState == 4 && xhr.status == 200) { 

    //             document.querySelector(".wrapper").innerHTML = xhr.responseText; 
    //             resolve("Success: html caricato");
    //         } else {
    //             reject("Errore: html non caricato" );
    //         }
    //     }
    //     xhr.send();
    // });
}


export { loadTemplate };