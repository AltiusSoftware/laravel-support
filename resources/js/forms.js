let Forms = Forms || {};

window.onload = function(e){
    document.getElementsByTagName('html')[0].classList.add('formsReady');
}



document.addEventListener('submit', e => {
    if (e.target.closest('form[data-ajax]')) {
            e.preventDefault();
            
            
            axios.post(e.target.action,new FormData(e.target))
                .then(Forms.processResponse)
                .catch(function (error) {
                    Forms.processError(error,e.target);
                });          
    }
});

Forms.processError= function(error,form) {
    if(error.response.status==422){
        let data = error.response.data;

        let fields = form.querySelectorAll('p[data-error]');

        fields.forEach(function (i){
            if(i.dataset.error=='__form') {
                i.innerHTML=data.message || '';
            }else {
                i.innerHTML = data.errors[i.dataset.error] || '';
            }
        });

    } else  
        alert('An Error has Occured');
}
 

Forms.processResponse = function(res, form) {
    if(res.data.redirect) {
        window.location.href= res.data.redirect; 
     }
     // alert/toasts
     // messages
     // calback



}


