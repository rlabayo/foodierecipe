@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'text-sm border-[--input-border] dark:border-[--input-border] dark:bg-[--input-dark-bg-color] dark:text-[--secondary] focus:border-[--primary] dark:focus:border-[--secondary] focus:ring-[--primary] dark:focus:ring-[--secondary] rounded-md shadow-sm']) !!}>
