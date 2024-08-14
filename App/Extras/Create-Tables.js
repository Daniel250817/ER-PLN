// Crear el escenario
var stage = new Konva.Stage({
    container: 'canvas-container', // ID del contenedor
    width: window.innerWidth/2, // Ajusta el tamaño según sea necesario
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

// Crear algunas "tablas"
var table1 = createTable(50, 50, 'Tabla 1');
var table2 = createTable(200, 50, 'Tabla 2');
var table3 = createTable(350, 50, 'Tabla 3');

// Dibujar líneas punteadas entre las tablas
var line1 = drawDottedLine(table1.x() + 100, table1.y() + 25, table2.x(), table2.y() + 25);
var line2 = drawDottedLine(table2.x() + 100, table2.y() + 25, table3.x(), table3.y() + 25);

// Función para actualizar las líneas
function updateLines() {
    line1.points([table1.x() + 100, table1.y() + 25, table2.x(), table2.y() + 25]);
    line2.points([table2.x() + 100, table2.y() + 25, table3.x(), table3.y() + 25]);
    layer.batchDraw();
}

// Agregar eventos de arrastre a las tablas
table1.on('dragmove', updateLines);
table2.on('dragmove', updateLines);
table3.on('dragmove', updateLines);

// Dibujar la capa
layer.draw();