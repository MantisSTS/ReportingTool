@if(Auth::check())
{{-- Left-Nav --}}
<!-- <div class="row"> -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark static-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('dashboard.index') }}">Reporter</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-atuo">
                        <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteNamed('dashboard.index') ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                            <span class="oi oi-person"></span>Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteNamed('client.index') ? 'active' : '' }}" href="{{ route('client.index') }}">
                            Clients <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteNamed('report.index') ? 'active' : '' }}" href="{{ route('report.index') }}">
                            Reporting <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteNamed('vulnerability.index') ? 'active' : '' }}" href="{{ route('vulnerability.index') }}">
                            Vuln DB <span class="sr-only">(current)</span>
                        </a>
                    </li>
                </ul>
            </div>
            @guest
            {{--  --}}
            @else
            <div class="pull-right">
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <input type="submit" name="logout" id="logout" value="Logout" class="btn btn-default"/>
                </form>
            </div>
            @endguest
        </div>
    </nav>
<!-- </div> -->
@endif
{{-- End of Left-Nav --}}
