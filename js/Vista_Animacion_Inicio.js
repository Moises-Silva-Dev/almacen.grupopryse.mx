window.addEventListener('load', () => { // Este evento se dispara cuando la página ha terminado de cargar
    // Muestra el loader y oculta el contenido principal
    setTimeout(() => {
        document.getElementById('loader').style.display = 'none'; // Oculta el loader
        document.getElementById('main-content').style.display = 'block'; // Muestra el contenido principal
    }, 3000); // Espera 3 segundos antes de ocultar el loader y mostrar el contenido
});