@props(['type' => 'text', 'name', 'value'])

<div class="form-group">

<x-forms.label name="{{ $name}}" />

<input
    type="{{ $type }}"
    class="form-control"
    id="{{ $name }}"
    name="{{ $name }}"
    value="{{  $value ?? old($name) }}"
/>

@error($name)
    <span class="text-sm text-danger">{{ $message }}</span>
@enderror

</div>
