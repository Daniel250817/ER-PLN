document.addEventListener('DOMContentLoaded', function() {
    const combobox = document.getElementById('diagramas-combobox');

    combobox.addEventListener('click', function() {
        fetch('http://localhost:3000/App/ConectionBD/Fetch/EndP_Diagramas.php')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                // Limpiar el combobox antes de llenarlo
                combobox.innerHTML = '<option value="">Seleccione un diagrama</option>';

                // Verificar si se recibieron datos
                if (data.length === 0) {
                    const option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'No hay diagramas disponibles';
                    combobox.appendChild(option);
                } else {
                    // Llenar el combobox con los diagramas obtenidos
                    data.forEach(diagrama => {
                        const option = document.createElement('option');
                        option.value = diagrama.IdDiagrama;
                        option.textContent = diagrama.NombreDiagrama;
                        combobox.appendChild(option);
                    });
                }
            })
            .catch(error => console.error('Error al obtener los diagramas:', error));
    });
});

