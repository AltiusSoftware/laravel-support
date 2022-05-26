<input type="hidden"
       value="0"
       name="{{ $field->name}}"
       >
<input id="{{ $field->getID() }}"
        name="{{ $field->name}}"
        type="{{ $field->type }}"
        
        @if($field->getFormValue() )
            checked 
        @endif
        class="@error($field->name) is-invalid @enderror"
        value="1"
    >