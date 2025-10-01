<button {{ $attributes->merge(['type' => 'submit', 'class' => 'relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 dark:bg-secondary-800 dark:border-gray-600 dark:text-gray-400 hover:dark:bg-secondary-600']) }}>
    {{ $slot->isEmpty()?$label:$slot }}
</button>
