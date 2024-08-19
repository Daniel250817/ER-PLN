<?php include __DIR__ . '/Extras/Functions.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="Styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.jsdelivr.net/npm/konva@8.3.5/konva.min.js"></script>
    <title>Diagram ER</title>
</head>
<body class="<?php echo $dark_mode ? 'dark-mode' : ''; ?>">
    <div class="header">
        <h1>Diagrama ER</h1>
        <div class="Toogle" onclick="window.location.href='?toggle_dark_mode=1'">
            <p>Dark Mode</p>
            <span class="material-symbols-outlined">dark_mode</span>
        </div>
    </div>

    <div class="main-content">
        <div class="Container-Left">
            <div class="Titulo"> </div>
                <textarea id="sql-input" placeholder="Escribe tu comando SQL para empezar a diagramar" rows="10"></textarea>
              <button id="generate-diagram" onclick="generateERDiagram()">Generar Diagrama ER</button>
        </div> 
            <div id="canvas-container">
                <canvas id="myCanvas" width="800" height="600"></canvas>
        </div>
    </div>
    
       
    <footer>
        <div class="Footer-Container">
            <h2>Derechos reservados</h2>
        </div>  
        <div class="Footer-copy">
            <h4>Estudiantes / Autores</h4>
            <h5>Julio Daniel Guardado Martínez | Wilson Alexander Portillo Marroquín</h5>
            <h5>Manuel Alejandro Pérez Ramírez | Francisco Alexander Arbaiza Orellana</h5>
        </div> 
    </footer> 
</body>
</html>
 

 <script>
    let tables = {}; // Almacena las tablas generadas
    let relationships = []; // Almacena las relaciones entre tablas

function generateERDiagram() {
    const sqlCode = document.getElementById("sql-input").value;
    const canvasContainer = document.getElementById('canvas-container');

    const stage = Konva.stages.length > 0 ? Konva.stages[0] : new Konva.Stage({
        container: 'canvas-container',
        width: canvasContainer.clientWidth,
        height: canvasContainer.clientHeight,
    });

    const layer = stage.children.length > 0 ? stage.children[0] : new Konva.Layer();
    if (stage.children.length === 0) stage.add(layer);

    // Regex para capturar tablas y columnas con tipo de dato, longitud y PK/FK
    const tableRegex = /CREATE TABLE (\w+) \(([\s\S]+?)\);/g;
    // Regex para capturar claves foráneas
    const fkRegex = /FOREIGN KEY \((\w+)\) REFERENCES (\w+)\((\w+)\)/g;
    // Regex para capturar PK
    const pkRegex = /PRIMARY KEY \(([\w\s,]+)\)/;

    let match;
    let yPos = Object.keys(tables).length > 0 ? Math.max(...Object.values(tables).map(t => t.yPos)) + 100 : 50;

    while ((match = tableRegex.exec(sqlCode)) !== null) {
        const tableName = match[1];
        const columnsData = match[2].trim().split(',').map(col => col.trim());
        const columns = [];

        // Extraer columnas con detalles
        columnsData.forEach(col => {
            const [name, type, ...rest] = col.split(/\s+/);
            const details = rest.join(' ');
            columns.push({ name, type, details });
        });

        // Detectar Primary Key
        const pkMatch = pkRegex.exec(match[2]);
        const primaryKeys = pkMatch ? pkMatch[1].split(',').map(pk => pk.trim()) : [];

        if (!tables[tableName]) {
            const group = new Konva.Group({
                x: 50,
                y: yPos,
                draggable: true // Hacer todo el grupo movible
            });

            // Dibuja un rectángulo para cada tabla
            const rect = new Konva.Rect({
                x: 0,
                y: 0,
                width: 250,
                height: columns.length * 30 + 60, // Altura basada en el número de columnas
                fill: 'white',
                stroke: 'black',
                strokeWidth: 2,
                cornerRadius: 5,
            });

            // Dibuja el nombre de la tabla
            const tableNameText = new Konva.Text({
                x: -17,
                y: 0,
                text: tableName,
                fontSize: 16,
                fontFamily: 'Calibri',
                fill: 'black',
                fontStyle: 'bold',
                width: 280, // Ajuste del ancho del texto
                padding: 10,
                align: 'center'
            });

            // Línea divisora bajo el nombre de la tabla
            const divider = new Konva.Line({
                points: [0, 35, 250, 35],
                stroke: 'black',
                strokeWidth: 2,
            });

            group.add(rect);
            group.add(tableNameText);
            group.add(divider);

            // Dibuja las columnas con tipo, longitud, y PK/FK
            columns.forEach((column, index) => {
                const isPrimaryKey = primaryKeys.includes(column.name);
                const columnTextNode = new Konva.Text({
                    x: 0,
                    y: 40 + index * 30,
                    text: `${column.name} ${column.type} ${column.details} ${isPrimaryKey ? 'PK' : ''}`, // Muestra nombre, tipo, longitud, PK/FK
                    fontSize: 14,
                    fontFamily: 'Calibri',
                    fill: 'black',
                    width: 280, // Ancho del texto
                    padding: 10,
                    align: 'left',
                });
                group.add(columnTextNode);
            });

            layer.add(group);
            tables[tableName] = { yPos: yPos, group: group };

            yPos += columns.length * 30 + 80;
        }
    }

    // Captura las claves foráneas
    while ((match = fkRegex.exec(sqlCode)) !== null) {
        const column = match[1];
        const foreignTable = match[2];
        const foreignColumn = match[3];

        // Solo añade la relación si las tablas involucradas existen
        if (tables[foreignTable]) {
            const sourceTable = Object.keys(tables).find(table => {
                return tables[table].group.find(node => node.text() === column);
            });

            if (sourceTable && foreignTable !== sourceTable) {
                const sourceGroup = tables[sourceTable].group;
                const targetGroup = tables[foreignTable].group;

                // Calcular las posiciones para dibujar la línea
                const sourcePos = sourceGroup.getClientRect();
                const targetPos = targetGroup.getClientRect();

                const startX = sourcePos.x + sourcePos.width / 2;
                const startY = sourcePos.y + sourcePos.height;
                const endX = targetPos.x + targetPos.width / 2;
                const endY = targetPos.y;

                drawDottedLine(startX, startY, endX, endY);
            }
        }
    }

    layer.draw();
}

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

</script>



<script>
    const canvasContainer = document.getElementById('canvas-container');
    const canvas = document.getElementById('myCanvas');
    const ctx = canvas.getContext('2d');

    let isDragging = false;
    let startX, startY;
    let offsetX = 0, offsetY = 0;
    let zoom = 1;

    // Dibujar algo en el canvas para la demostración
    function draw() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.save();
        ctx.scale(zoom, zoom);
        ctx.translate(offsetX, offsetY);
        ctx.fillStyle = "red";
        ctx.fillRect(50, 50, 200, 200);  // Ejemplo: Dibujar un cuadrado rojo
        ctx.restore();
    }

    // Evento para iniciar el arrastre
    canvas.addEventListener('mousedown', (e) => {
        isDragging = true;
        startX = e.clientX - offsetX;
        startY = e.clientY - offsetY;
        canvas.style.cursor = 'grabbing';  // Cambiar cursor a agarrando cuando se arrastra
    });

    // Evento para mover el contenido mientras arrastras
    canvas.addEventListener('mousemove', (e) => {
        if (isDragging) {
            offsetX = (e.clientX - startX) / zoom;
            offsetY = (e.clientY - startY) / zoom;
            draw();
        }
    });

    // Evento para finalizar el arrastre
    canvas.addEventListener('mouseup', () => {
        isDragging = false;
        canvas.style.cursor = 'grab';  // Volver al cursor de mano abierta al soltar
    });

    // También finaliza el arrastre si el mouse sale del canvas
    canvas.addEventListener('mouseleave', () => {
        isDragging = false;
        canvas.style.cursor = 'grab';
    });

    // Evento para hacer zoom con el scroll del mouse
    canvasContainer.addEventListener('wheel', (e) => {
        e.preventDefault();
        const zoomSpeed = 0.1;
        if (e.deltaY < 0) {
            zoom += zoomSpeed; // Zoom in
        } else {
            zoom -= zoomSpeed; // Zoom out
            if (zoom < 0.1) zoom = 0.1; // Evitar zoom negativo
        }
        draw();
    });

    // Establecer el cursor inicial
    canvas.style.cursor = 'grab';

    // Dibujar contenido inicial
    draw();
</script>