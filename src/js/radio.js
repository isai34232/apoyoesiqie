document.querySelectorAll('.question').forEach((question, questionIndex) => {
    const optionLabels = ['a', 'b', 'c', 'd'];

    question.querySelectorAll('label').forEach((label, index) => {
        // Asigna la letra correspondiente a cada label
        const optionLetter = optionLabels[index];
        label.innerHTML = `${optionLetter}. ${label.innerHTML}`;

        // Agrega el listener para manejar la selección de opciones
        label.addEventListener('click', function(e) {
            if (e.target.tagName === 'INPUT' && e.target.type === 'radio') {
                // Remover la clase 'selected' de todos los labels en esta pregunta
                question.querySelectorAll('label').forEach(label => label.classList.remove('selected'));
        
                // Añadir la clase 'selected' al label que contiene el radio button seleccionado
                e.target.parentElement.classList.add('selected');
            }
        });
    });
});
