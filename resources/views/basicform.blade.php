<x-altius::layout-login>
<div class="w-1/3 mx-auto bg-gray-300 mt-16 p-12">
    
    @include('altius::forms.form')

    {!! messages()->showAll() !!}

    <div class=" p-4 text-white text-center" style="background: #025a6b;">
    © {{ now()->format('Y') }} {{ config('app.name') }} | All Rights Reserved
  </div>

</div>

</x-altius::layout-login>