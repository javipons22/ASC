
var indexModeloSeleccionado = 0;
var capacidadModeloSeleccionado;

// ESCONDER CIERTOS DIV
jQuery("#capacidad, #color, #cuotas, #precio").hide();

    
    function showNext(val,tipo,el){
        if (tipo == 'iphone'){
            // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
            jQuery(".modelo-iphone").css("border","1px solid rgba(136,136,136,.9)");
            var id = el.id;
            // Si reseleccionamos iphone quitar el field de color y de precio
            jQuery("#precio").fadeOut("fast");
            jQuery("#color").fadeOut("fast");
            

            jQuery("." + id).css("border","1.5px solid #5e9bff");
            capacidadMatcher(val);
            jQuery("#capacidad").fadeIn("fast"); 

        } else if (tipo == 'capacidad'){

            var id = el.id;
            jQuery("#precio").fadeOut("fast");
            // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
            jQuery(".capacidad-iphone label").css("border","1px solid rgba(136,136,136,.9)");
            jQuery("." + id).css("border","1.5px solid #5e9bff");
            colorMatcher(val, indexModeloSeleccionado);
            jQuery("#color").fadeIn("fast");

        } else if (tipo == 'color'){

            var id = el.id;
               // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
            
            jQuery(".color-iphone label").css("border","1px solid rgba(136,136,136,.9)");
            jQuery("." + id).css("border","1.5px solid #5e9bff");
            precioMatcher(val,indexModeloSeleccionado, capacidadModeloSeleccionado);
            jQuery("#precio").fadeIn("fast");

        }
        
    }

   

    function crearHTMLModelo(iphone,id) {

        htmlString =`
        <li>
            <label for="iphone${id}" class="box modelo-iphone iphone${id}">
            
                            <span>${iphone}</span>
                            <input id="iphone${id}" name="iphone" type="radio" class="radio" value="${iphone}" onclick="showNext(this.value, this.name,this)"/>
        
            </label>
        </li>`;
        return htmlString;

    }

    function crearHTMLCapacidad(capacidad,id) {

        htmlString =`
        <li class="capacidad-iphone">
            <label for="capacidad${id}" class="box capacidad${id}">    
                            <span>${capacidad}</span>
                            <input id="capacidad${id}" name="capacidad" class="radio" type="radio" value="${capacidad}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
        return htmlString;

    }

    function crearHTMLColor(color,id,colorClase) {

        htmlString =`
        <li class="color-iphone">
            <label for="color${id}" class="box color${id}">
                            <div class="${colorClase} circulo-color"></div>    
                            <span>${color}</span>
                            <input id="color${id}" name="color" class="radio" type="radio" value="${color}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
        return htmlString;

    }

    function crearHTMLPrecio(precio) {

        htmlString =`
        <li class="precio-iphone">
            <label for="precio" class="box precio-box">   
                            <span>$${precio}</span>
                            <input id="precio" name="precio" class="radio" type="radio" value="${precio}" onclick="showNext(this.value,this.name,this)"/>
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
                jQuery( "#modelo ul" ).append( htmlString );
                i++;
            }
        }
    }

    function displayCapacidades(htmlString) {
        jQuery( "#capacidad ul" ).append( htmlString );
    }
    
    // La funcion hace display de la seccion capacidades para el producto seleccionado
    function capacidadMatcher(value) {

        // iteramos en los distintos index del objeto
        for (var property in jsonPhp){


            // Chequeamos si el valor pasado a la funcion desde el radio button coincide con el modelo de celular en ese index - si coincide proseguimos
            if (jsonPhp[property].modelo == value){
                // Guardamos el modelo seleccionado para hacer query del color y precio 
                indexModeloSeleccionado = property;
                // Seteamos una variable para que en la iteracion , si es el primer elemento iterado ( i == 0) borre los datos anteriores
                var i = 0;

                // iteramos en las capacidades del modelo matcheado
                for (var val in jsonPhp[property].capacidad){
                    if (i == 0) {
                        //Borra los datos anteriores
                        jQuery(".capacidad-iphone").fadeOut().remove();
                        var htmlString = crearHTMLCapacidad(val,i);
                        displayCapacidades(htmlString);
                        i++;
                    } else { // Si no es el primero , agrega la capacidad
                        var htmlString = crearHTMLCapacidad(val,i);
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
                var htmlString = crearHTMLColor(color,i,colorParsed);
                jQuery( "#color ul" ).append( htmlString );
                i++;

            } else {
                var color = jsonPhp[index].capacidad[capacidad][val].color;
                // Color-id para hacer el circulo con el color en el input , pasamos una clase por ejemplo rose-gold y esa matchea con el css
                var colorParsed = color.replace(/\s+/g, '-').toLowerCase();
                var htmlString = crearHTMLColor(color, i ,colorParsed);
                jQuery( "#color ul" ).append( htmlString );
                i++;
            }
            
        }

    }


    function precioMatcher(color, index, capacidad) {

        var i = 0;
        for (var val in jsonPhp[index].capacidad[capacidad]) {
            if(jsonPhp[index].capacidad[capacidad][val].color == color){
                    if (i == 0) {
                    jQuery(".precio-iphone").remove();
                    var precio = jsonPhp[index].capacidad[capacidad][val].precio;

                    var htmlString = crearHTMLPrecio(precio);
                    jQuery( "#precio ul" ).append( htmlString );
                    i++;

                } else {
                    var precio = jsonPhp[index].capacidad[capacidad][val].precio;

                    var htmlString = crearHTMLPrecio(precio);
                    jQuery( "#precio ul" ).append( htmlString );
                    i++;
                }
            }
            
        }
    }

    

    displayModelos();
