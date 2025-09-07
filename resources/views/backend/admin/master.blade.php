<!DOCTYPE html>
<html :class="{ 'theme-dark': dark }" x-data="data()" lang="en">
@include('backend.admin.partials.head')

<body>
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900" :class="{ 'overflow-hidden': isSideMenuOpen }">
        <!-- Desktop sidebar -->
        @include('backend.admin.partials.sidebar')
        <!-- Mobile sidebar -->
        <!-- Backdrop -->
        <div class="flex flex-col flex-1 w-full">
            @include('backend.admin.partials.navbar')
            <main class="h-full overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>
    @include('backend.admin.partials.scripts')
</body>

</html>
