
var indexModeloSeleccionado = 0;
var pantallaModeloSeleccionado;
var capacidadModeloSeleccionado;
var ramSeleccionada;
var imagenModeloSeleccionado;

console.log(jsonPhp);


// ESCONDER CIERTOS DIV
jQuery("#pantalla, #capacidad, #ram, #precio").hide();


function showNext(val, tipo, el, indexRam) { // El ultimo es id es para el index de la ram
    if (tipo == 'mac') {
        // Reseteamos el css de todos los labels de mac cuando se haga click en otro elemento
        jQuery(".modelo-mac").css("border", "1px solid rgba(136,136,136,.4)");
        var id = el.id;

        // cambiar imagen al seleccionar tipo de mac
        var str = val.replace(/\s/g, '');
        var imagen = imgPath + "/mac/" + str.toLowerCase() + ".png";
        
        // Si reseleccionamos mac quitar el field de color y de precio
        jQuery("#ram, #capacidad,#precio").fadeOut("fast");


        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        pantallaMatcher(val);
        var imagen = imagenModeloSeleccionado;
        jQuery("#imagen").fadeOut();
        setTimeout(function () { jQuery("#imagen").attr('src', imagen); }, 300);

        // solo mostrar cuando termina de cargar la imagen 
        jQuery("#imagen").on('load', function () {
            jQuery("#imagen").fadeIn();
        });

        jQuery("#pantalla").fadeIn("fast");

    } else if (tipo == 'pantalla') {

        var id = el.id;
        jQuery("#ram,#precio").fadeOut("fast");
        // Reseteamos el css de todos los labels de macs cuando se haga click en otro elemento
        jQuery(".pantalla-mac label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        pantallaModeloSeleccionado = val;
        capacidadMatcher(val, indexModeloSeleccionado);
        jQuery("#capacidad").fadeIn("fast");

    } else if (tipo == 'capacidad') {

        var id = el.id;
        // Reseteamos el css de todos los labels de macs cuando se haga click en otro elemento
        //console.log(val);
        jQuery("#precio").fadeOut("fast");
        jQuery(".capacidad-mac label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        //console.log(val);
        capacidadModeloSeleccionado = val;
        ramMatcher(pantallaModeloSeleccionado, capacidadModeloSeleccionado, indexModeloSeleccionado);
        jQuery("#ram").fadeIn("fast");

    } else if (tipo == 'ram') {
        var id = el.id;
        jQuery(".ram-mac label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        var ramSeleccionada = indexRam;
        //console.log(indexModeloSeleccionado, pantallaModeloSeleccionado, capacidadModeloSeleccionado, ramSeleccionada);
        precioMatcher(indexModeloSeleccionado, pantallaModeloSeleccionado, capacidadModeloSeleccionado, ramSeleccionada);
        jQuery("#precio").fadeIn("fast");
    } else if (tipo === 'cuotas') {
        var id = el.id;
        jQuery(".pagos > li > label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");

        var interes = (val === "1" ? 1 : (val === "3" ? 1.24 : (val === "6" ? 1.36 : 1.40)));

        var nuevoPrecio = parseInt(indexRam * interes / val);
        var textoCuotas = `Pago en ${val} cuotas de`;
        var textoEfectivo = 'Precio de contado';

        var textoRendered = val === "1" ? textoEfectivo : textoCuotas;

        jQuery(".precio-box > span:first-child").text(textoRendered);
        jQuery(".precio-box > span:nth-child(2)").text('$' + nuevoPrecio);
    }

}



function crearHTMLModelo(mac, id) {

    htmlString = `
        <li>
            <label for="mac${id}" class="box modelo-mac mac${id}">
            
                            <span>${mac}</span>
                            <input id="mac${id}" name="mac" type="radio" class="radio" value="${mac}" onclick="showNext(this.value, this.name,this)"/>
        
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLPantalla(pantalla, id) {

    htmlString = `
        <li class="pantalla-mac">
            <label for="pantalla${id}" class="box pantalla${id}">    
                            <span>${pantalla}</span>
                            <input id="pantalla${id}" name="pantalla" class="radio" type="radio" value="${pantalla}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLCapacidad(capacidad, id) {

    htmlString = `
        <li class="capacidad-mac">
            <label for="capacidad${id}" class="box capacidad${id}">  
                            <span>${capacidad}</span>
                            <input id="capacidad${id}" name="capacidad" class="radio" type="radio" value="${capacidad}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLRam(ram, id) {

    htmlString = `
        <li class="ram-mac">
            <label for="ram${id}" class="box ram${id}">  
                            <span>${ram}</span>
                            <input id="ram${id}" name="ram" class="radio" type="radio" value="${ram}" onclick="showNext(this.value,this.name,this,${id})"/>
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLPrecio(precio,promocion) {

    
    var currency = "$";

    var promocionString = promocion == 0 || null ? `<span>${currency}${precio}</span>` : `<span class="precio-tachado">${currency}${precio}</span><span class="precio-promocion">  ${currency}${promocion}</span>`;
        var precioFinal = promocion == 0 || null ? precio : promocion;
        var tituloPromocion = promocion == 0 || null ? 'Precio de contado' : 'PROMOCION!!';

    htmlString = `
        <li class="precio-mac">
            <label for="precio" class="precio-box">
                            <span>${tituloPromocion}</span> 
                            `
    htmlString += promocionString;
    htmlString +=  `   
                    <input id="precio" name="precio" class="radio" type="radio" value="${precioFinal}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLCuotas(soloEfectivo, precio,promocion) {
    var precioFinal = promocion == 0 ? precio : promocion;
    if (soloEfectivo) {
        htmlString = `
            <ul class="pagos">
                <li id="solo-efectivo">
                    <label for="cuotas1" class="cuotas cuotas1">    
                        <span>Solo Contado</span>
                        <input id="cuotas1" name="cuotas" class="radio" type="radio" value="1" onclick="showNext(this.value,this.name,this,${precioFinal})"/>
                    </label>
                </li>
            </ul>
            `;

        return htmlString;
    } else {
        htmlString = `
            <ul class="pagos">
                    <li>
                        <label for="cuotas1" class="cuotas cuotas1">    
                            <span>Contado</span>
                            <input id="cuotas1" name="cuotas" class="radio" type="radio" value="1" onclick="showNext(this.value,this.name,this,${precioFinal})"/>
                        </label>
                    </li>
                    <li>
                        <label for="cuotas2" class="cuotas cuotas2">    
                            <span>3 Cuotas</span>
                            <input id="cuotas2" name="cuotas" class="radio" type="radio" value="3" onclick="showNext(this.value,this.name,this,${precioFinal})"/>
                        </label>
                    </li>
                    <li>
                        <label for="cuotas3" class="cuotas cuotas3">    
                            <span>6 Cuotas</span>
                            <input id="cuotas3" name="cuotas" class="radio" type="radio" value="6" onclick="showNext(this.value,this.name,this,${precioFinal})"/>
                        </label>
                    </li>
                    <li>
                        <label for="cuotas4" class="cuotas cuotas4">    
                            <span>12 Cuotas</span>
                            <input id="cuotas4" name="cuotas" class="radio" type="radio" value="12" onclick="showNext(this.value,this.name,this,${precioFinal})"/>
                        </label>
                    </li>
            </ul>
            `;
        return htmlString;
    }



}

function displayModelos() {
    var i = 0;
    for (var property in jsonPhp) {
        if (jsonPhp.hasOwnProperty(property)) {

            // ELIGE TU MODELO
            // obtenemos variable para el html
            var mac = jsonPhp[property].modelo;
            // aplicamos la funcion creada con el template para insertarlo en el html
            var htmlString = crearHTMLModelo(mac, i);
            jQuery("#modelo ul").append(htmlString);
            i++;
        }
    }
}

function displayPantallas(htmlString) {
    jQuery("#pantalla ul").append(htmlString);
}

// La funcion hace display de la seccion capacidades para el producto seleccionado
function pantallaMatcher(value) {

    // iteramos en los distintos index del objeto
    for (var property in jsonPhp) {


        // Chequeamos si el valor pasado a la funcion desde el radio button coincide con el modelo de celular en ese index - si coincide proseguimos
        if (jsonPhp[property].modelo == value) {
            // Guardamos el modelo seleccionado para hacer query de la capacidad , ram y precio
            indexModeloSeleccionado = property;
            // Seteamos una variable para que en la iteracion , si es el primer elemento iterado ( i == 0) borre los datos anteriores
            var i = 0;

            imagenModeloSeleccionado = jsonPhp[indexModeloSeleccionado].imagen;

            // iteramos en las capacidades del modelo matcheado
            for (var val in jsonPhp[property].pantalla) {
                if (i == 0) {
                    //Borra los datos anteriores
                    jQuery(".pantalla-mac").fadeOut().remove();
                    var htmlString = crearHTMLPantalla(val, i);
                    displayPantallas(htmlString);
                    i++;
                } else { // Si no es el primero , agrega la capacidad
                    var htmlString = crearHTMLPantalla(val, i);
                    displayPantallas(htmlString);
                    i++;
                }
            }
        }
    }
}


// jsonPhp[0].pantalla["13.3 Retina"]["128 GB"][0]
function capacidadMatcher(pantalla, index) {

    var i = 0;
    for (var val in jsonPhp[index].pantalla[pantalla]) {
        if (i == 0) {
            // console.log(val); Muestra por ejemplo 128 GB y 256 GB

            // En caso de que se seleccione otra pantalla borra las capacidades mostradas previas
            jQuery(".capacidad-mac").fadeOut().remove();
            var capacidadModeloSeleccionado = val;
            var capacidad = val;
            var htmlString = crearHTMLCapacidad(capacidad, i);
            jQuery("#capacidad ul").append(htmlString);

            i++;


        } else {

            var capacidad = val;
            var capacidadModeloSeleccionado = val;
            var htmlString = crearHTMLCapacidad(capacidad, i);
            jQuery("#capacidad ul").append(htmlString);
            i++;

        }

    }

}
//jsonPhp[0].pantalla["13.3 Retina"]["128 GB"][0].ram
function ramMatcher(pantalla, capacidad, index) {
    //console.log(pantalla);
    var i = 0;
    var ramExistentes = [];
    for (var val in jsonPhp[index].pantalla[pantalla][capacidad]) {
        if (i == 0) {
            var ram = jsonPhp[index].pantalla[pantalla][capacidad][val].ram;
            ramExistentes.push(ram);
            //console.log(val);


            // En caso de que se seleccione otra capacidad borra las ram mostradas previas
            jQuery(".ram-mac").remove();

            var htmlString = crearHTMLRam(ram, i);
            jQuery("#ram ul").append(htmlString);
            i++;
        } else {
            var ram = jsonPhp[index].pantalla[pantalla][capacidad][val].ram;
            if (!ramExistentes.includes(ram)) {
                //console.log(val);

                var htmlString = crearHTMLRam(ram, i);
                jQuery("#ram ul").append(htmlString);
                i++;
            }
        }


    }

}

function precioMatcher(index, pantalla, capacidad, ramIndex) {

    var i = 0;
    //console.log(capacidad);

    var precio = jsonPhp[index].pantalla[pantalla][capacidad][ramIndex].precio;
    var precioPromocion = jsonPhp[index].pantalla[pantalla][capacidad][ramIndex].precioPromocion;
    var soloEfectivo = jsonPhp[index].pantalla[pantalla][capacidad][ramIndex].soloEfectivo;

    jQuery(".precio-mac, .pagos").remove();


    var htmlString = crearHTMLPrecio(precio, precioPromocion);
    var htmlString2 = crearHTMLCuotas(soloEfectivo, precio, precioPromocion);
    jQuery("#precio > ul").append(htmlString);
    jQuery("#precio > ul").prepend(htmlString2);
    i++;



}



displayModelos();
