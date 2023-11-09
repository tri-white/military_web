@extends('shared/layout')

@push('css')
<style>
    .center-header {
        margin-top: 90px;
        margin-bottom:90px;
    }

    .custom-card {
        border-radius: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        width: 250px;
        height: 275px; /* Increased height for more content */
        text-align: justify;
        background-color: #2B2C27;
        color: white;
    }

    .card-text {
        font-size: 16px;
        text-align: justify;
        word-wrap: break-word;
        margin: auto;
        line-height:1.75rem;
    }

    .card-img {
        width: 100px; /* Set a fixed width for the icons */
        height: 100px; /* Set a fixed height for the icons */
        margin-bottom:16px;
    }
</style>
@endpush

@section('content')
<main>
                @php 
                  $page = 1;
                  $search = "null";
                  $cat = "all";
                  $sort = "date-desc";
              @endphp
    <h1 class="center-header text-center text-white">Ласкаво просимо!</h1>

    <div class="cards-container container mt-5 d-flex justify-content-between align-items-center text-center">
        <div class="row col-12 d-flex justify-content-between align-items-center text-center">
            <div class="col-4">
                <div class="card custom-card mx-auto">

                    <a  href="{{ route('fundraising-posts', ['page' => $page, 'searchKey'=>$search, 'category'=>$cat,'sort'=>$sort]) }}" class="link-dark text-decoration-none text-white">
                    <div class="card-body text-center">
                        <img src="{{ asset('icon1.png') }}" alt="Image 1" class="card-img">
                        <p class="card-text">Допомагайте військовим збирати кошти на їх потреби, та переглядайте прогрес накопичення коштів</p>
                    </div>
                    </a>
                </div>
            </div>
            <div class="col-4">
                <div class="card custom-card mx-auto">
                    <div class="card-body text-center">
                        <a  href="{{ route('lot-posts', ['page' => $page, 'searchKey'=>$search, 'category'=>$cat,'sort'=>$sort]) }}" class="link-dark text-decoration-none text-white">

                            <img src="{{ asset('icon2.png') }}" alt="Image 2" class="card-img">
                            <p class="card-text">Переглядайте оголошення волонтерів, які готові віддати необхідні військовим речі</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-4">
                <div class="card custom-card mx-auto">
                    <div class="card-body text-center">
                        <a  href="{{ route('ask-posts', ['page' => $page, 'searchKey'=>$search, 'category'=>$cat,'sort'=>$sort]) }}" class="link-dark text-decoration-none text-white">
                            <img src="{{ asset('icon3.png') }}" style="width:175px;" alt="Image 3" class="card-img">
                            <p class="card-text">Переглядайте оголошення військових про їх потреби, та надсилайте їм свої пропозиції</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('js')
</script>
