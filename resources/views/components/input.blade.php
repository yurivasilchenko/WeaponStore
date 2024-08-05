@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'focus:ring-green-500 rounded-md shadow-sm bg-customBlack', 'style' => ' color: white; border: 1px solid rgba(255,255,255,0.7);']) !!}>

