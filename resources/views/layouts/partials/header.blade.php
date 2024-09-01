<div class="header mb-3">
    <div class="left">
        <div class="logo">
            <h3> Challenge</h3>
            <img class="image" src="{{ asset('img/logo-broobe.svg') }}" alt="Broobe">
        </div>
        <div>
            <h3>By Juan Sueldo</h3>
        </div>
    </div>
    <div class="right">
        <a href="{{route('home')}}" class="@yield('active-run') link" for="home">Run Metric</a>
        <a href="{{route('history')}}" class="@yield('active-history') link" for="history">Metric History</a>
        <input id="toggle-mode" class="theme-checkbox" type="checkbox"></input>
    </div>
</div>