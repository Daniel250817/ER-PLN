document.addEventListener('DOMContentLoaded', function() {
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
    function createTable(x, y, text, id) {
        var group = new Konva.Group({
            x: x,
            y: y,
            draggable: true,
            id: id
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

    // Función para extraer datos del SQL input
    function extractDataFromSQL(sqlinput) {
        // Define regular expressions
        const entityRegex = /CREATE TABLE (\w+)/g;
        const attributeRegex = /(\w+) (\w+)(?:\((\d+)\))?/g;

        let entities = {};
        let match;

        // Extract entities
        while ((match = entityRegex.exec(sqlinput)) !== null) {
            const entityName = match[1];
            entities[entityName] = { atributos: [] };
        }

        // Extract attributes
        Object.keys(entities).forEach(entityName => {
            const entityBlockRegex = new RegExp(`CREATE TABLE ${entityName} \\(([^)]+)\\)`, 'g');
            const entityBlockMatch = entityBlockRegex.exec(sqlinput);
            if (entityBlockMatch) {
                const attributesBlock = entityBlockMatch[1];
                let attributeMatch;
                while ((attributeMatch = attributeRegex.exec(attributesBlock)) !== null) {
                    const attributeName = attributeMatch[1];
                    const attributeType = attributeMatch[2];
                    const attributeLength = attributeMatch[3] || null;
                    entities[entityName].atributos.push({
                        nombre: attributeName,
                        tipo: attributeType,
                        longitud: attributeLength
                    });
                }
            }
        });

        return entities;
    }

    // Función para guardar las entidades y atributos en el servidor
    function saveEntitiesToServer(entities) {
        return fetch('http://localhost:3000/App/ConectionBD/Fetch/EndP_InsertSelect.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ entities: entities })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status !== 'success') {
                console.error('Error al guardar las entidades:', data.message);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Función para generar el diagrama ER
    function generateERDiagram() {
        // Obtener entidades y sus relaciones FK de la base de datos
        fetch('http://localhost:3000/App/ConectionBD/Fetch/EndP_Entidades.php', {
            method: 'GET'
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                var entities = data.data;
                var tables = {};
                var startX = 50;
                var startY = 50;
                var spacingX = 150; // Espacio horizontal entre tablas

                // Crear tablas y almacenar en la base de datos
                Object.keys(entities).forEach((idEntidad, index) => {
                    var entidad = entities[idEntidad];
                    var table = createTable(startX + index * spacingX, startY, entidad.Entidades, idEntidad);
                    tables[idEntidad] = table;
                });

                // Dibujar líneas punteadas entre las tablas relacionadas por FK
                var lines = [];
                Object.keys(entities).forEach(idEntidad => {
                    var entidad = entities[idEntidad];
                    entidad.atributos.forEach(atributo => {
                        if (atributo.fkIdEntidades) {
                            var fromTable = tables[idEntidad];
                            var toTable = tables[atributo.fkIdEntidades];
                            if (fromTable && toTable) {
                                var line = drawDottedLine(
                                    fromTable.x() + 100, fromTable.y() + 25,
                                    toTable.x(), toTable.y() + 25
                                );
                                lines.push(line);
                            }
                        }
                    });
                });

                // Función para actualizar las líneas
                function updateLines() {
                    lines.forEach(line => {
                        var points = line.points();
                        var fromTable = tables[points[0]];
                        var toTable = tables[points[2]];
                        if (fromTable && toTable) {
                            line.points([
                                fromTable.x() + 100, fromTable.y() + 25,
                                toTable.x(), toTable.y() + 25
                            ]);
                        }
                    });
                    layer.batchDraw();
                }

                // Función para guardar las relaciones de las tablas
                function saveTableRelations() {
                    var relations = [];
                    Object.keys(entities).forEach(idEntidad => {
                        var entidad = entities[idEntidad];
                        entidad.atributos.forEach(atributo => {
                            if (atributo.fkIdEntidades) {
                                relations.push({
                                    from: idEntidad,
                                    to: atributo.fkIdEntidades
                                });
                            }
                        });
                    });

                    fetch('http://localhost:3000/App/ConectionBD/Fetch/EndP_InsertSelect.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ relations: relations })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status !== 'success') {
                            console.error('Error al guardar las relaciones:', data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }

                // Agregar eventos de arrastre a las tablas
                Object.values(tables).forEach(table => {
                    table.on('dragmove', updateLines);
                    table.on('dragend', function() {
                        saveTableRelations();
                    });
                });

                // Dibujar la capa
                layer.draw();
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Agregar evento click al botón de generar diagrama
    document.getElementById('generate-diagram').addEventListener('click', function() {
        // Ejemplo de SQL input
        const sqlinput = `
        CREATE TABLE Users (
            id INT PRIMARY KEY,
            name VARCHAR(100),
            email VARCHAR(100)
        );
        CREATE TABLE Orders (
            id INT PRIMARY KEY,
            user_id INT,
            amount DECIMAL(10, 2),
            FOREIGN KEY (user_id) REFERENCES Users(id)
        );
        `;

        // Extraer datos del SQL input
        const entities = extractDataFromSQL(sqlinput);

        // Guardar entidades en el servidor y luego generar el diagrama ER
        saveEntitiesToServer(entities).then(() => {
            generateERDiagram();
        });
    });
});