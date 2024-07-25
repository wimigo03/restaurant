var cont = 0;
let filas = parseInt(document.getElementById('filas').value) || 0;
let columnas = parseInt(document.getElementById('columnas').value) || 0;
let droppedInZone = false;

function getMesasPorZona(filas,columnas){
	var id = $("#zona_old_id").val();
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: 'GET',
		url: '/pedidos/get_mesas',
		data: {
			_token: CSRF_TOKEN,
			id: id
		},
		success: function(data){
            if(data.mesa_id_array){
                construirDivContainer(filas, columnas, data.mesa_id_array, data.mesa_ocupada_array, data.cantidad_sillas_array, data.titulo_array, data.estado_array);
            }else{
                construirDivContainerVacio();
            }
		},
		error: function(xhr){
			console.log(xhr.responseText);
		}
	});
}

function construirDivContainer(filas, columnas, mesaIdArray, mesaOcupadaArray, cantidadSillasArray, tituloArray, estadoArray)
    {
	const numFilas = filas;
	const numColumnas = columnas;

	const gridContainer = document.getElementById('grid-container');
	gridContainer.innerHTML = '';

	gridContainer.style.display = 'grid';
	gridContainer.style.gridTemplateColumns = `repeat(${numColumnas}, 1fr)`;
	gridContainer.style.gridAutoRows = 'minmax(10px, 1fr)';
	gridContainer.style.gridGap = '0px';

	if (!mesaOcupadaArray || mesaOcupadaArray.length === 0) {
		console.log('valor null o está vacío.');
	}else{
		dibujar_cuadros(numFilas, numColumnas, gridContainer, mesaIdArray, mesaOcupadaArray, cantidadSillasArray, tituloArray, estadoArray);
	}
}

function construirDivContainerVacio(){
	const numFilas = 1;
	const numColumnas = 1;

	const gridContainer = document.getElementById('grid-container');
	gridContainer.innerHTML = '';

	gridContainer.style.display = 'grid';
	gridContainer.style.gridTemplateColumns = `repeat(${numColumnas}, 1fr)`;
	gridContainer.style.gridAutoRows = 'minmax(10px, 1fr)';
	gridContainer.style.gridGap = '0px';
    dibujar_cuadros_vacios(numFilas, numColumnas, gridContainer);
}

function dibujar_cuadros_vacios(numFilas,numColumnas,gridContainer){
	for (let i = 1; i <= numFilas * numColumnas; i++) {
		const gridItem = document.createElement('div');
		gridItem.className = 'grid-item-container';
		gridItem.setAttribute('data-position', i);
		gridItem.setAttribute('ondrop', 'drop(event)');
		gridItem.setAttribute('ondragover', 'allowDrop(event)');
		gridContainer.appendChild(gridItem);
	}
}

function dibujar_cuadros(numFilas, numColumnas, gridContainer, mesaIdArray, mesaOcupadaArray, cantidadSillasArray, tituloArray, estadoArray){
	for (let i = 1; i <= numFilas * numColumnas; i++) {
		const gridItem = document.createElement('div');
		gridItem.className = 'grid-item-container';

		if (mesaOcupadaArray.includes(i.toString())) {
			const index = mesaOcupadaArray.indexOf(i.toString());
			const cantidadSillas = parseInt(cantidadSillasArray[index]);
			const titulo = tituloArray[index];
			const mesa_id = parseInt(mesaIdArray[index]);
            const estado = parseInt(estadoArray[index]);

            var input_mesa_id = document.createElement('input');
            input_mesa_id.type = 'hidden';
            input_mesa_id.name = 'mesa_id[]';
            input_mesa_id.id = 'mesa_id';
            input_mesa_id.value = mesa_id;

			const image = document.createElement('img');
            image.alt = 'Img';
			image.style.transform = 'scale(0.9)';
			image.setAttribute('draggable', 'false');
            image.style.cursor = 'pointer'

            switch (estado){
                case 1:
                    switch (cantidadSillas) {
                        case 1:
                            image.src = "/images/blanca_con_numero/una_silla.jpg";
                            break;
                        case 2:
                            image.src = "/images/blanca_con_numero/dos_sillas.jpg";
                            break;
                        case 3:
                            image.src = "/images/blanca_con_numero/tres_sillas.jpg";
                            break;
                        case 4:
                            image.src = "/images/blanca_con_numero/cuatro_sillas.jpg";
                            break;
                        case 5:
                            image.src = "/images/blanca_con_numero/cinco_sillas.jpg";
                            break;
                        case 6:
                            image.src = "/images/blanca_con_numero/seis_sillas.jpg";
                            break;
                        case 7:
                            image.src = "/images/blanca_con_numero/siete_sillas.jpg";
                            break;
                        case 8:
                            image.src = "/images/blanca_con_numero/ocho_sillas.jpg";
                            break;
                        default:
                            image.src = "/images/blanca_con_numero/mesa_default.png";
                            break;
                    }

                    image.onclick = function() {
                        //Recuperar y enviar datos para el pedido
                        getDatosParaPedido(mesa_id);
                        dibujarCuadros($("#zona_old_id").val());
                        abrirModalPedido();
                        $("#btn-pedido-pendiente").show();
                        $("#btn-pedido-cancelar").show();
                    };

                    break;

                case 2:
                    switch (cantidadSillas) {
                        case 1:
                            image.src = "/images/mesa_reservada/1.jpg";
                            break;
                        case 2:
                            image.src = "/images/mesa_reservada/2.jpg";
                            break;
                        case 3:
                            image.src = "/images/mesa_reservada/3.jpg";
                            break;
                        case 4:
                            image.src = "/images/mesa_reservada/4.jpg";
                            break;
                        case 5:
                            image.src = "/images/mesa_reservada/5.jpg";
                            break;
                        case 6:
                            image.src = "/images/mesa_reservada/6.jpg";
                            break;
                        case 7:
                            image.src = "/images/mesa_reservada/7.jpg";
                            break;
                        case 8:
                            image.src = "/images/mesa_reservada/8.jpg";
                            break;
                        default:
                            image.src = "/images/blanca_con_numero/mesa_default.png";
                            break;
                    }

                    image.onclick = function() {
                        //Recuperar y enviar datos para el pedido
                        getDatosParaPedido(mesa_id);
                        dibujarCuadros($("#zona_old_id").val());
                        abrirModalPedido();
                        $("#btn-pedido-procesar").show();
                        $("#btn-pedido-pendiente").show();
                        $("#btn-pedido-cancelar").show();
                    };

                    break;
                case 3:
                    switch (cantidadSillas) {
                        case 1:
                            image.src = "/images/mesa_ocupada/1.jpg";
                            break;
                        case 2:
                            image.src = "/images/mesa_ocupada/2.jpg";
                            break;
                        case 3:
                            image.src = "/images/mesa_ocupada/3.jpg";
                            break;
                        case 4:
                            image.src = "/images/mesa_ocupada/4.jpg";
                            break;
                        case 5:
                            image.src = "/images/mesa_ocupada/5.jpg";
                            break;
                        case 6:
                            image.src = "/images/mesa_ocupada/6.jpg";
                            break;
                        case 7:
                            image.src = "/images/mesa_ocupada/7.jpg";
                            break;
                        case 8:
                            image.src = "/images/mesa_ocupada/8.jpg";
                            break;
                        default:
                            image.src = "/images/blanca_con_numero/mesa_default.png";
                            break;
                    }
                    break;
            }

			const gridItemTitulo = document.createElement('div');
			gridItemTitulo.className = 'grid-item-container-titulo';
			gridItemTitulo.textContent = titulo;

			gridItem.appendChild(gridItemTitulo);
            gridItem.appendChild(input_mesa_id);
			gridItem.appendChild(image);
		}

		gridContainer.appendChild(gridItem);
	}
}

function getDatosParaPedido(mesa_id){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        type: 'GET',
        url: '/pedidos/get_datos_para_pedido',
        data: {
            _token: CSRF_TOKEN,
            mesa_id: mesa_id
        },
        success: function(data){
            if(data.productos){
                document.getElementById("mesa_id").value = mesa_id;
                document.getElementById("nombre_mesa").innerText = data.mesa;
                var arr = Object.values(data.productos);
                var container_productos = $("#productos-container");
                var container_pedido = $("#content-pedido");
                container_productos.empty();
                container_pedido.empty();
                $.each(arr, function(index, json) {
                    var uniqueId = 'zona-' + json.id;
                    var producto_precio_id = json.id;
                    var zonaDiv = $("<div></div>")
                        .addClass("col-md-3");
                    var zonaLink = $("<a></a>")
                        .addClass("btn btn-outline-dark btn-block font-roboto-9")
                        .css({
                            "height": "60px",
                            "margin-bottom": "20px",
                            "padding": "10px"
                        })
                        .attr({
                            href: "#",
                            id: uniqueId,
                            draggable: true,
                            ondragstart: "drag(event)",
                            ondrag: "dragging(event)",
                            ondragend: "endDrag(event)",
                            "data-precio-producto-id": producto_precio_id,
                            "data-mesa-id": mesa_id
                        })
                        .html("<i class='fas fa-hand-holding-usd fa-fw'></i> " + json.precio + "<br>" + json.producto);

                    zonaDiv.append(zonaLink);
                    container_productos.append(zonaDiv);
                });

                document.getElementById("nro-pedido").value = '';
                document.getElementById("importe-total").value = '';

                if(data.detallePedido != null){
                    $("#pedido-container").show();

                    document.getElementById("nro-pedido").value = data.nro_pedido;
                    document.getElementById("importe-total").value = data.importe_total;
                    new Cleave('#importe-total', {
                        numeral: true,
                        numeralThousandsGroupStyle: 'thousand'
                    });
                    var arr = Object.values(data.detallePedido);
                    var container = $("#content-pedido");
                    container.empty();

                    $.each(arr, function(index, json) {
                        var productos = $(
                                            "<tr class='detalle-pedido-" + json.pedido_detalle_id + " font-roboto-9'>" +
                                                "<td class='text-left p-1'>" + json.categoria_master + "</td>" +
                                                "<td class='text-left p-1'>" + json.producto + "</td>" +
                                                "<td class='text-left p-1'>" +
                                                    "<input type='hidden' name='pedido_detalle_id[]' value='" + json.pedido_detalle_id + "'>" +
                                                    "<input type='number' name='cantidad[]' value='" + json.cantidad + "' placeholder='0' class='input-sm font-roboto-11 text-center input-cantidad' min='1' step='1' onkeypress='return valideNumberSinDecimal(event);' onKeyUp='CalcularCantidadPrecio(" + json.pedido_detalle_id + ")'>" +
                                                "</td>" +
                                                "<td class='text-right p-1'>" +
                                                    "<input type='text' value='" + json.precio + "' class='input-sm font-roboto-11 text-right bg-light input-precio' disabled>" +
                                                "</td>" +
                                                "<td class='text-right p-1'>" +
                                                    "<input type='text' value='" + json.total + "' class='input-sm font-roboto-11 text-right bg-light input-total' disabled>" +
                                                "</td>" +
                                            "</tr>"
                                        );

                        container.append(productos);
                    });
                }
                // Mostrar el modal
                $('#modalpedido').modal('show');
                // Enviar mesa_id al modal
                //$('#modalMesaId').text(data.precio_array);
                //$('#mesaIdInput').val(mesa_id);

            }
        },
        error: function(xhr){
            console.log(xhr.responseText);
        }
    });
}

function CalcularCantidadPrecio(id){
    var cantidad = $('.detalle-pedido-'+id+' .input-cantidad').val();
    var precio = $('.detalle-pedido-'+id+' .input-precio').val();
    cantidad = (isNaN(parseFloat(cantidad)))? 0 : parseFloat(cantidad);
    precio = (isNaN(parseFloat(precio)))? 0 : parseFloat(precio);
    try{
        var total = cantidad * precio;
        $('.detalle-pedido-'+id+' .input-total').each(function() {
            new Cleave(this, {
                numeral: true,
                numeralThousandsGroupStyle: 'thousand'
            }).setRawValue(total);
        });

        suma_total();
    }catch(e){
        console.log('ERROR')
    }
}

function suma_total() {
    var suma = 0;
    $('.input-total').each(function() {
        var valor_cleave = $(this).val();
        var valor = parseFloat(valor_cleave.replace(/,/g, ''));
        valor = (isNaN(parseFloat(valor))) ? 0 : parseFloat(valor);
        suma += valor;
    });

    document.getElementById("importe-total").value = suma;
    new Cleave('#importe-total', {
        numeral: true,
        numeralThousandsGroupStyle: 'thousand'
    });
}

function allowDrop(event) {
    event.preventDefault();
    $("#table-titulo-pedido").hide();
    $("#table-subtitulo-pedido").hide();
    $("#table-detalle-pedido").hide();
    $("#btn-pedido-procesar").hide();
    $("#btn-pedido-pendiente").hide();
    $("#btn-pedido-cancelar").hide();
    event.target.classList.add('drop-area');
}

//INICIA EL MOVIMIENTO
function drag(event) {
    /*
        //ALMACENA EL DATO PARA PODER TRABAJAR EN ESTA FUNCION
        event.dataTransfer.setData("text/plain", event.target.id);
        var precioProductoId = event.target.getAttribute('data-precio-producto-id');
    */
    event.dataTransfer.setData("precioProductoId", event.target.getAttribute('data-precio-producto-id'));
    event.dataTransfer.setData("mesaId", event.target.getAttribute('data-mesa-id'));
    event.target.classList.add('pulsating-image');
    droppedInZone = false;
}

//ESTA EN MOVIMIENTO
function dragging(event) {
    //console.log('dragging-cursor');
}

//FINALIZA EL MOVIMIENTO
function endDrag(event) {
    if (!droppedInZone) {
        event.target.style.removeProperty('opacity');
    }else{
        event.target.style.opacity = "0.5";
        event.target.classList.remove('btn-outline-dark');
        event.target.classList.add('btn-dark');
    }
    event.target.classList.remove('pulsating-image');
}

function dragLeave(event) {
    $("#table-titulo-pedido").show();
    $("#table-subtitulo-pedido").show();
    $("#table-detalle-pedido").show();
    $("#btn-pedido-procesar").show();
    $("#btn-pedido-pendiente").show();
    $("#btn-pedido-cancelar").show();
    event.target.classList.remove('drop-area');
    //console.log('dragLeave');
}

function drop(event) {
    event.preventDefault();
    var precioProductoId = event.dataTransfer.getData("precioProductoId");
    var mesaId = event.dataTransfer.getData("mesaId");
    $("#table-titulo-pedido").show();
    $("#table-subtitulo-pedido").show();
    $("#table-detalle-pedido").show();
    $("#btn-pedido-procesar").show();
    $("#btn-pedido-pendiente").show();
    $("#btn-pedido-cancelar").show();
    event.target.classList.remove('drop-area');
    droppedInZone = true;
    actualizarPedido(precioProductoId, mesaId);
    /*if ((event.target.classList.contains('grid-item-container')) && event.target !== draggedElement) {
        var clonedElement = draggedElement.cloneNode(true);

        // Cambiar el atributo 'draggable' a false y eliminar otros atributos
        clonedElement.setAttribute('draggable', 'false');
        clonedElement.removeAttribute('ondragstart');
        clonedElement.removeAttribute('ondrag');
        clonedElement.removeAttribute('ondragend');

        //var input_c_sillas = document.createElement('input');
        //input_c_sillas.type = 'text';
        //input_c_sillas.name = 'cantidad_sillas[]';
        //input_c_sillas.value = clonedElement.id || '';
        var clonedElementId = clonedElement.id || '';
        //clonedElement.appendChild(input_c_sillas);

        var button = document.createElement('button');
        button.className = 'info-button';
        var modal = document.getElementById('modal_datos');
        var span = document.getElementsByClassName('cancelar')[0];
        var saveButton = document.getElementById('saveButton');
        // Mostrar el modal
        modal.style.display = 'block';
        // Cuando el usuario hace clic en <span> (x), cerrar el modal
        span.onclick = function() {
            document.getElementById('nombre').value = '';
            modal.style.display = 'none';
        }
        // Cuando el usuario hace clic en cualquier lugar fuera del modal, cerrar el modal
        window.onclick = function(event) {
            if (event.target == modal) {
                document.getElementById('nombre').value = '';
                modal.style.display = 'none';
            }
        }
        saveButton.onclick = function() {
            var nombre = document.getElementById('nombre').value;
            if (nombre) {
                //var input_nombre = document.createElement('input');
                //input_nombre.type = 'text';
                //input_nombre.name = 'nombre[]';
                //input_nombre.value = nombre || '';
                //clonedElement.appendChild(input_nombre);
                document.getElementById('nombre').value = '';

                modal.style.display = 'none';

                var attributesToRemove = ['ondragstart', 'ondrag', 'ondragend', 'id'];
                attributesToRemove.forEach(attr => clonedElement.removeAttribute(attr));

                // Asignar un nuevo ID único
                clonedElement.id = 'cloned-' + data + '-' + new Date().getTime();

                // Eliminar todas las clases del clon
                while (clonedElement.classList.length > 0) {
                    clonedElement.classList.remove(clonedElement.classList.item(0));
                }

                // Agregar un input tipo texto para guardar la ubicación
                //var input_ubicacion = document.createElement('input');
                //input_ubicacion.type = 'text';
                //input_ubicacion.name = 'ubicacion[]'; // Utiliza un array si esperas múltiples ubicaciones
                //input_ubicacion.value = event.target.dataset.position || ''; // Establece la posición como valor
                //clonedElement.appendChild(input_ubicacion);
                //dilson
                var empresa_id = $("#empresa_id >option:selected").val();
                var sucursal_id = $("#sucursal_id >option:selected").val();
                var zona_id = $("#zona_id").val();
                var cantidad_sillas = clonedElementId;
                var titulo = nombre || '';
                var ubicacion = event.target.dataset.position || '';
                agregar_en_la_bd(empresa_id, sucursal_id, zona_id, cantidad_sillas, titulo, ubicacion);

                // Establecer estilos adicionales si es necesario
                clonedElement.style.opacity = '0.9';
                //clonedElement.style.transform = 'scale(0.7)';
                const gridItemTitulo = document.createElement('div');
                gridItemTitulo.className = 'grid-item-container-titulo';
                gridItemTitulo.textContent = nombre;

                const gridItemEliminar = document.createElement('div');
                gridItemEliminar.className = 'grid-item-container-eliminar';
                gridItemEliminar.innerHTML  = '<i class="fas fa-trash"></i>';
                gridItemEliminar.style.cursor = 'pointer';
                gridItemEliminar.onclick = function() {
                    // Buscar la imagen dentro del gridItem actual y eliminarla
                    const imagenAEliminar = event.target.querySelector('img');
                    if (imagenAEliminar) {
                        imagenAEliminar.remove();
                    }

                    // Eliminar el título dentro del gridItem actual
                    const tituloAEliminar = event.target.querySelector('.grid-item-container-titulo');
                    if (tituloAEliminar) {
                        tituloAEliminar.remove();
                    }

                    // Eliminar el boton eliminar dentro del gridItem actual
                    const itemAEliminar = event.target.querySelector('.grid-item-container-eliminar');
                    if (itemAEliminar) {
                        itemAEliminar.remove();
                    }
                };

                event.target.appendChild(gridItemTitulo);
                event.target.appendChild(clonedElement);
                event.target.appendChild(gridItemEliminar);
            }
        }
    }*/
}

function actualizarPedido(precio_producto_id, mesa_id){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: 'GET',
		url: '/pedidos/get_update_pedido',
		data: {
			_token: CSRF_TOKEN,
			precio_producto_id: precio_producto_id,
            mesa_id: mesa_id
		},
		success: function(data){
            if(data){
                $("#pedido-container").show();

                document.getElementById("nro-pedido").value = data.nro_pedido;
                document.getElementById("importe-total").value = data.importe_total;
                new Cleave('#importe-total', {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand'
                });
                var container = $("#content-pedido");
                var productos = $(
                                    "<tr class='detalle-pedido-" + data.detallePedido.pedido_detalle_id + " font-roboto-9'>" +
                                        "<td class='text-left p-1'>" + data.detallePedido.categoria_master + "</td>" +
                                        "<td class='text-left p-1'>" + data.detallePedido.producto + "</td>" +
                                        "<td class='text-left p-1'>" +
                                            "<input type='hidden' name='pedido_detalle_id[]' value='" + data.detallePedido.pedido_detalle_id + "'>" +
                                            "<input type='number' name='cantidad[]' placeholder='0' class='input-sm font-roboto-11 text-center input-cantidad' min='1' step='1' onkeypress='return valideNumberSinDecimal(event);' onKeyUp='CalcularCantidadPrecio(" + data.detallePedido.pedido_detalle_id + ")'>" +
                                        "</td>" +
                                        "<td class='text-right p-1'>" +
                                            "<input type='text' value='" + data.detallePedido.precio + "' class='input-sm font-roboto-11 text-right bg-light input-precio' disabled>" +
                                        "</td>" +
                                        "<td class='text-right p-1'>" +
                                            "<input type='text' value='0' class='input-sm font-roboto-11 text-right bg-light input-total' disabled>" +
                                        "</td>" +
                                    "</tr>"
                                );

                container.append(productos);
                suma_total();
            }
		},
		error: function(xhr){
			console.log(xhr.responseText);
		}
	});
}
