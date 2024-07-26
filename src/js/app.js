let step = 1;
const initialStep = 1;
const finalStep = 3;

const game = {
    id: '',
    nombre: '',
    fecha: '',
    hora: '',
    servicios: []
}

document.addEventListener('DOMContentLoaded', function() {
    startApp()
})

function startApp() {
    showSection() // Muestra y oculta las secciones
    tabs() // Cambia la sección cuando se presionan los tabs
    pagerButtons() // Agrega o quita los botones del paginador
    nextPage()
    previousPage()
    consultAPI() // Consulta la API en el backend de PHP
    clientId()
    clientName() // Añade el nombre del cliente al objeto de game
    selectDate() // Añade la fecha del game en el objeto
    selectTime() // Añade la hora del game en el objeto
    showSummary() // Muestra el resumen del game
}

function showSection () {
    // Ocultar la sección que tenga la clase de mostrar
    const previousSection = document.querySelector('.show')
    if(previousSection) {
        previousSection.classList.remove('show')
    }

    // Seleccionar la sección con el paso
    const stepSelector = `#step-${step}`
    const section = document.querySelector(stepSelector)
    section.classList.add('show')

    // Quita la clase de actual al tab anterior
    const previousTab = document.querySelector('.current')
    if(previousTab) {
        previousTab.classList.remove('current')
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-step="${step}"]`)
    tab.classList.add('current')
}

function tabs() {
    const buttons = document.querySelectorAll('.tabs button')

    buttons.forEach( button => {
        button.addEventListener('click', function(e) {
            step = parseInt(e.target.dataset.step)
            showSection()
            pagerButtons()
        })
    })
}

function pagerButtons() {
    const previousPage = document.querySelector('#previous')
    const nextPage = document.querySelector('#next')

    if(step === 1) {
        previousPage.classList.add('hide')
        nextPage.classList.remove('hide')
    } else if(step === 3) {
        previousPage.classList.remove('hide')
        nextPage.classList.add('hide')
        showSummary()
    } else {
        previousPage.classList.remove('hide')
        nextPage.classList.remove('hide')
    }

    showSection()
}

function previousPage() {
    const previousPage = document.querySelector('#previous')
    previousPage.addEventListener('click', function() {
        if(step <= initialStep) return
        step--

        pagerButtons()
    })
}

function nextPage() {
    const nextPage = document.querySelector('#next')
    nextPage.addEventListener('click', function() {
        if(step >= finalStep) return
        step++

        pagerButtons()
    })
}

async function consultAPI() {

    try {
        const url = '/api/services' 
        const result = await fetch(url)
        const services = await result.json()
        showServices(services)
    } catch (error) {
        console.log(error)
    }

}

function showServices(services) {
    services.forEach(service => {
        const { id, nombre, precio } = service

        const serviceName = document.createElement('P')
        serviceName.classList.add('service-name')
        serviceName.textContent = nombre;

        const priceService = document.createElement('P')
        priceService.classList.add('price-service')
        priceService.textContent = `$${precio}`

        const serviceDiv = document.createElement('DIV')
        serviceDiv.classList.add('service')
        serviceDiv.dataset.idService = id
        serviceDiv.onclick = function() {
            selectService(service)
        }

        serviceDiv.appendChild(serviceName)
        serviceDiv.appendChild(priceService)

        document.querySelector('#services').appendChild(serviceDiv)

    })
}

function selectService(service) {
    const { id } = service
    const { servicios } = game;

    const serviceDiv = document.querySelector(`[data-id-service="${id}"]`)

    // Comprobar si un servicio ya fue agregado
    if(servicios.some( aggregate => aggregate.id === id )) {
        // Eliminarlo
        game.servicios = servicios.filter( aggregate => aggregate.id !== id )
        serviceDiv.classList.remove('selected')
    } else {
        // Agregarlo
        game.servicios = [...servicios, service]
        serviceDiv.classList.add('selected')
    }
}

function clientId() {
    game.id = document.querySelector('#id').value
}

function clientName() {
    game.nombre = document.querySelector('#name').value
}

function selectDate() {
    const inputDate = document.querySelector('#date')
    inputDate.addEventListener('input', function(e) {
        const day = new Date(e.target.value).getUTCDay()
        
        if( [1].includes(day) ) {
            e.target.value = ''
            showAlert('No hay servicio los lunes', 'error', '.form')
        } else {
            game.fecha = e.target.value
        }
    })
}

function selectTime() {
    const inputTime = document.querySelector('#hour')
    inputTime.addEventListener('input', function(e) {
        const gameTime = e.target.value
        const hour = gameTime.split(":")[0]
        if(hour < 9 || hour >= 22) {
            e.target.value = ''
            showAlert('Hora no válida', 'error', '.form')
        } else {
            game.hora = e.target.value
        }
    })
}

function showAlert(message, type, element, disappears = true) {

    // Previene que se generen más de 1 alerta
    const earlyWarning = document.querySelector('.alert')
    if(earlyWarning) {
        earlyWarning.remove()
    }

    // Scripting
    const alert = document.createElement('DIV')
    alert.textContent = message
    alert.classList.add('alert')
    alert.classList.add(type)

    const reference = document.querySelector(element)
    reference.appendChild(alert)

    // Elimina la alerta 
    if(disappears) {
        setTimeout(() => {
            alert.remove()
        }, 3000)
    }
    
}

function showSummary() {
    const summary = document.querySelector('.summary-content')

    // Limpiar el contenido del resumen
    while(summary.firstChild) {
        summary.removeChild(summary.firstChild)
    }

    if(Object.values(game).includes('') || game.servicios.length === 0) {
        showAlert('Faltan datos: fecha, hora o servicios', 'error', '.summary-content', false)
        return
    } 

    // Formatear el div de resumen
    const { nombre, fecha, hora, servicios } = game

    // Heading para servicios en resumen
    const headingServices = document.createElement('H3')
    headingServices.textContent = 'Resumen de Servicios'
    summary.appendChild(headingServices)

    // Iterando y mostrando los servicios
    servicios.forEach(servicio => {
        const { id, precio, nombre } = servicio

        const serviceContainer = document.createElement('DIV')
        serviceContainer.classList.add('service-container')

        const serviceText = document.createElement('P')
        serviceText.textContent = nombre

        const servicePrice = document.createElement('P')
        servicePrice.innerHTML = `<span>Precio:</span> $${precio}`

        serviceContainer.appendChild(serviceText)
        serviceContainer.appendChild(servicePrice)

        summary.appendChild(serviceContainer)
    })

    // Heading para game en resumen
    const headingGame = document.createElement('H3')
    headingGame.textContent = 'Resumen del partido'
    summary.appendChild(headingGame)

    const clientName = document.createElement('P')
    clientName.innerHTML = `<span>Nombre:</span> ${nombre}`

    // Formatear la fecha en español
    const dateObj = new Date(fecha)
    const month = dateObj.getMonth()
    const day = dateObj.getDate()
    const year = dateObj.getFullYear()

    const dateUTC = new Date( Date.UTC(year, month, day) )

    const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }
    const formattedDate = dateUTC.toLocaleDateString('es-CO', options)

    const gameDate = document.createElement('P')
    gameDate.innerHTML = `<span>Fecha:</span> ${formattedDate}`

    const gameTime = document.createElement('P')
    gameTime.innerHTML = `<span>Hora:</span> ${hora} Horas`

    // Boton para crear un partido
    const reserveButton = document.createElement('BUTTON')
    reserveButton.classList.add('button')
    reserveButton.textContent = 'Reservar Partido'
    reserveButton.onclick = reserveGame

    summary.appendChild(clientName)
    summary.appendChild(gameDate)
    summary.appendChild(gameTime)
    summary.appendChild(reserveButton)
}

async function reserveGame() {
    const { id, nombre, fecha, hora, servicios } = game

    const idServices = servicios.map( servicio => servicio.id )
    // console.log(idServices)

    const data = new FormData()
    data.append('usuarioId', id)
    data.append('hora', hora)
    data.append('fecha', fecha)
    data.append('servicios', idServices)
    
    // console.log([...datos])

    try {
        // Petición hacia la api
        const url = '/api/games'

        const answer = await fetch(url, {
            method: 'POST',
            body: data
        })

        const result = await answer.json()
        console.log(result.resultado)

        if(result.resultado) {
            Swal.fire({
                icon: "success",
                title: "Reservación creada",
                text: "Tu reservación fue creada correctamente",
                button: 'OK'
            }).then(() => {
                window.location.reload()
            })
        }
    } catch (error) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "Hubo un error al guardar la reservación"
        }).then(() => {
            window.location.reload()
        })
    }

    

}


