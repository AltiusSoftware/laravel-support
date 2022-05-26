<textarea 
    id="{{ $field->getID() }}"
    name="{{ $field->name}}"
        
        class="@error($field->name) is-invalid @enderror w-full"
        

>{{ $field->getFormValue() }}</textarea>
{{--
<input id="{{ $field->getID() }}"
        name="{{ $field->name}}"
        type="{{ $field->type }}"
        class="@error($field->name) is-invalid @enderror w-full"
        value="{{ $field->getFormValue() }}"
    >

--}}    