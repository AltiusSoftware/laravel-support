<x-altius::layout-login>
<div class="w-1/3 mx-auto bg-gray-100 h-96 p-4">
    
    @include('altius::forms.form')

    {!! messages()->showAll() !!}
</div>

</x-altius::layout-login>