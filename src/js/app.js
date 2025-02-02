let paso = 1;
const pasoInicial = 1;
const pasoFinal = 3;
const URL = 'http://localhost:3000';

const cita = {
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', () => {
    iniciarApp();
})


function iniciarApp() {
    mostrarSeccion(); //Muestra la seccion de acuerdo al paso
    tabs(); //Cambia de seccion al hacer click
    botonesPaginador()
    paginaAnterior();
    paginaSiguiente();
    consultarAPI();
    nombreCliente();
    seleccionarFecha();
    seleccionarHora();
    // mostrarResumen();
}
function mostrarSeccion() {
    //Ocultar la seccion anterios
    const seccionAnterior = document.querySelector('.mostrar');
    if (seccionAnterior) {
        seccionAnterior.classList.remove('mostrar');
    }

    //Selccionar la seccion con el paso
    const seccion = document.querySelector(`#paso-${paso}`);
    seccion.classList.add('mostrar');

    //Eliminar la clase actual en el tab anterior
    const tabAnterior = document.querySelector('.actual');
    if (tabAnterior) {
        tabAnterior.classList.remove('actual');
    }

    //Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`)
    tab.classList.add('actual');
}

function tabs() {
    const botones = document.querySelectorAll(".tabs button")
    botones.forEach(boton => {
        boton.addEventListener('click', (e) => {
            paso = parseInt(e.target.dataset.paso);
            mostrarSeccion();
            botonesPaginador();

        })
    })
}
function botonesPaginador() {
    const paginaAnterior = document.querySelector('#anterior');
    const paginaSiguiente = document.querySelector('#siguiente');

    if (paso === 1) {
        paginaAnterior.classList.add('ocultar');
        paginaSiguiente.classList.remove('ocultar');
    } else if (paso === 2) {
        paginaSiguiente.classList.remove('ocultar');
        paginaAnterior.classList.remove('ocultar');
    } else if (paso === 3) {
        paginaAnterior.classList.remove('ocultar');
        paginaSiguiente.classList.add('ocultar');
        mostrarResumen();
    }
    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector('#anterior');
    paginaAnterior.addEventListener('click', function () {
        if (paso <= pasoInicial) return;
        paso--;

        botonesPaginador();
    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector('#siguiente');
    paginaSiguiente.addEventListener('click', function () {
        if (paso >= pasoFinal) return;
        paso++;

        botonesPaginador();
    });
}


async function consultarAPI() {
    try {
        const response = await fetch(`${URL}/api/servicios`);
        const data = await response.json();
        mostrarServicios(data);
    } catch (error) {
        console.log(error)
    }
}


function mostrarServicios(data) {
    const servicios = document.querySelector('#servicios');
    data.forEach(servicio => {
        const { id, nombre, precio } = servicio;

        const nombreServicio = document.createElement('p');
        nombreServicio.classList.add('nombre-servicio');
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement('p');
        precioServicio.classList.add('precio-servicio');
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement('div');
        servicioDiv.classList.add('servicio');
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = function () {
            seleccionarServicio(servicio);
            console.log(cita)
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        servicios.appendChild(servicioDiv);

    })
}


function seleccionarServicio(servicio) {
    const { id } = servicio;
    const { servicios } = cita;

    // Identificar el elemento al que se le da click
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobar si un servicio ya fue agregado
    if (servicios.some(agregado => agregado.id === id)) {
        // Eliminarlo
        cita.servicios = servicios.filter(agregado => agregado.id !== id);
        divServicio.classList.remove('seleccionado');
    } else {
        // Agregarlo
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add('seleccionado');
    }
}


function nombreCliente() {
    const nombre = document.querySelector('#nombre').value;
    cita.nombre = nombre;
}

function seleccionarFecha() {
    const inpuFecha = document.querySelector('#fecha');
    inpuFecha.addEventListener('input', (e) => {
        const dia = new Date(e.target.value).getUTCDay();
        if ([0, 6].includes(dia)) {
            inpuFecha.value = '';
            mostrarAlerta('Fines de semana no permitido', 'error');
        } else {
            cita.fecha = e.target.value;
        }
    })

}

function seleccionarHora() {
    const inputHora = document.querySelector('#hora');
    inputHora.addEventListener('input', function (e) {

        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];

        if (hora < 9 || hora > 21) {
            e.target.value = '';
            mostrarAlerta('Hora no valida', 'error');
        } else {
            cita.hora = e.target.value;
        }
    });
}

function mostrarAlerta(mensaje, tipo) {
    const backgroundAlerta = tipo === 'error' ? 'red' : 'green';

    Toastify({
        text: mensaje,
        duration: 3000,
        newWindow: true,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "right", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: backgroundAlerta,
        },
        onClick: function () { } // Callback after click
    }).showToast();

}

function mostrarResumen() {
    const resumen = document.querySelector('.contenido-resumen');

    // Limpiar el Contenido de Resumen
    while (resumen.firstChild) {
        resumen.removeChild(resumen.firstChild);
    }

    if (Object.values(cita).includes('') || cita.servicios.length === 0) {
        mostrarAlerta('Faltan datos de Servicios, Fecha u Hora', 'error');

        return;
    } 

    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios } = cita;

    // Heading para Servicios en Resumen
    const headingServicios = document.createElement('H3');
    headingServicios.textContent = 'Resumen de Servicios';
    resumen.appendChild(headingServicios);

    // Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre } = servicio;
        const contenedorServicio = document.createElement('DIV');
        contenedorServicio.classList.add('contenedor-servicio');

        const textoServicio = document.createElement('P');
        textoServicio.textContent = nombre;

        const precioServicio = document.createElement('P');
        precioServicio.innerHTML = `<span>Precio:</span> $${precio}`;

        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);

        resumen.appendChild(contenedorServicio);
    });

    // Heading para Cita en Resumen
    const headingCita = document.createElement('H3');
    headingCita.textContent = 'Resumen de Cita';
    resumen.appendChild(headingCita);

    const nombreCliente = document.createElement('P');
    nombreCliente.innerHTML = `<span>Nombre:</span> ${nombre}`;

    // Formatear la fecha en Español
    const fechaObj = new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate() + 2; // Recupera desfase de dos días
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
    const fechaFormateada = fechaUTC.toLocaleDateString('es-AR', opciones);

    const fechaCliente = document.createElement('P');
    fechaCliente.innerHTML = `<span>Fecha:</span> ${fechaFormateada}`;

    const horaCliente = document.createElement('P');
    horaCliente.innerHTML = `<span>Hora:</span> ${hora}`;

    // Boton para Crear una Cita
    const botonReservar = document.createElement('BUTTON');
    botonReservar.classList.add('boton');
    botonReservar.textContent = 'Reservar Cita';
    botonReservar.onclick = reservarCita;


    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCliente);
    resumen.appendChild(horaCliente);
    resumen.appendChild(botonReservar);
}

function reservarCita(){
    
}