<header>
    <nav class="navbar navbar-expand-sm navbar-light shadow-lg" style="background-color: #2B2C27;">
        <div class="container">
            <a class="navbar-brand fs-3 text-white" href="{{ url('/') }}">Military Trade</a>
            @php 
                  $page = 1;
                  $search = "null";
                  $cat = "all";
                  $sort = "price-desc";
              @endphp
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav col-12 d-flex justify-content-between fs-5">
                    <div class="d-flex ms-5">
                        <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0 dropdown">
                       
                        <a href="{{ route('fundraising-posts', ['page' => $page, 'searchKey'=>$search, 'category'=>$cat,'sort'=>$sort]) }}" class="text-decoration-none text-white">
                                Збори коштів
                            </a>
                        </li>
                        <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0 dropdown">
                            <a href="{{ route('lot-posts', ['page' => $page, 'searchKey'=>$search, 'category'=>$cat,'sort'=>$sort]) }}" class="text-decoration-none text-white">
                                Лоти
                            </a>
                        </li>
                        <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0 dropdown">
                            <a href="{{ route('ask-posts', ['page' => $page, 'searchKey'=>$search, 'category'=>$cat,'sort'=>$sort]) }}" class="text-decoration-none text-white">
                                Запити військових
                            </a>
                        </li>
                    </div>
                    <div class="d-flex text-white">
                        @if(Auth::check())
                        <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0 dropdown">
                            <a class="nav-link dropdown-toggle pe-auto text-white" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0;">
                               +
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::user()->role_id === 1 || Auth::user()->role_id===3)
                                <li><a class="dropdown-item" href="{{ route('form_post-bid') }}">Створити лот</a></li>
                                @endif
                                @if(Auth::user()->role_id === 2 || Auth::user()->role_id===3)
                                <li><a class="dropdown-item" href="{{ route('form_post-ask') }}">Створити оголошення на пошук предметів</a></li>
                                <li><a class="dropdown-item" href="{{ route('form_post-fundraising') }}">Створити оголошення на збір коштів</a></li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        <li class="nav-item mx-lg-2 mx-md-1 mx-sm-0 dropdown">
                            <a class="nav-link dropdown-toggle pe-auto text-white" id="navbarDropdown" role="button"
                               data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0;">
                               @if(Auth::check())
                                   {{ Auth::user()->email }}
                               @else
                                   Профіль
                               @endif
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                @if(Auth::check())
                                    <li><a class="dropdown-item" href="{{ route('profile', Auth::user()->id) }}">Мій профіль</a></li>
                                    @if(Auth::user()->role_id === 1)
                                    <li><a class="dropdown-item" href="{{ route('verification') }}">Верифікуватися як військовий</a></li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Вихід з профілю</a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('loginView') }}">Авторизація</a></li>
                                    <li><a class="dropdown-item" href="{{ route('registrationView') }}">Реєстрація</a></li>
                                @endif
                            </ul>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </nav>
</header>
