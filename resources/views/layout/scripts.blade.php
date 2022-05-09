<script src="{{ mix('/js/app.js') }}"></script>
@stack('scripts')
<script>
    window.addEventListener('DOMContentLoaded', function(event){
      @stack('onload')
    });
    
</script>