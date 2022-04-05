const deleteForms = document.querySelectorAll('.delete-form');
deleteForms.forEach(form => {
    form.addEventListener('submit', (e) => {
        e.preventDefault();
        const approved = confirm('Sei sicuro di voler eliminare questo post?');
        if (approved) e.target.submit();
    });
});