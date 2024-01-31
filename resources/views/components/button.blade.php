<button {{ $attributes->merge(['type' => 'submit', 'class' => 'px-4 py-2 border bg-white border-black text-black rounded-md hover:bg-gray-200 hover:text-black transition duration-300 ease-in-out']) }}>
    {{ $slot }}
</button>
