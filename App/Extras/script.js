// Guardar el estado del canvas en localStorage
function saveCanvasState() {
    const json = stage.toJSON();
    localStorage.setItem('konvaState', json);
}

// Restaurar el estado del canvas desde localStorage
function loadCanvasState() {
    const json = localStorage.getItem('konvaState');
    if (json) {
        stage = Konva.Node.create(json, 'canvas-container');
    }
}

// Llamar a loadCanvasState al cargar la página
window.onload = function() {
    loadCanvasState();
};

// Llamar a saveCanvasState antes de cambiar el modo oscuro
document.querySelector('.Toogle').addEventListener('click', function() {
    saveCanvasState();
    window.location.href = '?toggle_dark_mode=1';
});