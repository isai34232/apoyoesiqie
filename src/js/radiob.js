document.getElementById('materias-form').addEventListener('change', function(event) {
    if (event.target.name === 'materia_id') {
        // Enviar el formulario automáticamente cuando cambie el radio button
        this.submit();
    }
});