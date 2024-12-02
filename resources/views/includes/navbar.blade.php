<!-- resources/views/includes/navbar.blade.php -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="#">AgenceImmobiliere</a>
        <div class="ml-auto">
            @auth
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle d-flex align-items-center" data-toggle="dropdown">
                        <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('default-user.png') }}" 
                             alt="Photo de profil" 
                             class="rounded-circle" 
                             width="40" 
                             height="40">
                        <span class="ml-2">{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('profile') }}">Mon Profil</a>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Déconnexion
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
            @endauth
        </div>
    </div>
</nav>
