<!doctype html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">
    <title>Prime-DevKit</title>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    @livewireStyles
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/sort@3.x.x/dist/cdn.min.js"></script>
    <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />
    @vite('modules/prime/resources/css/app.css', 'vendor/prime')

    {{--    <link rel="preconnect" href="https://fonts.googleapis.com">--}}
    {{--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
    {{--    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">--}}

</head>
<body class="h-full bg-[#fafbfe]" >

<div x-cloak x-data="{ showMenu: false }" @keydown.window.escape="showMenu = false">


    <!-- Static sidebar for desktop -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-yankees-900 px-6 pb-4">

        </div>
    </div>

    <div class="lg:pl-64">
        <div class="z-10 sticky top-0 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-2 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
            <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="showMenu = !showMenu">
                <span class="sr-only">Open sidebar</span>
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <!-- Separator -->
            <div class="h-6 w-px bg-gray-900/10 lg:hidden" aria-hidden="true"></div>



        <main class="p-4">

            <div class="">
                <div>
                    <livewire:vehicle-table />
                </div>

            </div>
        </main>
    </div>
    <x-prime::notification></x-prime::notification>
</div>
<livewire:prime::modal></livewire:prime::modal>
<livewire:prime::slide-over></livewire:prime::slide-over>

@stack('stripe')
<script>
    var collapsedGroups = JSON.parse(
        localStorage.getItem('collapsedGroups'),
    )

    if (collapsedGroups === null || collapsedGroups === 'null') {
        localStorage.setItem(
            'collapsedGroups',
            JSON.stringify([]),
        )
    }

    collapsedGroups = JSON.parse(
        localStorage.getItem('collapsedGroups'),
    )
</script>
<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC06OfrV-NbtEFXZ_K--EkCbQSgVF2KHsc&libraries=places&language=en&callback=googleReady"></script>
<script>
    function googleReady() {
        document.dispatchEvent(new Event('google:init'));
    }
</script>
<script src="https://unpkg.com/@popperjs/core@2"></script>
<script src="https://unpkg.com/tippy.js@6"></script>
<script defer src="https://unpkg.com/@alpinejs/ui@3.13.3-beta.4/dist/cdn.min.js"></script>
<script defer src="https://unpkg.com/@alpinejs/focus@3.13.3/dist/cdn.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/mask@3.x.x/dist/cdn.min.js"></script>
@livewireScripts
@stack('js')
@vite('modules/prime/resources/js/app.js', 'vendor/prime')
@yield('js')

@if (session()->has('flash'))
    {{--    <div x-data="redirectFlashNotification"></div>--}}
@endif
</body>
</html>
