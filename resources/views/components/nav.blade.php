<nav class="navbar bg-primary text-primary-content shadow-sm">
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </div>
            <ul tabindex="-1" class="menu menu-md dropdown-content bg-base-100  text-base-content rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li><a href="/">My Page</a></li>
                <li><a href="/codex">Codex</a></li>
                <li><a href="/gacha">Gacha</a></li>
                <li><a href="/guide">Guide</a></li>
                <li><a href="/about">About</a></li>
            </ul>
        </div>
    </div>

    <div class="navbar-end">
        <a href="/" class="btn w-50 bg-primary border-none">
            <img src="{{ asset('/storage/images/logo.png') }}" alt="logo">
        </a>
    </div>
</nav>