var cont = 0;
let filas = parseInt(document.getElementById('filas').value) || 0;
let columnas = parseInt(document.getElementById('columnas').value) || 0;

function recuperar_mesas(cont,filas,columnas){
	var id = $("#zona_id").val();
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: 'GET',
		url: '/mesas/get_mesas',
		data: {
			_token: CSRF_TOKEN,
			id: id
		},
		success: function(data){
            if(data.mesa_id_array){
                var mesa_ocupada_incrementada = data.mesa_ocupada_array.map(function(value) {
                    return  (Number(value) + Number(cont)).toString();
                });

                construirDivContainer(data.mesa_id_array, mesa_ocupada_incrementada, data.cantidad_sillas_array, data.titulo_array, data.estado_array);
                actualizar_size_zonas(id,filas,columnas);

            }else{
                construirDivContainerVacio();
            }
		},
		error: function(xhr){
			console.log(xhr.responseText);
		}
	});
}

function construirDivContainer(mesaIdArray, mesaOcupadaArray, cantidadSillasArray, tituloArray, estadoArray){
	const numFilas = $("#filas").val();
	const numColumnas = $("#columnas").val();

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
        actualizar_posiciones(mesaIdArray,mesaOcupadaArray);
	}
}

function construirDivContainerVacio(){
	const numFilas = $("#filas").val();
	const numColumnas = $("#columnas").val();

	const gridContainer = document.getElementById('grid-container');
	gridContainer.innerHTML = '';

	gridContainer.style.display = 'grid';
	gridContainer.style.gridTemplateColumns = `repeat(${numColumnas}, 1fr)`;
	gridContainer.style.gridAutoRows = 'minmax(10px, 1fr)';
	gridContainer.style.gridGap = '0px';
    dibujar_cuadros_vacios(
        numFilas,
        numColumnas,
        gridContainer
    );
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
		gridItem.setAttribute('data-position', i);
		gridItem.setAttribute('ondrop', 'drop(event)');
		gridItem.setAttribute('ondragover', 'allowDrop(event)');

		if (mesaOcupadaArray.includes(i.toString())) {
			const index = mesaOcupadaArray.indexOf(i.toString());
			const cantidadSillas = parseInt(cantidadSillasArray[index]);
			const titulo = tituloArray[index];
			const mesa_id = parseInt(mesaIdArray[index]);
            const position = parseInt(mesaOcupadaArray[index]);
            const estado = parseInt(estadoArray[index]);

            var input_old_ubicacion = document.createElement('input');
            input_old_ubicacion.type = 'hidden';
            input_old_ubicacion.name = 'old_ubicacion[]';
            input_old_ubicacion.id = 'old_ubicacion';
            input_old_ubicacion.value = position;

            var input_old_mesa_id = document.createElement('input');
            input_old_mesa_id.type = 'hidden';
            input_old_mesa_id.name = 'old_mesa_id[]';
            input_old_mesa_id.id = 'old_mesa_id';
            input_old_mesa_id.value = mesa_id;

			const image = document.createElement('img');
            const gridItemEliminar = document.createElement('div');

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

                    gridItemEliminar.className = 'grid-item-container-eliminar';
                    gridItemEliminar.innerHTML  = '<i class="fas fa-trash"></i>';
                    gridItemEliminar.style.cursor = 'pointer';
                    gridItemEliminar.onclick = function() {
                        // Buscar la imagen dentro del gridItem actual y eliminarla
                        const imagenAEliminar = gridItem.querySelector('img');
                        if (imagenAEliminar) {
                            imagenAEliminar.remove();
                        }

                        // Eliminar el título dentro del gridItem actual
                        const tituloAEliminar = gridItem.querySelector('.grid-item-container-titulo');
                        if (tituloAEliminar) {
                            tituloAEliminar.remove();
                        }

                        // Eliminar el boton dentro del gridItem actual
                        const itemAEliminar = gridItem.querySelector('.grid-item-container-eliminar');
                        if (itemAEliminar) {
                            itemAEliminar.remove();
                        }

                        // Eliminar el input dentro del gridItem actual
                        const inputoldUbicacionAEliminar = gridItem.querySelector('#old_ubicacion');
                        if (inputoldUbicacionAEliminar) {
                            inputoldUbicacionAEliminar.remove();
                        }

                        const inputoldMesaIdAEliminar = gridItem.querySelector('#old_mesa_id');
                        if (inputoldMesaIdAEliminar) {
                            inputoldMesaIdAEliminar.remove();
                        }

                        gridItem.setAttribute('data-position', i);
                        gridItem.setAttribute('ondrop', 'drop(event)');
                        gridItem.setAttribute('ondragover', 'allowDrop(event)');

                        //Ir a eliminar en la tabla
                        eliminar_en_la_bd(mesa_id);
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

			image.alt = 'Img';
			image.style.transform = 'scale(0.9)';
			image.setAttribute('draggable', 'false');
			gridItem.appendChild(gridItemTitulo);
            gridItem.appendChild(input_old_ubicacion);
            gridItem.appendChild(input_old_mesa_id);
			gridItem.appendChild(image);
			gridItem.appendChild(gridItemEliminar);
			gridItem.removeAttribute('data-position');
			gridItem.removeAttribute('ondrop');
			gridItem.removeAttribute('ondragover');
		}

		gridContainer.appendChild(gridItem);
	}
}

function eliminar_en_la_bd(id){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: 'GET',
		url: '/mesas/get_eliminar',
		data: {
			_token: CSRF_TOKEN,
			id: id
		},
		success: function(data){
			console.log(data.message);
		},
		error: function(xhr){
			console.log(xhr.responseText);
		}
	});
}

function agregar_en_la_bd(empresa_id, sucursal_id, zona_id, cantidad_sillas, titulo, ubicacion){
	var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: 'GET',
		url: '/mesas/get_add',
		data: {
			_token: CSRF_TOKEN,
			empresa_id: empresa_id,
            sucursal_id: sucursal_id,
            zona_id: zona_id,
            cantidad_sillas: cantidad_sillas,
            titulo: titulo,
            ubicacion: ubicacion
		},
		success: function(data){
			console.log(data.message);
		},
		error: function(xhr){
			console.log(xhr.responseText);
		}
	});
}

function incrementar_filas_columnas() {
	//let filas = parseInt(document.getElementById('filas').value) || 0;
	//let columnas = parseInt(document.getElementById('columnas').value) || 0;
	filas++;
	columnas++;
	document.getElementById('filas').value = filas;
	document.getElementById('columnas').value = columnas;
	cont = cont + 1;
	recuperar_mesas(cont,filas,columnas);
}

function decrementar_filas_columnas() {
	//let filas = parseInt(document.getElementById('filas').value) || 0;
	//let columnas = parseInt(document.getElementById('columnas').value) || 0;
	filas--;
	columnas--;
	document.getElementById('filas').value = filas;
	document.getElementById('columnas').value = columnas;
	cont = cont - 1;
	recuperar_mesas(cont,filas,columnas);
}

function actualizar_size_zonas(zona_id, filas, columnas){
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: 'GET',
		url: '/mesas/get_update_fc',
		data: {
			_token: CSRF_TOKEN,
			zona_id: zona_id,
            filas: filas,
            columnas: columnas
		},
		success: function(data){
			console.log(data.message);
		},
		error: function(xhr){
			console.log(xhr.responseText);
		}
	});
}

function actualizar_posiciones(mesa_id, posicion){
    //console.log(mesa_id, posicion);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
	$.ajax({
		type: 'GET',
		url: '/mesas/get_posicion',
		data: {
			_token: CSRF_TOKEN,
			mesa_id: mesa_id,
            posicion: posicion
		},
		success: function(data){
			console.log(data.message);
		},
		error: function(xhr){
			console.log(xhr.responseText);
		}
	});
}

/*DESPLAZAMIENTO DE MESAS*/
function allowDrop(event) {
    event.preventDefault();
}

function drag(event) {
    //console.log('drag');
    event.dataTransfer.setData("text/plain", event.target.id);
    //event.target.classList.add('dragging');
}

function dragging(event) {
    //console.log('dragging-cursor');
    //event.target.classList.add('dragging-cursor');
    //event.target.style.transform = 'scale(1.3)';
    event.target.classList.add('pulsating-image');
}

function endDrag(event) {
    //console.log('enddrag');
    //event.target.classList.remove('dragging');
    //event.target.style.transform = 'scale(1)';
    event.target.classList.remove('pulsating-image');
}

function drop(event) {
    event.preventDefault();
    var data = event.dataTransfer.getData("text/plain");
    var draggedElement = document.getElementById(data);

    if ((event.target.classList.contains('grid-item-container')) && event.target !== draggedElement) {
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
    }
    //quitarResaltado(event);
}

function resaltarDestino(event) {
    /*event.target.classList.add('highlight');*/
    /*console.log('Resaltar evento');*/
}

function quitarResaltado(event) {
    /*event.target.classList.remove('highlight');*/
    /*console.log('Quitar resaltado');*/
}
