
var indexModeloSeleccionado = 0;
var capacidadModeloSeleccionado;
var iPadSeleccionado;
var colorSeleccionado;

console.log(jsonPhp);


// ESCONDER CIERTOS DIV
jQuery("#capacidad, #color, #precio").hide();

function cargarImagen(link) {
    var img = new Image();
    jQuery(img).load(function () {
        //console.log(`imagen de ${link} cargada`);
    }).attr('src', link);
}

function getModelo(ipad) {
    if (ipad.indexOf('10.2') !== -1) {
        return "ipad102";
    } else if (ipad.indexOf('3ra') !== -1) {
        return "ipad3";
    } else {
        return "";
    }
}


function iteradorLoaderImagenes() {
    for (var property in jsonPhp) {
        if (jsonPhp.hasOwnProperty(property)) {
            var ipad = jsonPhp[property].modelo;
            var nombreModelo = getModelo(ipad);
            // var str = iphone.replace(/\s/g, '');
            // var nombreModelo = str.toLowerCase();
            for (var val in jsonPhp[property].capacidad) {
                for (var key in jsonPhp[property].capacidad[val]) {
                    var str2 = jsonPhp[property].capacidad[val][key].color;
                    var color = str2.toLowerCase();
                    var color = color.replace(/\s/g, '');
                    var nombreImagen = nombreModelo + color;
                    cargarImagen(`${imgPath}/ipad/${nombreImagen}.png`, nombreImagen);
                }
            }
        }
    }
}

iteradorLoaderImagenes();

//showNext(this.value, this.name,this)
function showNext(val, tipo, el, colorIndex) { // El ultimo es id es para el index de la ram
    if (tipo == 'ipad') {
        // Reseteamos el css de todos los labels de mac cuando se haga click en otro elemento
        jQuery(".modelo-mac").css("border", "1px solid rgba(136,136,136,.4)");
        var id = el.id;

        // Obtenemos el nombre de modelo para la seccion color (cambiar imagen en color)
        iPadSeleccionado = getModelo(val);

        // Si reseleccionamos mac quitar el field de color y de precio
        jQuery("#color, #capacidad,#precio").fadeOut("fast");


        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        //console.log(val);
        capacidadMatcher(val);
        jQuery("#capacidad").fadeIn("fast");

    } else if (tipo == 'capacidad') {

        var id = el.id;
        jQuery("#color,#precio").fadeOut("fast");
        // Reseteamos el css de todos los labels de macs cuando se haga click en otro elemento
        jQuery(".pantalla-mac label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        
        // Se usa en el proximo else if ( aca reemplaza la variable global )
        capacidadModeloSeleccionado = val;
        //console.log(indexModeloSeleccionado)
        colorMatcher(val, indexModeloSeleccionado);
        jQuery("#color").fadeIn("fast");

    } else if (tipo == 'color') {
        var id = el.id;
        // Reseteamos el css de todos los labels de macs cuando se haga click en otro elemento
        jQuery("#precio").fadeOut("fast");
        jQuery(".color-iphone label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        
        // Cambiamos imagen al cambiar color de iphone
        var str1 = iPadSeleccionado.replace(/\s/g, '');
        var str2 = val.replace(/\s/g, '');
        var imagen = imgPath + "/ipad/" + str1.toLowerCase() + str2.toLowerCase() + ".png";
        jQuery("#imagen").fadeOut();
        setTimeout(function() { jQuery("#imagen").attr('src', imagen); }, 300);

        // solo mostrar cuando termina de cargar la imagen 
        jQuery("#imagen").on('load', function() {
            jQuery("#imagen").fadeIn();
        });


        precioMatcher(indexModeloSeleccionado, capacidadModeloSeleccionado, colorIndex);
        jQuery("#precio").fadeIn("fast");

    } else if (tipo === 'cuotas') {
        var id = el.id;
        jQuery(".pagos > li > label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");

        var interes = (val === "1" ? 1 : (val === "3" ? 1.24 : (val === "6" ? 1.36 : 1.40)));

        var nuevoPrecio = parseInt(colorIndex * interes / val);
        var textoCuotas = `Pago en ${val} cuotas de`;
        var textoEfectivo = 'Precio de contado';

        var textoRendered = val === "1" ? textoEfectivo : textoCuotas;

        jQuery(".precio-box > span:first-child").text(textoRendered);
        jQuery(".precio-box > span:nth-child(2)").text('$' + nuevoPrecio);
    }

}



function crearHTMLModelo(ipad, id) {

    htmlString = `
        <li>
            <label for="mac${id}" class="box modelo-mac mac${id}">
            
                            <span>${ipad}</span>
                            <input id="mac${id}" name="ipad" type="radio" class="radio" value='${ipad}' onclick="showNext(this.value, this.name,this)"/>
        
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLCapacidad(capacidad, id) {

    htmlString = `
        <li class="pantalla-mac">
            <label for="pantalla${id}" class="box pantalla${id}">    
                            <span>${capacidad}</span>
                            <input id="pantalla${id}" name="capacidad" class="radio" type="radio" value="${capacidad}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLColor(color, id, colorClase) {

    htmlString = `
        <li class="color-iphone">
            <label for="color${id}" class="box color${id}">
                            <div class="${colorClase} circulo-color"></div>    
                            <span>${color}</span>
                            <input id="color${id}" name="color" class="radio" type="radio" value='${color}' onclick="showNext(this.value,this.name,this,${id})"/>
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLPrecio(precio,promocion,dolares) {

    if(dolares) {
        var currency = "U$";
    } else {
        var currency = "$";
    }

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
    //var i = 0;
    for (var index in jsonPhp) {
        if (jsonPhp.hasOwnProperty(index)) {

            // ELIGE TU MODELO
            // obtenemos variable para el html
            var ipad = jsonPhp[index].modelo;
            //console.log(index);
            // aplicamos la funcion creada con el template para insertarlo en el html
            var htmlString = crearHTMLModelo(ipad, index);
            jQuery("#modelo ul").append(htmlString);
            //i++;
        }
    }
}

// La funcion hace display de la seccion capacidades para el producto seleccionado
function capacidadMatcher(value) {
    // iteramos en los distintos index del objeto
    for (var index in jsonPhp) {
        // Chequeamos si el valor pasado a la funcion desde el radio button coincide con el modelo de celular en ese index - si coincide proseguimos
        if (jsonPhp[index].modelo == value ){
            // Guardamos el modelo seleccionado para hacer query de la capacidad , ram y precio
            indexModeloSeleccionado = index;
            // Seteamos una variable para que en la iteracion , si es el primer elemento iterado ( i == 0) borre los datos anteriores
            var i = 0;

            // iteramos en las capacidades del modelo matcheado
            for (var val in jsonPhp[index].capacidad) {
                if (i == 0) {
                    //Borra los datos anteriores
                    jQuery(".pantalla-mac").fadeOut().remove();
                    var htmlString = crearHTMLCapacidad(val, i);
                    jQuery("#capacidad ul").append(htmlString);
                    i++;
                } else { // Si no es el primero , agrega la capacidad
                    var htmlString = crearHTMLCapacidad(val, i);
                    jQuery("#capacidad ul").append(htmlString);
                    i++;
                }
            }
        }
    }
}

// colorMatcher(val, indexModeloSeleccionado);
// jsonPhp[0].pantalla["13.3 Retina"]["128 GB"][0]
function colorMatcher(capacidad, index) {

    var firstClick = true;
    var i = 0;
    for (var val in jsonPhp[index].capacidad[capacidad]) {
        if (firstClick) {
            // console.log(val); Muestra por ejemplo 128 GB y 256 GB
            // En caso de que se seleccione otra pantalla borra las capacidades mostradas previas
            jQuery(".color-iphone").fadeOut().remove();
            //var capacidadModeloSeleccionado = val;
            //console.log(val);
            var color = jsonPhp[index].capacidad[capacidad][val].color;
            console.log(color);
            var colorParsed = color.replace(/\s+/g, '-').toLowerCase();
            var htmlString = crearHTMLColor(color, val, colorParsed);
            jQuery("#color ul").append(htmlString);
            i++;
            firstClick = false;
        } else {
            // var capacidadModeloSeleccionado = val;
            var color = jsonPhp[index].capacidad[capacidad][val].color;
            var colorParsed = color.replace(/\s+/g, '-').toLowerCase();
            var htmlString = crearHTMLColor(color, val, colorParsed);
            jQuery("#color ul").append(htmlString);
            i++;
        }
    }
}

//function precioMatcher(index, capacidad, color) {
function precioMatcher(index, capacidad, colorIndex) {

    var i = 0;
    //console.log(capacidad);

    var precio = jsonPhp[index].capacidad[capacidad][colorIndex].precio;
    var precioPromocion = jsonPhp[index].capacidad[capacidad][colorIndex].precioPromocion;
    var soloEfectivo = jsonPhp[index].capacidad[capacidad][colorIndex].soloEfectivo;
    var dolares = jsonPhp[index].capacidad[capacidad][colorIndex].dolares;

    jQuery(".precio-mac, .pagos").remove();


    var htmlString = crearHTMLPrecio(precio, precioPromocion,dolares);
    var htmlString2 = crearHTMLCuotas(soloEfectivo, precio, precioPromocion);
    jQuery("#precio > ul").append(htmlString);
    jQuery("#precio > ul").prepend(htmlString2);
    i++;
}



displayModelos();
