<div class="header mb-3">
    <div class="left">
        <div class="logo">
            <h3>{{__('metrics.challenge')}}</h3>
            <img class="image" src="{{ asset('img/logo-broobe.svg') }}" alt="Broobe">
        </div>
        <div>
            <h3>{{ __('metrics.byJuanSueldo') }}</h3>
        </div>
    </div>
    <div class="right">
        <a href="{{route('home')}}" class="@yield('active-run') link" for="home">{{__('metrics.run')}}</a>
        <a href="{{route('history')}}" class="@yield('active-history') link" for="history">{{__('metrics.history')}}</a>
        <input id="toggle-mode" class="theme-checkbox" type="checkbox"></input>
        <div class="dropdown">
            <button class="dropbtn">{{__('metrics.language')}} <i class="fas fa-caret-down"></i></button>
            <div class="dropdown-content">
                @foreach(config('app.locales') as $lang => $language)
                <a href="{{ route('lang.switch', $lang) }}">{{ $language }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>