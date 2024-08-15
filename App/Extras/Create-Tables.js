// Crear el escenario
var stage = new Konva.Stage({
    container: 'canvas-container', // ID del contenedor
    width: window.innerWidth / 2, // Ajusta el tamaño según sea necesario
    height: window.innerHeight
});

// Crear una capa
var layer = new Konva.Layer();
stage.add(layer);

// Función para crear una "tabla"
function createTable(x, y, text) {
    var group = new Konva.Group({
        x: x,
        y: y,
        draggable: true
    });

    var rect = new Konva.Rect({
        width: 100,
        height: 50,
        fill: 'lightblue',
        stroke: 'black',
        strokeWidth: 2
    });

    var tableText = new Konva.Text({
        text: text,
        fontSize: 18,
        fontFamily: 'Calibri',
        fill: 'black',
        width: 100,
        padding: 10,
        align: 'center'
    });

    group.add(rect);
    group.add(tableText);
    layer.add(group);

    return group;
}

// Función para dibujar una línea punteada entre dos puntos
function drawDottedLine(x1, y1, x2, y2) {
    var line = new Konva.Line({
        points: [x1, y1, x2, y2],
        stroke: 'black',
        strokeWidth: 2,
        dash: [10, 5]
    });
    layer.add(line);
    return line;
}

// Obtener entidades de la base de datos
fetch('http://localhost:3000/App/ConectionBD/Fetch/Connection.php') // Ajusta esta URL según la ubicación de tu archivo PHP
    .then(response => response.json())
    .then(entidades => {
        var tables = [];
        var startX = 50;
        var startY = 50;
        var spacingX = 150; // Espacio horizontal entre tablas

        entidades.forEach((entidad, index) => {
            var table = createTable(startX + index * spacingX, startY, entidad.Entidades); // Ajusta según el nombre del campo
            tables.push(table);
        });

        // Dibujar líneas punteadas entre las tablas
        var lines = [];
        for (var i = 0; i < tables.length - 1; i++) {
            var line = drawDottedLine(tables[i].x() + 100, tables[i].y() + 25, tables[i + 1].x(), tables[i + 1].y() + 25);
            lines.push(line);
        }

        // Función para actualizar las líneas
        function updateLines() {
            for (var i = 0; i < lines.length; i++) {
                lines[i].points([tables[i].x() + 100, tables[i].y() + 25, tables[i + 1].x(), tables[i + 1].y() + 25]);
            }
            layer.batchDraw();
        }

        // Agregar eventos de arrastre a las tablas
        tables.forEach(table => {
            table.on('dragmove', updateLines);
        });

        // Dibujar la capa
        layer.draw();
    })
    .catch(error => console.error('Error:', error));