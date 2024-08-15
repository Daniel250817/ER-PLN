// Función para mostrar el modal
    function showModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'flex';
        }
    }

    // Función para cerrar el modal
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    // Mostrar el modal si hay un mensaje de error
    var errorMessage = document.getElementById('errorMessage');
    if (errorMessage && errorMessage.innerText.trim() !== '') {
        showModal('errorModal');
    }

    // Mostrar el modal si hay un mensaje de éxito
    var successMessage = document.getElementById('successMessage');
    if (successMessage && successMessage.innerText.trim() !== '') {
        showModal('successModal');
    }