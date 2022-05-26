@aware(['type' => 'blue'])
<div {{ $attributes->merge(['class' => "p-2 bg-$type-200 clear-both"]) }}>
    <span class="text-md font-bold text-gray-800 clear-both">
        {{ $slot}} 
        
    </span>
    @isset($actions)
    <span class="float-right">{{ $actions }}</span>
    @endif
    <div class="clear-both"></div>
</div>

