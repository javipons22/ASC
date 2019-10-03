
var indexModeloSeleccionado = 0;
var imagenModeloSeleccionado;
console.log(jsonPhp);

// ESCONDER CIERTOS DIV
jQuery("#capacidad, #tamaño, #precio").hide();

 
    function cargarImagen(link,modelo) {
        var img = new Image();
        jQuery(img).load(function(){
            console.log(`imagen de ${modelo} cargada`);
        }).attr('src',link);
    }


    function iteradorLoaderImagenes() {
        for (var property in jsonPhp) {
            if (jsonPhp.hasOwnProperty(property)) {
                var iphone = jsonPhp[property].modelo;
                var str = iphone.replace(/\s/g, '');
                var nombreModelo = str.toLowerCase();
                
                for (var val in jsonPhp[property].capacidad){
                    for (var key in jsonPhp[property].capacidad[val]){
                        var str2 = jsonPhp[property].capacidad[val][key].color;
                        var color = str2.toLowerCase();
                        var color = color.replace(/\s/g, '');
                        var nombreImagen = nombreModelo + color;
                        cargarImagen(`${imgPath}/iphone/${nombreImagen}.png`,nombreImagen);
                    }
                }    
            }
        }
    }

    //iteradorLoaderImagenes();
    
    function showNext(val,tipo,el){
        if (tipo == 'play'){
            // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
            jQuery(".modelo-play").css("border","1px solid rgba(136,136,136,.4)");
            var id = el.id;
            playSeleccionado = val;
          
            // Si reseleccionamos iphone quitar el field de color y de precio
            jQuery("#precio,#tamaño").fadeOut("fast");

            jQuery("." + id).css("border","1.5px solid #5e9bff");
            capacidadMatcher(val);
            var imagen = imagenModeloSeleccionado;
            
            jQuery("#imagen").fadeOut();
            setTimeout(function(){ jQuery("#imagen").attr('src', imagen); }, 300);

            // solo mostrar cuando termina de cargar la imagen 
            jQuery("#imagen").on('load', function(){
                jQuery("#imagen").fadeIn();
            });


            jQuery("#capacidad").fadeIn("fast"); 

        } else if (tipo == 'capacidad'){

            var id = el.id;
            // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
            jQuery(".capacidad-play label").css("border","1px solid rgba(136,136,136,.4)");
            jQuery("." + id).css("border","1.5px solid #5e9bff");


            precioMatcher(val, indexModeloSeleccionado);
            jQuery("#precio").fadeIn("fast");

        } else if (tipo == 'tamaño'){

            var id = el.id;
               // Reseteamos el css de todos los labels de iphone cuando se haga click en otro elemento
            jQuery(".tamaño-watch label").css("border","1px solid rgba(136,136,136,.4)");
            jQuery("." + id).css("border","1.5px solid #5e9bff");

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
            precioMatcher(val,indexModeloSeleccionado, colorModeloSeleccionado);
            jQuery("#precio").fadeIn("fast");

        }
        
    }

   

    function crearHTMLModelo(play,id) {

        htmlString =`
        <li>
            <label for="play${id}" class="box modelo-play play${id}">
            
                            <span>${play}</span>
                            <input id="play${id}" name="play" type="radio" class="radio" value="${play}" onclick="showNext(this.value, this.name,this)"/>
        
            </label>
        </li>`;
        return htmlString;

    }

    
   
    function crearHTMLCapacidad(capacidad,id) {

        htmlString =`
        <li class="capacidad-play">
            <label for="capacidad${id}" class="box capacidad${id}">    
                            <span>${capacidad}</span>
                            <input id="capacidad${id}" name="capacidad" class="radio" type="radio" value="${capacidad}" onclick="showNext(this.value,this.name,this)"/>
            </label>
        </li>`;
        return htmlString;

    }
    

    function crearHTMLPrecio(precio,promocion) {
        var promocionString = promocion == 0 || null ? `<span>$${precio}</span>` : `<span class="precio-tachado">$${precio}</span><span class="precio-promocion">  $${promocion}</span>`;
        var precioFinal = promocion == 0 || null ? precio : promocion;
        var tituloPromocion = promocion == 0 || null ? 'Precio de contado' : 'PROMOCION!!';
        htmlString =`
        <li class="precio-play">
            <label for="precio" class="precio-box">
                            <span>${tituloPromocion}</span> `
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
                var play = jsonPhp[property].modelo;
                // aplicamos la funcion creada con el template para insertarlo en el html
                var htmlString = crearHTMLModelo(play, i);
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
                imagenModeloSeleccionado = jsonPhp[property].imagen;

                // iteramos en las capacidades del modelo matcheado
                for (var val in jsonPhp[property].capacidad){
                    if (i == 0) {
                        //Borra los datos anteriores
                        jQuery(".capacidad-play").fadeOut().remove();
                        var capacidad = val;
                        var htmlString = crearHTMLCapacidad(capacidad,i);
                        displayCapacidades(htmlString);
                        i++;
                    } else { // Si no es el primero , agrega la capacidad
                     
                        var capacidad = val;
                        var htmlString = crearHTMLCapacidad(capacidad,i);
                        displayCapacidades(htmlString);
                        i++;
                    }   
                }
            }    
        }
    }

    

    // jsonPhp[0].capacidad['32 GB'][0].color
    function precioMatcher(capacidad, index) {
        
        var i = 0;
        for (var val in jsonPhp[index].capacidad[capacidad]) {
            if (i == 0) {
                // Borra los elementos de color previamente mostrados cuando se selecciona otra capacidad
                jQuery(".precio-play").fadeOut().remove();
                var precio = jsonPhp[index].capacidad[capacidad][val].precio;
                var precioPromocion = jsonPhp[index].capacidad[capacidad][val].precioPromocion;

                var htmlString = crearHTMLPrecio(precio,precioPromocion);
                jQuery( "#precio ul" ).append( htmlString );
                i++;

            } else {
                var precio = jsonPhp[index].capacidad[capacidad][val].precio;
                var precioPromocion = jsonPhp[index].capacidad[capacidad][val].precioPromocion;
                
                var htmlString = crearHTMLPrecio(precio,precioPromocion);
                jQuery( "#precio ul" ).append( htmlString );
                i++;
            }
            
        }

    }

    

    displayModelos();
