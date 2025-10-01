@if($menuLocation == 'normal')
    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
        @foreach($menus as $menu)

            @if((!is_null(Auth::user()) && Auth::user()?->can($menu['permission'])) || $menu['permission'] == 'All' || ($menu['permission'] == 'Guest' && is_null(Auth::user())))
                @if(isset($menu['SubMenu']))
                    {{--            SubMenu--}}
                    <div
                        class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out cursor-pointer">
                        <x-menu-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                {{ __($menu['name']) }}
                            </x-slot>
                            <x-slot name="content">
                                @foreach($menu['SubMenu'] as $submenu)
                                    @can($submenu['permission'])
                                        <x-dropdown-link href="{{ route($submenu['route']) }}" :active="request()->routeIs($submenu['route'])">
                                            {{ __($submenu['name']) }}
                                        </x-dropdown-link>
                                    @endcan
                                @endforeach
                            </x-slot>
                        </x-menu-dropdown>
                    </div>
                @else
                    @if((!is_null(Auth::user()) && Auth::user()?->can($menu['permission'])) || $menu['permission'] == 'All' || ($menu['permission'] == 'Guest' && is_null(Auth::user())))
                        <div
                            @if(request()->routeIs($menu['route']))
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out"
                            @else
                                class="inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out"
                            @endif >
                            <a href="{{ route($menu['route']) }}">
                                {{ __($menu['name']) }}
                            </a>
                        </div>
                    @endif
                @endif
            @endif
        @endforeach
        <div></div>
    </div>
@else
    <div class="pt-2 pb-3 space-y-1">

        @foreach($menus as $menu)
            @if((!is_null(Auth::user()) && Auth::user()?->can($menu['permission'])) || $menu['permission'] == 'All' || ($menu['permission'] == 'Guest' && is_null(Auth::user())))
                @if(isset($menu['SubMenu']))
                    <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                        <div class="ps-6 font-medium text-base text-gray-800 dark:text-gray-200">{{ __($menu['name']) }}</div>
                        @foreach($menu['SubMenu'] as $submenu)
                            <div
                                @if(request()->routeIs($submenu['route']))
                                    class="block w-full ps-9 pe-4 py-2 border-l-4 border-indigo-400 dark:border-indigo-600 text-start text-base font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 focus:outline-none focus:text-indigo-800 dark:focus:text-indigo-200 focus:bg-indigo-100 dark:focus:bg-indigo-900 focus:border-indigo-700 dark:focus:border-indigo-300 transition duration-150 ease-in-out"
                                @else
                                    class="block w-full ps-9 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out"
                                @endif >
                                <a href="{{ route($submenu['route'])??'' }}">
                                    {{ __($submenu['name']) }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    @if((!is_null(Auth::user()) && Auth::user()?->can($menu['permission'])) || $menu['permission'] == 'All' || ($menu['permission'] == 'Guest' && is_null(Auth::user())))
                        <div
                            @if(request()->routeIs($menu['route']))
                                class="block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 dark:border-indigo-600 text-start text-base font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 focus:outline-none focus:text-indigo-800 dark:focus:text-indigo-200 focus:bg-indigo-100 dark:focus:bg-indigo-900 focus:border-indigo-700 dark:focus:border-indigo-300 transition duration-150 ease-in-out"
                            @else
                                class="block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out"
                            @endif >
                            <a href="{{ route($menu['route'])??'' }}">
                                {{ __($menu['name']) }}
                            </a>
                        </div>
                    @endif
                @endif
            @endif
        @endforeach

    </div>
@endif
