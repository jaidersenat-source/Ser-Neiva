// index.js para mapa

document.addEventListener('DOMContentLoaded', () => {
    // Búsqueda en desktop
    const buscador = document.getElementById('buscador');
    if (buscador) {
        buscador.addEventListener('input', (e) => {
            filtrarIglesias(e.target.value);
        });
    }

    // Búsqueda en móvil
    const buscadorMobile = document.getElementById('buscador-iglesias-mobile');
    if (buscadorMobile) {
        buscadorMobile.addEventListener('input', (e) => {
            filtrarIglesias(e.target.value);
        });
    }

    // Función para filtrar iglesias
    function filtrarIglesias(valor) {
        // Aquí va la lógica para filtrar la lista y/o el mapa
        // Ejemplo básico:
        // window.misDatos contiene los datos
        // Actualiza la lista de iglesias según el valor
        // Puedes adaptar esto según tu estructura
        // ...
    }

    // Puedes mover aquí otras funciones relacionadas con el mapa y la vista
    // Por ejemplo: abrirDrawer, cerrarDrawer, recentrarMapa, etc.
});
