var indexModeloSeleccionado = 0;
var capacidadModeloSeleccionado;
console.log(jsonPhp);

// ESCONDER CIERTOS DIV
jQuery("#cuotas, #precio").hide();


function cargarImagen(link, modelo) {
    var img = new Image();
    jQuery(img).load(function() {
        console.log(`imagen de ${modelo} cargada`);
    }).attr('src', link);
}


function iteradorLoaderImagenes() {
    for (var property in jsonPhp) {
        if (jsonPhp.hasOwnProperty(property)) {
            var iphone = jsonPhp[property].modelo;
            var str = iphone.replace(/\s/g, '');
            var nombreModelo = str.toLowerCase();

            for (var val in jsonPhp[property].capacidad) {
                for (var key in jsonPhp[property].capacidad[val]) {
                    var str2 = jsonPhp[property].capacidad[val][key].color;
                    var color = str2.toLowerCase();
                    var color = color.replace(/\s/g, '');
                    var nombreImagen = nombreModelo + color;
                    cargarImagen(`${imgPath}/iphone/${nombreImagen}.png`, nombreImagen);
                }
            }
        }
    }
}

iteradorLoaderImagenes();

// Creamos una funcion para mostrar color y capacidad al cargar la pagina , con opacidad baja
function mostrarDefault() {
    // Seleccionamos el primer modelo y lo agregamos a una variable para usar en capacidad Matcher
    var iphoneDefault = jsonPhp[0].modelo;

    // Seleccionamos las capacidades disponibles para mostrar en colorMatcher
    var capacidades = jsonPhp[0].capacidad;
    // Iteramos en las capacidades del primer modelo para pasar variable a colorMatcher
    for (var capacidad in capacidades) {
        var capacidadDefault = capacidad;
    }
    capacidadMatcher(iphoneDefault);
    colorMatcher(capacidadDefault, 0);

    // Mostramos capacidad y color con opacidad baja
    jQuery("#capacidad, #color").css('opacity', '0.20');

    // Desactivamos el link para que no se pueda hacer click en las capacidades y colores hasta que se seleccione el modelo
    jQuery("#capacidad ul li label, #color ul li label").css('pointer-events', 'none');

}

mostrarDefault();

var tituloDefault = jsonPhp[1] !== undefined ? jsonPhp[0].modelo + ", " + jsonPhp[1].modelo : jsonPhp[0].modelo;


function cambiarTituloPaginaIphone(iphone) {
    jQuery(".titulo-pagina .container > h1").text(iphone);
}

cambiarTituloPaginaIphone(tituloDefault);

function cambiarTextoBotonPaginaIphone() {
    jQuery("#texto-boton-caracteristicas").text("caracteristicas").css("width", "100%").css("font-size", "15px");
}

function showNext(val, tipo, el, precio) {
    if (tipo == 'iphone') {
        // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
        jQuery(".modelo-iphone").css("border", "1px solid rgba(136,136,136,.4)");
        var id = el.id;
        iPhoneSeleccionado = val;
        cambiarTituloPaginaIphone(val);
        cambiarTextoBotonPaginaIphone();
        iPhoneSeleccionadoSinEspacios = val.replace(/\s+/g, '').toLowerCase();
        // carga las caracteristicas del iphone seleccionado
        caracteristicasMatcher(iPhoneSeleccionadoSinEspacios);
        // Si reseleccionamos iphone quitar el field de color y de precio
        jQuery("#precio,#color").fadeOut("fast");
        jQuery("#capacidad").css('opacity', '1');
        jQuery(".boton-caracteristicas").css('opacity', '1');
        jQuery(".boton-caracteristicas").css('pointer-events', 'auto');

        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        capacidadMatcher(val);
        jQuery("#capacidad").fadeIn("fast");

    } else if (tipo == 'capacidad') {

        var id = el.id;
        jQuery("#precio,#color").fadeOut("fast");
        // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
        jQuery(".capacidad-iphone label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");
        jQuery("#color").css('opacity', '1');
        colorMatcher(val, indexModeloSeleccionado);
        jQuery("#color").fadeIn("fast");

    } else if (tipo == 'color') {

        var id = el.id;
        // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
        jQuery(".color-iphone label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");

        // Cambiamos imagen al cambiar color de iphone
        var str1 = iPhoneSeleccionado.replace(/\s/g, '');
        var str2 = val.replace(/\s/g, '');
        var imagen = imgPath + "/iphone/" + str1.toLowerCase() + str2.toLowerCase() + ".png";
        jQuery("#imagen").fadeOut();
        setTimeout(function() { jQuery("#imagen").attr('src', imagen); }, 300);

        // solo mostrar cuando termina de cargar la imagen 
        jQuery("#imagen").on('load', function() {
            jQuery("#imagen").fadeIn();
        });

        jQuery("#imagen").attr('alt', iPhoneSeleccionado + " " + str2);

        precioMatcher(val, indexModeloSeleccionado, capacidadModeloSeleccionado);
        jQuery("#precio").fadeIn("fast");

    } else if (tipo === 'cuotas') {
        var id = el.id;
        jQuery(".pagos > li > label").css("border", "1px solid rgba(136,136,136,.4)");
        jQuery("." + id).css("border", "1.5px solid #5e9bff");

        var interes = (val === "1" ? 1 : (val === "12" ? cuotas12 : cuotas18)); // cuotas12/cuotas18 se obtienen desde category.php

        var nuevoPrecio = parseInt(precio * interes / val);
        var textoCuotas = `Pago en ${val} cuotas de`;
        var textoEfectivo = 'Precio de contado';

        var textoRendered = val === "1" ? textoEfectivo : textoCuotas;

        // Si se selecciona la cuota se borra el texto tachado de la promocion (pero el valor de la cuota corresponde a la promocion)
        jQuery(".precio-tachado").css('text-decoration', 'none');
        jQuery(".precio-tachado").css('color', 'black');
        jQuery(".precio-promocion").hide();

        jQuery(".precio-box > span:first-child").text(textoRendered);
        jQuery(".precio-box > span:nth-child(2)").text(currency + nuevoPrecio); // currency se obtiene de category.php
    }

}


function crearHTMLModelo(iphone, id) {

    htmlString = `
        <li>
            <label for="iphone${id}" class="box modelo-iphone iphone${id}">
            
                            <span>${iphone}</span>
                            <input id="iphone${id}" name="iphone" type="radio" class="radio" value="${iphone}" onclick="showNext(this.value, this.name,this)"/>
                            <span class="en-stock">EN STOCK</span>
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLCapacidad(capacidad, id) {

    htmlString = `
        <li class="capacidad-iphone">
            <label for="capacidad${id}" class="box capacidad${id}">    
                            <span>${capacidad}</span>
                            <input id="capacidad${id}" name="capacidad" class="radio" type="radio" value="${capacidad}" onclick="showNext(this.value,this.name,this)"/>
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
                            <input id="color${id}" name="color" class="radio" type="radio" value="${color}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
    return htmlString;

}

function crearHTMLPrecio(precio, promocion,link) {


    var promocionString = promocion == 0 || promocion == null ? `<span>$${precio}</span>` : `<span class="precio-tachado">$${precio}</span><span class="precio-promocion">  $${promocion}</span>`;
    var precioFinal = promocion == 0 || promocion == null ? precio : promocion;
    var tituloPromocion = promocion == 0 || promocion == null ? 'Precio de contado' : 'PROMOCION!!';
    htmlString = `
        <li class="precio-iphone">
            <label for="precio" class="precio-box">
                            <span>${tituloPromocion}</span>   
                            
                            `
    htmlString += promocionString;
    htmlString += `
                            
                            <input id="precio" name="precio" class="radio" type="radio" value="${precioFinal}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
    htmlString += ` <li id="boton-comprar__container">  
                        <a class="boton-comprar__boton" href="${link}">COMPRAR!</a> 
                    </li>
                    `

    return htmlString;

}

function crearHTMLCuotas(soloEfectivo, precio, promocion) {
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
                            <span>12 Cuotas</span>
                            <input id="cuotas2" name="cuotas" class="radio" type="radio" value="12" onclick="showNext(this.value,this.name,this,${precioFinal})"/>
                        </label>
                    </li>
                    <li>
                        <label for="cuotas3" class="cuotas cuotas3">    
                            <span>18 Cuotas</span>
                            <input id="cuotas3" name="cuotas" class="radio" type="radio" value="18" onclick="showNext(this.value,this.name,this,${precioFinal})"/>
                        </label>
                    </li>`;
        htmlString += `</ul>`;
        return htmlString;
    }



}

// La funcion es para reemplazar los '\n' del json y reemplazarlos por un nuevo parrafo en HTML (</p><p>) y quita guiones
function backslashAParrafo(str) {
    str2 = str.replace(/\n/gm, '</p><p>');
    return quitaGuiones(str2);
}

function quitaGuiones(str) {
    return str.replace(/-/gm, '');
}

function comaAParrafo(str) {
    return str.replace(/,/gm, '</p><p>');
}

function crearHTMLCaracteristicas(iphone) {
    if (iphones[iphone]) {
        htmlString = `
        <div class="caracteristica">
            <h1>Tamaño y Peso</h1>
            <p>${iphones[iphone].tamano.dimensiones}</p>
            <p>${iphones[iphone].tamano.peso}</p>
        </div>
        <div class="caracteristica">
            <h1>Display (Pantalla)</h1>
            <p>${iphones[iphone].display.tipo}</p>
            <p>${iphones[iphone].display.tamano}</p>
            <p>${backslashAParrafo(iphones[iphone].display.otros)}</p>
        </div>
        <div class="caracteristica">
            <h1>Chip (procesador)</h1>
            <p>${iphones[iphone].plataforma.procesador}</p>
        </div>
        <div class="caracteristica">
            <h1>Camara Trasera</h1>
            <p>${comaAParrafo(iphones[iphone].camara.principal)}</p>
            <p>${comaAParrafo(iphones[iphone].camara.funciones)}</p>
        </div>
        <div class="caracteristica">    
            <h1>Camara Frontal</h1>
            <p>${comaAParrafo(iphones[iphone].camara.frontal)}</p>
        </div>
        <div class="caracteristica">    
            <h1>Grabación de Video</h1>
            <p>${comaAParrafo(iphones[iphone].camara.video)}</p>
        </div>`;
        return htmlString;
    } else {
        return "No se puede cargar la información de este iphone";
    }

}

function caracteristicasMatcher(iphone) {
    var htmlString = crearHTMLCaracteristicas(iphone);
    jQuery(".caracteristicas").empty();
    jQuery(".caracteristicas").append(htmlString);
}



function displayModelos() {
    var i = 0;

    // Creamos un array que va a almacenar todos los iphones disponibles para mostrarlos en el .titulo-pagina h1
    var tituloPagina = [];
    var titulo = "";

    for (var property in jsonPhp) {
        if (jsonPhp.hasOwnProperty(property)) {

            // ELIGE TU MODELO
            // obtenemos variable para el html
            var iphone = jsonPhp[property].modelo;
            tituloPagina.push(iphone);
            // aplicamos la funcion creada con el template para insertarlo en el html
            var htmlString = crearHTMLModelo(iphone, i);
            jQuery("#modelo ul").append(htmlString);
            i++;
        }
    }

    for (var i = 0; i < tituloPagina.length; i++) {
        if (i == tituloPagina.length - 1) {
            titulo += tituloPagina[i];
        } else {
            titulo += tituloPagina[i] + ", ";
        }
    }
    cambiarTituloPaginaIphone(titulo);
}

function displayCapacidades(htmlString) {
    jQuery("#capacidad ul").append(htmlString);
}

// La funcion hace display de la seccion capacidades para el producto seleccionado
function capacidadMatcher(value) {

    // iteramos en los distintos index del objeto
    for (var property in jsonPhp) {


        // Chequeamos si el valor pasado a la funcion desde el radio button coincide con el modelo de celular en ese index - si coincide proseguimos
        if (jsonPhp[property].modelo == value) {
            // Guardamos el modelo seleccionado para hacer query del color y precio 
            indexModeloSeleccionado = property;
            // Seteamos una variable para que en la iteracion , si es el primer elemento iterado ( i == 0) borre los datos anteriores
            var i = 0;

            // iteramos en las capacidades del modelo matcheado
            for (var val in jsonPhp[property].capacidad) {
                if (i == 0) {
                    //Borra los datos anteriores
                    jQuery(".capacidad-iphone").fadeOut().remove();
                    var htmlString = crearHTMLCapacidad(val, i);
                    displayCapacidades(htmlString);
                    i++;
                } else { // Si no es el primero , agrega la capacidad
                    var htmlString = crearHTMLCapacidad(val, i);
                    displayCapacidades(htmlString);
                    i++;
                }
            }
        }
    }
}



// jsonPhp[0].capacidad['32 GB'][0].color
function colorMatcher(capacidad, index) {

    var i = 0;
    capacidadModeloSeleccionado = capacidad;
    for (var val in jsonPhp[index].capacidad[capacidad]) {
        if (i == 0) {
            // Borra los elementos de color previamente mostrados cuando se selecciona otra capacidad
            jQuery(".color-iphone").fadeOut().remove();
            var color = jsonPhp[index].capacidad[capacidad][val].color;

            var colorParsed = color.replace(/\s+/g, '-').toLowerCase();
            var htmlString = crearHTMLColor(color, i, colorParsed);
            jQuery("#color ul").append(htmlString);
            i++;

        } else {
            var color = jsonPhp[index].capacidad[capacidad][val].color;
            // Color-id para hacer el circulo con el color en el input , pasamos una clase por ejemplo rose-gold y esa matchea con el css
            var colorParsed = color.replace(/\s+/g, '-').toLowerCase();
            var htmlString = crearHTMLColor(color, i, colorParsed);
            jQuery("#color ul").append(htmlString);
            i++;
        }

    }

}


function precioMatcher(color, index, capacidad) {

    var i = 0;
    for (var val in jsonPhp[index].capacidad[capacidad]) {
        if (jsonPhp[index].capacidad[capacidad][val].color == color) {
            if (i == 0) {
                jQuery(".precio-iphone, .pagos, #boton-comprar__container").remove();
                var precio = jsonPhp[index].capacidad[capacidad][val].precio;
                var promocion = jsonPhp[index].capacidad[capacidad][val].precioPromocion;
                var soloEfectivo = jsonPhp[index].capacidad[capacidad][val].soloEfectivo;
                
                var link = jsonPhp[index].capacidad[capacidad][val].link;

                var htmlString = crearHTMLPrecio(precio, promocion,link);
                var htmlString2 = crearHTMLCuotas(soloEfectivo, precio, promocion);
                jQuery("#precio > ul").append(htmlString);
                jQuery("#precio > ul").prepend(htmlString2);
                i++;

            } else {
                var precio = jsonPhp[index].capacidad[capacidad][val].precio;
                var promocion = jsonPhp[index].capacidad[capacidad][val].precioPromocion;
                var soloEfectivo = jsonPhp[index].capacidad[capacidad][val].soloEfectivo;

                var htmlString = crearHTMLPrecio(precio, promocion);
                var htmlString2 = crearHTMLCuotas(soloEfectivo, precio, promocion);
                jQuery("#precio > ul").append(htmlString);
                jQuery("#precio > ul").prepend(htmlString2);
                i++;
            }
        }
    }
}



displayModelos();