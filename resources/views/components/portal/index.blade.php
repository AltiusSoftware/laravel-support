@props(['type' => 'blue'])
<div {{ $attributes->merge(['class' => "bg-white border-2 border-$type-200 hover:border-$type-400"]) }}>
    {{ $slot }}
</div>

{{--
<div    class="bg-indigo-300 bg-green-200 hover:border-blue-400 border-green-200 hover:border-green-400"></div>

{{--
<div    class="bg-indigo-300"></div>
--}}
