@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-medium text-md', 'style' => 'color: rgba(255,255,255,0.8); margin-bottom: 10px;']) }}>
    {{ $value ?? $slot }}
</label>

