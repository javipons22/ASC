var iphoneSeleccionado;
var servicioSeleccionado;

function crearHTMLIphone(iphone) {
    var htmlString = `<option value='${iphone}'>${iphone}</option>`
    return htmlString;
}

function crearHTMLServicio(servicio) {
    var htmlString = `<option value='${servicio}'>${servicio}</option>`
    return htmlString;
}

function getServicios(element) {
    // Borramos servicios previos en caso de que se elija un iphone nuevo 
    jQuery('#servicio').empty();

    //Borramos el precio anterior en caso de seleccionar otro iphone
    document.getElementById('precio').placeholder = "Selecciona anteriores para ver precio";

    // Una vez que se borraron todos los servicios se borra el default por lo que al cambiar en linea 24 da error (esto evita el error porque agregamos el default de vuelta)
    document.getElementById("servicio").innerHTML = '<option value="" id="predeterminado" disabled selected>Selecciona Servicio</option>'

    // Activamos el select de servicio
    document.getElementById("servicio").removeAttribute("disabled");

    // Volvemos el select de servicio al default: "seleccione un servicio"
    document.getElementById("predeterminado").selected = true;

    iphoneSeleccionado = element.value;
    for (var k in jsonPhp[iphoneSeleccionado]) {
        var htmlServicio = crearHTMLServicio(k);
        jQuery('#servicio').append(htmlServicio);
    }
};

function getPrecio(element) {
    servicioSeleccionado = element.value;
    var precio = jsonPhp[iphoneSeleccionado][servicioSeleccionado];
    document.getElementById('precio').placeholder = `$${precio}`;
    document.getElementById('precio').value = precio;
}



for (var iphone in jsonPhp) {
    var htmlIphone = crearHTMLIphone(iphone)
    jQuery("#iphone").append(htmlIphone);
}