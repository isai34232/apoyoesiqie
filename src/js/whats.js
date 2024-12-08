function addEntry() {
    Swal.fire({
        title: 'Agregar Grupo',
        html: `
            <input id="name" class="swal2-input" placeholder="Enter Grupo">
            <input id="link" class="swal2-input" placeholder="Enter Link">
        `,
        focusConfirm: false,
        preConfirm: () => {
            const name = Swal.getPopup().querySelector('#name').value;
            const link = Swal.getPopup().querySelector('#link').value;
            if (!name || !link) {
                Swal.showValidationMessage('Grupo y Link son requeridos.');
            }
            return { name: name, link: link };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const { name, link } = result.value;
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "../../views/admin/agregarGrupoW.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    location.reload();
                }
            };
            xhr.send("nombre=" + encodeURIComponent(name) + "&enlace=" + encodeURIComponent(link));
        }
    });
}

function editEntry(id) {
    const name = prompt("Edit Grupo:");
    const link = prompt("Edit Link:");

    
    if (name !== null && link !== null) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../views/admin/aditarGrupoW.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                location.reload();
            }
        };
        xhr.send("id=" + id + "&nombre=" + encodeURIComponent(name) + "&enlace=" + encodeURIComponent(link));
    }
}

function deleteEntry(id) {
    if (confirm("¿Estás seguro de que deseas eliminar este grupo?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "../../views/admin/borrarWGrupoW.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                location.reload();
            }
        };
        xhr.send("id=" + id);
    }
}