function dibujar_cuadros(numFilas, numColumnas, gridContainer, mesaIdArray, mesaOcupadaArray, cantidadSillasArray, tituloArray) {
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
            const posicion = parseInt(mesaOcupadaArray[index]);

            const image = document.createElement('img');

            switch (cantidadSillas) {
                case 1:
                    /*image.src = "{{ asset('images/blanca_con_numero/una_silla.jpg') }}";*/
                    image.src = "/images/blanca_con_numero/una_silla.jpg";
                    break;
                case 2:
                    /*image.src = "{{ asset('images/blanca_con_numero/dos_sillas.jpg') }}";*/
                    image.src = "/images/blanca_con_numero/dos_sillas.jpg";
                    break;
                case 3:
                    /*image.src = "{{ asset('images/blanca_con_numero/tres_sillas.jpg') }}";*/
                    image.src = "/images/blanca_con_numero/tres_sillas.jpg";
                    break;
                case 4:
                    /*image.src = "{{ asset('images/blanca_con_numero/cuatro_sillas.jpg') }}";*/
                    image.src = "/images/blanca_con_numero/cuatro_sillas.jpg";
                    break;
                case 5:
                    /*image.src = "{{ asset('../images/blanca_con_numero/cinco_sillas.jpg') }}";*/
                    image.src = "/images/blanca_con_numero/cinco_sillas.jpg";
                    break;
                case 6:
                    /*image.src = "{{ asset('images/blanca_con_numero/seis_sillas.jpg') }}";*/
                    image.src = "/images/blanca_con_numero/seis_sillas.jpg";
                    break;
                case 7:
                    /*image.src = "{{ asset('images/blanca_con_numero/siete_sillas.jpg') }}";*/
                    image.src = "/images/blanca_con_numero/siete_sillas.jpg";
                    break;
                case 8:
                    /*image.src = "{{ asset('images/blanca_con_numero/ocho_sillas.jpg') }}";*/
                    image.src = "/images/blanca_con_numero/ocho_sillas.jpg";
                    break;
                default:
                    /*image.src = "{{ asset('images/blanca_con_numero/mesa_default.png') }}";*/
                    image.src = "/images/blanca_con_numero/mesa_default.png";
                    break;
            }
            const gridItemTitulo = document.createElement('div');
            gridItemTitulo.className = 'grid-item-container-titulo';
            gridItemTitulo.textContent = titulo;

            const gridItemEliminar = document.createElement('div');
            gridItemEliminar.className = 'grid-item-container-eliminar';
            gridItemEliminar.innerHTML = '<i class="fas fa-trash"></i>';
            gridItemEliminar.style.cursor = 'pointer';
            gridItemEliminar.onclick = function () {
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

                // Eliminar el boton eliminar dentro del gridItem actual
                const itemAEliminar = gridItem.querySelector('.grid-item-container-eliminar');
                if (itemAEliminar) {
                    itemAEliminar.remove();
                }

                gridItem.setAttribute('data-position', i);
                gridItem.setAttribute('ondrop', 'drop(event)');
                gridItem.setAttribute('ondragover', 'allowDrop(event)');

                //Ir a eliminar en la tabla
                eliminar_en_la_bd(mesa_id);
            };

            image.alt = 'Img';
            image.style.transform = 'scale(0.9)';
            image.setAttribute('draggable', 'false');
            gridItem.appendChild(gridItemTitulo);
            gridItem.appendChild(image);
            gridItem.appendChild(gridItemEliminar);
            gridItem.removeAttribute('data-position');
            gridItem.removeAttribute('ondrop');
            gridItem.removeAttribute('ondragover');
        }

        gridContainer.appendChild(gridItem);
    }
}
