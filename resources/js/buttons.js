
document.addEventListener('click', e => {
    if (e.target.closest('a[data-post]')) {

        e.preventDefault();
        if( (e.target.dataset.post=='') || confirm(e.target.dataset.post)) {
            axios.post(e.target.href)
            .then(function(r) {
                Forms.processResponse(r);

            });
        }

    }
});
