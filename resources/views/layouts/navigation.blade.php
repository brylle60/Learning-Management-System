@php use Illuminate\Support\Str; @endphp

<nav x-data="{ open: false }" class="border-b border-slate-200 bg-white/80 backdrop-blur">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-2 rounded-full bg-gradient-to-r from-indigo-600 to-blue-500 px-3 py-1 text-sm font-semibold text-white shadow-sm">
                    <x-application-logo class="block h-6 w-auto fill-current text-white" />
                    <span>LMS</span>
                </a>

                <div class="hidden items-center gap-1 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    <x-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">
                        {{ __('Courses') }}
                    </x-nav-link>
                    @if(Auth::check() && Auth::user()->isInstructor())
                        <x-nav-link :href="route('instructor.dashboard')" :active="request()->routeIs('instructor.dashboard')">
                            {{ __('Instructor') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden items-center gap-3 sm:flex">
                @auth
                    @if(Auth::user()->isInstructor())
                        <a href="{{ route('courses.create') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500">
                            + New course
                        </a>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center gap-2 rounded-full bg-slate-100 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200 focus:outline-none">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-indigo-600 text-xs font-semibold uppercase text-white">
                                    {{ Str::substr(Auth::user()->name, 0, 2) }}
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-slate-500">Account</div>
                                </div>
                                <svg class="h-4 w-4 text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.088l3.71-3.857a.75.75 0 111.08 1.04l-4.25 4.417a.75.75 0 01-1.08 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-medium text-slate-700 transition hover:text-slate-900">
                        Sign in
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-full bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500">
                        Get Started
                    </a>
                @endauth
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center rounded-md p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700 focus:bg-slate-100 focus:text-slate-700">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden border-t border-slate-200 sm:hidden">
        <div class="space-y-1 px-4 pt-2 pb-3">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('courses.index')" :active="request()->routeIs('courses.*')">
                {{ __('Courses') }}
            </x-responsive-nav-link>
            @if(Auth::check() && Auth::user()->isInstructor())
                <x-responsive-nav-link :href="route('instructor.dashboard')" :active="request()->routeIs('instructor.dashboard')">
                    {{ __('Instructor') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('courses.create')" :active="request()->routeIs('courses.create')">
                    {{ __('Create course') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="border-t border-slate-200 pt-4 pb-4">
            @auth
                <div class="px-4">
                    <div class="text-base font-semibold text-slate-900">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-slate-500">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="space-y-1 px-4">
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Sign in') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('Get Started') }}
                    </x-responsive-nav-link>
                </div>
            @endauth
        </div>
    </div>
</nav>