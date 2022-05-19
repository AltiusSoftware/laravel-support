<x-altius::layout-login>
    
        @include('altius::forms.form') 
        <div class="text-center bg-white p-2">
            <a class="btn btn-blue" href="{{ route('password.remind') }}">Forgot your password?</a>
        </div>
    
</x-altius::layout-login>