<input id="{{ $field->getID() }}"
    name="{{ $field->name}}"
    type="{{ $field->type }}"
    class="@error($field->name) is-invalid @enderror w-full"
    value="{{ $f->getFormValue() }}"
    >
 
