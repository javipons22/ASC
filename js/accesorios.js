
var indexModeloSeleccionado = 0;
var imagenModeloSeleccionado;


console.log(jsonPhp);

// ESCONDER CIERTOS DIV
jQuery("#pantalla, #capacidad, #ram, #precio").hide();

    
    function showNext(val,tipo,el){ // El ultimo es id es para el index de la ram
        if (tipo == 'accesorio'){
            // Reseteamos el css de todos los labels de mac cuando se haga click en otro elemento
            jQuery(".modelo-accesorio").css("border","1px solid rgba(136,136,136,.4)");
            var id = el.id;

            
            
            // Si reseleccionamos mac quitar el field de color y de precio
            
            precioMatcher(id);
            var imagen = imagenModeloSeleccionado;

            jQuery("#imagen").fadeOut();
            setTimeout(function(){ jQuery("#imagen").attr('src', imagen); }, 300);

            // solo mostrar cuando termina de cargar la imagen 
            jQuery("#imagen").on('load', function(){
                jQuery("#imagen").fadeIn();
            });

            jQuery("." + id).css("border","1.5px solid #5e9bff");
            //pantallaMatcher(val);
            jQuery("#precio").fadeIn("fast");
        } 

    }

   

    function crearHTMLModelo(accesorio,id) {

        htmlString =`
        <li>
            <label for="${id}" class="box modelo-accesorio ${id}">
            
                            <span>${accesorio}</span>
                            <input id="${id}" name="accesorio" type="radio" class="radio" value="${accesorio}" onclick="showNext(this.value, this.name,this)"/>
        
            </label>
        </li>`;
        return htmlString;

    }

    function crearHTMLPrecio(precio) {

        htmlString =`
        <li class="precio-iphone">
            <label for="precio" class="precio-box">
                            <span>Precio de contado </span>   
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
                var i = property;
                // ELIGE TU MODELO
                // obtenemos variable para el html
                var accesorio = jsonPhp[property].accesorio;
                // aplicamos la funcion creada con el template para insertarlo en el html
                var htmlString = crearHTMLModelo(accesorio, i);
                jQuery( "#modelo ul" ).append( htmlString );
                i++;
            }
        }
    }



    function precioMatcher(index) {

        var i = 0;
        //console.log(capacidad);
        
        imagenModeloSeleccionado = jsonPhp[index].imagen;
        var precio = jsonPhp[index].precio;
        
        jQuery(".precio-iphone").remove();
        

        var htmlString = crearHTMLPrecio(precio);
        jQuery( "#precio ul" ).append( htmlString );
        i++;
        
        
        
    }

    

    displayModelos();
