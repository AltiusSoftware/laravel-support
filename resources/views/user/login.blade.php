<x-altius::layout-login>
    <div class="w-1/3 mx-auto bg-gray-100  p-4">
        @include('altius::forms.form')

        <div class=" p-2 text-white text-center" style="background: #025a6b;">
            © {{ now()->format('Y') }} {{ config('app.name') }}
        </div>
    </div>
</x-altius::layout-login>