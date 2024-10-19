<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0"
    aria-label="Sidebar">
    <div class="h-full px-3 py-4 overflow-y-auto bg-slate-100">
        <a href="" class="flex items-center justify-center mb-5">
            <img src="" class="me-3" />
        </a>
        <ul class="space-y-2 font-medium">
            <li>
                <a href="/donation" class="{{ str_contains(Request::url(),'donation')?"bg-tosca-600 text-white":"" }} flex items-center p-2 rounded-lg hover:bg-tosca-600 hover:text-white group">
                    <span class="ms-3">Donation</span>
                </a>
            </li>
            <li>
                <a href="/sponsor" class="{{ str_contains(Request::url(),'sponsor')?"bg-tosca-600 text-white":"" }} flex items-center p-2 rounded-lg hover:bg-tosca-600 hover:text-white group">
                    <span class="ms-3">Sponsor</span>
                </a>
            </li>
            <li>
                <a href="/hero" class="{{ str_contains(Request::url(),'hero')?"bg-tosca-600 text-white":"" }} flex items-center p-2 rounded-lg hover:bg-tosca-600 hover:text-white group">
                    <span class="ms-3">Heroes</span>
                </a>
            </li>
            <li>
                <a href="/food" class="{{ str_contains(Request::url(),'food')?"bg-tosca-600 text-white":"" }} flex items-center p-2 rounded-lg hover:bg-tosca-600 hover:text-white group">
                    <span class="ms-3">Foods</span>
                </a>
            </li>
            <li>
                <a href="/finance" class="{{ str_contains(Request::url(),'finance')?"bg-tosca-600 text-white":"" }} flex items-center p-2 rounded-lg hover:bg-tosca-600 hover:text-white group">
                    <span class="ms-3">Finance</span>
                </a>
            </li>
            <li>
                <a href="/report" class="{{ str_contains(Request::url(),'report')?"bg-tosca-600 text-white":"" }} flex items-center p-2 rounded-lg hover:bg-tosca-600 hover:text-white group">
                    <span class="ms-3">Reports</span>
                </a>
            </li>
            <li>
                <a href="/media" class="{{ str_contains(Request::url(),'media')?"bg-tosca-600 text-white":"" }} flex items-center p-2 rounded-lg hover:bg-tosca-600 hover:text-white group">
                    <span class="ms-3">Media</span>
                </a>
            </li>
            <li>
                <a href="/logout" class="flex items-center p-2 rounded-lg hover:bg-red-600 hover:text-white group">
                    <span class="ms-3">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

</div>
<div class="block fixed w-full sm:hidden">
    <nav class="bg-white border-gray-200">
        <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="" class="h-8" />
            </a>
            <button id="burger-menu-button" data-collapse-toggle="navbar-default" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-navy-600 rounded-lg md:hidden hover:bg-tosca-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-200"
                aria-controls="navbar-default" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
            <div id="navbar-default" class="hidden fixed top-12 w-full md:w-auto">
                <ul
                    class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md dark:border-gray-700">
                    <li>
                        <a href="/dashboard"
                            class="block py-2 px-3 text-pink-600 rounded hover:bg-tosca-600 hover:text-white md:bg-transparent md:text-blue-700 md:p-0"
                            aria-current="page">Dashboard</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <script>
        document.getElementById('burger-menu-button').addEventListener('click', function() {
            var menu = document.getElementById('navbar-default');
            menu.classList.toggle('hidden');
        });
    </script>


</div>
