document.getElementById('toggleButton').addEventListener('click', function() {
    const sidebar = document.querySelector('.sidebar');
    const content = document.querySelector('.content');
    const icon = document.getElementById('zoom');
    
    sidebar.classList.toggle('hidden');
    content.classList.toggle('expanded');
    
    if (content.classList.contains('expanded')) {
        icon.textContent = ' zoom_out_map ';
    } else {
        icon.textContent = ' zoom_in_map ';
    }
});
