    <input id="{{ $field->getID() }}"
        disabled
        readonly
        name="id"
        type="text"
        class="@error($field->name) is-invalid @enderror w-full"
        value="{{ $field->getFormValue() }}"
    >
