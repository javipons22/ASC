
var indexModeloSeleccionado = 0;
var colorModeloSeleccionado;
console.log(jsonPhp);

// ESCONDER CIERTOS DIV
jQuery("#color, #tamaño, #precio").hide();


function showNext(val, tipo, el) {
    if (tipo == 'watch') {
        // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
        jQuery(".modelo-watch").css("border", "1px solid rgba(136,136,136,.4)");
        var id = el.id;
        watchSeleccionado = val;

        // Cambiamos imagen al cambiar color de iphone
        var str1 = watchSeleccionado.replace(/\s/g, '');
        var imagen = imgPath + "/watch/" + str1.toLowerCase() + ".png";
        jQuery("#imagen").fadeOut();
        setTimeout(function () { jQuery("#imagen").attr('src', imagen); }, 300);

        // solo mostrar cuando termina de cargar la imagen 
        jQuery("#imagen").on('load', function () {
            jQuery("#imagen").fadeIn();
        });
        // ejemplo imagen = applewatch4gpssilver.png
        jQuery("#imagen").attr('alt', watchSeleccionado);

        // Si reseleccionamos iphone quitar el field de color y de precio
        jQuery("#precio,#tamaño").fadeOut("fast");

        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        colorMatcher(val);
        jQuery("#color").fadeIn("fast");

    } else if (tipo == 'color') {

        var id = el.id;
        jQuery("#precio").fadeOut("fast");
        // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
        jQuery(".color-watch label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");

        // Cambiamos imagen al cambiar color de iphone
        var str1 = watchSeleccionado.replace(/\s/g, '');
        var str2 = val.replace(/\s/g, '');
        var imagen = imgPath + "/watch/" + str1.toLowerCase() + str2.toLowerCase() + ".png";
        jQuery("#imagen").fadeOut();
        setTimeout(function () { jQuery("#imagen").attr('src', imagen); }, 300);

        // solo mostrar cuando termina de cargar la imagen 
        jQuery("#imagen").on('load', function () {
            jQuery("#imagen").fadeIn();
        });
        // ejemplo imagen = applewatch4gpssilver.png
        jQuery("#imagen").attr('alt', watchSeleccionado + " " + str2);


        tamañoMatcher(val, indexModeloSeleccionado);
        jQuery("#tamaño").fadeIn("fast");

    } else if (tipo == 'tamaño') {

        var id = el.id;
        // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
        jQuery(".tamaño-watch label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");

        /*
        // Cambiamos imagen al cambiar color de iphone
        var str1 = iPhoneSeleccionado.replace(/\s/g, '');
        var str2 = val.replace(/\s/g, '');
        var imagen = imgPath + "/iphone/"+ str1.toLowerCase() + str2.toLowerCase() + ".png";
        jQuery("#imagen").fadeOut();
        setTimeout(function(){ jQuery("#imagen").attr('src', imagen); }, 300);

        // solo mostrar cuando termina de cargar la imagen 
        jQuery("#imagen").on('load', function(){
            jQuery("#imagen").fadeIn();
        });
        
        jQuery("#imagen").attr('alt', iPhoneSeleccionado + " " + str2);
        */
        precioMatcher(val, indexModeloSeleccionado, colorModeloSeleccionado);
        jQuery("#precio").fadeIn("fast");

    }

}



function crearHTMLModelo(watch, id) {

    htmlString = `
        <li>
            <label for="watch${id}" class="box modelo-watch watch${id}">
            
                            <span>${watch}</span>
                            <input id="watch${id}" name="watch" type="radio" class="radio" value="${watch}" onclick="showNext(this.value, this.name,this)"/>
        
            </label>
        </li>`;
    return htmlString;

}


function crearHTMLColor(color, id, colorClase) {

    htmlString = `
        <li class="color-watch">
            <label for="color${id}" class="box color${id}">
                            <div class="${colorClase} circulo-color"></div>    
                            <span>${color}</span>
                            <input id="color${id}" name="color" class="radio" type="radio" value="${color}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLTamaño(tamaño, id) {

    htmlString = `
        <li class="tamaño-watch">
            <label for="tamaño${id}" class="box tamaño${id}">    
                            <span>${tamaño}</span>
                            <input id="tamaño${id}" name="tamaño" class="radio" type="radio" value="${tamaño}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
    return htmlString;

}


function crearHTMLPrecio(precio, promocion) {
    var promocionString = promocion == 0 || null ? `<span>$${precio}</span>` : `<span class="precio-tachado">$${precio}</span><span class="precio-promocion">  $${promocion}</span>`;
    var precioFinal = promocion == 0 || null ? precio : promocion;
    var hotSale = promocion == 0 || null ? 'Precio de contado' : 'PROMOCION HOTSALE!!';

    htmlString = `
        <li class="precio-watch">
            <label for="precio" class="precio-box">
                            <span>${hotSale} </span>`

                            htmlString += promocionString;
                            htmlString += `
                            <input id="precio" name="precio" class="radio" type="radio" value="${precioFinal}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
    return htmlString;

}

function displayModelos() {
    var i = 0;
    for (var property in jsonPhp) {
        if (jsonPhp.hasOwnProperty(property)) {

            // ELIGE TU MODELO
            // obtenemos variable para el html
            var iphone = jsonPhp[property].modelo;
            // aplicamos la funcion creada con el template para insertarlo en el html
            var htmlString = crearHTMLModelo(iphone, i);
            jQuery("#modelo ul").append(htmlString);
            i++;
        }
    }
}

function displayColores(htmlString) {
    jQuery("#color ul").append(htmlString);
}

// La funcion hace display de la seccion capacidades para el producto seleccionado
function colorMatcher(value) {

    // iteramos en los distintos index del objeto
    for (var property in jsonPhp) {


        // Chequeamos si el valor pasado a la funcion desde el radio button coincide con el modelo de celular en ese index - si coincide proseguimos
        if (jsonPhp[property].modelo == value) {
            // Guardamos el modelo seleccionado para hacer query del color y precio 
            indexModeloSeleccionado = property;
            // Seteamos una variable para que en la iteracion , si es el primer elemento iterado ( i == 0) borre los datos anteriores
            var i = 0;

            // iteramos en las capacidades del modelo matcheado
            for (var val in jsonPhp[property].color) {
                if (i == 0) {
                    //Borra los datos anteriores
                    jQuery(".color-watch").fadeOut().remove();

                    var color = val;
                    var colorParsed = color.replace(/\s+/g, '-').toLowerCase();

                    var htmlString = crearHTMLColor(val, i, colorParsed);
                    displayColores(htmlString);
                    i++;
                } else { // Si no es el primero , agrega la capacidad
                    var color = val;
                    var colorParsed = color.replace(/\s+/g, '-').toLowerCase();

                    var htmlString = crearHTMLColor(val, i, colorParsed);
                    displayColores(htmlString);
                    i++;
                }
            }
        }
    }
}



// jsonPhp[0].capacidad['32 GB'][0].color
function tamañoMatcher(color, index) {

    var i = 0;
    colorModeloSeleccionado = color;
    for (var val in jsonPhp[index].color[color]) {
        if (i == 0) {
            // Borra los elementos de color previamente mostrados cuando se selecciona otra capacidad
            jQuery(".tamaño-watch").fadeOut().remove();
            var tamaño = jsonPhp[index].color[color][val].tamaño;

            var htmlString = crearHTMLTamaño(tamaño, i);
            jQuery("#tamaño ul").append(htmlString);
            i++;

        } else {
            var tamaño = jsonPhp[index].color[color][val].tamaño;

            var htmlString = crearHTMLTamaño(tamaño, i);
            jQuery("#tamaño ul").append(htmlString);
            i++;
        }

    }

}


function precioMatcher(tamaño, index, color) {

    var i = 0;
    for (var val in jsonPhp[index].color[color]) {
        if (jsonPhp[index].color[color][val].tamaño == tamaño) {
            if (i == 0) {
                jQuery(".precio-watch").remove();
                var precio = jsonPhp[index].color[color][val].precio;
                var precioPromocion = jsonPhp[index].color[color][val].precioPromocion;

                var htmlString = crearHTMLPrecio(precio, precioPromocion);
                jQuery("#precio ul").append(htmlString);
                i++;

            } else {
                var precio = jsonPhp[index].color[color][val].precio;
                var precioPromocion = jsonPhp[index].color[color][val].precioPromocion;
                var htmlString = crearHTMLPrecio(precio, precioPromocion);
                jQuery("#precio ul").append(htmlString);
                i++;
            }
        }

    }
}



displayModelos();
