<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-4 py-2 bg-[--white]  border border-2 border-[--primary] rounded-md font-semibold text-xs text-[--primary] uppercase tracking-widest hover:border-[--primary] hover:text-white hover:bg-[--primary] focus:bg-[--white] focus:outline-none focus:ring-2 focus:ring-[--primary] focus:ring-offset-2 dark:focus:ring-offset-[--primary] transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
