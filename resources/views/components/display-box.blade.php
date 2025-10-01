@props(['label'=>null, 'slot'=>' '])
<div>
    <div class="text-left">
        <label class="text-sm font-bold dark:text-gray-400">{{$label}}</label>
        <span class="placeholder-secondary-400 dark:bg-secondary-800 dark:text-secondary-400 dark:placeholder-secondary-500 border border-secondary-300 focus:ring-primary-500 focus:border-primary-500 dark:border-secondary-600 form-input sm:text-sm rounded-md transition ease-in-out duration-100 focus:outline-none shadow-sm form-control border-solid w-full block bg-[#fbfbfb] p-1 text-left">{{$slot}} &nbsp;</span>
    </div>
    {{$attributes}}
</div>
