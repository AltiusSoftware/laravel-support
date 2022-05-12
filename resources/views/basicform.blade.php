<x-altius::layout-login>
<div class="w-1/3 mx-auto bg-gray-100  p-4">
    
    @include('altius::forms.form')asdf

    {!! messages()->showAll() !!}

    <div class=" p-4 text-white text-center" style="background: #025a6b;">
    © {{ now()->format('Y') }} {{ config('app.name') }} | All Rights Reserveddd
  </div>

asdf
</div>

</x-altius::layout-login>