@extends('shared/layout')
@push('css')
@section('content')
<h1 class="text-center mt-5 text-white"> Збори коштів </h1>
<div class="container">
    <div class="row text-whit my-5 text-white">
     <div class="col-lg-12 text-center display-5">
         Пошук
     </div>
     <div class="col-lg-8 col-md-10 col-sm-12 mx-auto align-items-center">
         <div class="row d-flex justify-content-center">
             <div class="col-lg-8 col-md-10 col-sm-12 text-center">
                 <form method="post" action="{{ route('search-fundraisings') }}">
                     @csrf
                     <div class="input-group">
                         <input value="{{ ($searchInput!=='null' ? $searchInput : '') }}" name="search-input-key" type="search" class="px-3 form-control"
                             placeholder="Пошук..." aria-label="Search" aria-describedby="search-addon" />
                         <button type="submit" class="btn text-white" style="background-color:#B5C186">Знайти</button>
                     </div>
                     <div class="d-flex justify-content-between mb-2 mt-2">
                         <div class="col-lg-6">
                             <select id="product-category-filter" name="product-category-filter" class="form-select"
                                 aria-label="Категорія" style="width:100%;">
                                 <option value="all" {{ $selectedCategory == 'all' ? 'selected' : '' }}>Всі категорії</option>
                                 @foreach($categories as $category)
										<option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
									@endforeach
                             </select>

                         </div>
                         <div class="col-lg-6">
                             <select id="product-sort" name="product-sort" class="form-select" aria-label="Категорія"
                                 style="width:100%">
                                 <option value="progress-desc" {{ $selectedSort == 'progress-desc' ? 'selected' : '' }}>По прогресу % (↓)</option>
                                 <option value="progress-asc" {{ $selectedSort == 'progress-asc' ? 'selected' : '' }}>По прогресу % (↑)</option>
                                 <option value="summ-desc" {{ $selectedSort == 'summ-desc' ? 'selected' : '' }}>По сумі яка залишилася (грн) (↓)</option>
                                 <option value="summ-asc" {{ $selectedSort == 'summ-asc' ? 'selected' : '' }}>По сумі яка залишилася (грн) (↑)</option>
                                 <option value="collected-desc" {{ $selectedSort == 'collected-desc' ? 'selected' : '' }}>По сумі яку зібрано (грн) (↓)</option>
                                 <option value="collected-asc" {{ $selectedSort == 'collected-asc' ? 'selected' : '' }}>По сумі яку зібрано (грн) (↑)</option>
                                 <option value="header-desc"  {{ $selectedSort == 'header-desc' ? 'selected' : '' }}>По заголовку (↓)</option>
                                 <option value="header-asc" {{ $selectedSort == 'header-asc' ? 'selected' : '' }}>По заголовку (↑)</option>
                                 <option value="date-desc" {{ $selectedSort == 'date-desc' ? 'selected' : '' }}>По даті додавання (↓)</option>
                                 <option value="date-asc" {{ $selectedSort == 'date-asc' ? 'selected' : '' }}>По даті додавання (↑)</option>
                             </select>
                         </div>
                     </div>
             </div>
             </form>

         </div>
     </div>
 </div>
 <div class="row">

@if (!$currentPagePosts)
<div class='mb-5 text-muted col-lg-12 text-center display-4'>
    Не знайдено продуктів
</div>
@else
<div class="card-deck">
        @foreach($currentPagePosts as $post)
            @include('card_pages/fundraising-card')
        @endforeach
    </div>
@endif
<nav aria-label="Page navigation example" class="mt-5">
    <ul class="pagination justify-content-center">
        @for ($page = 1; $page <= $totalPages; $page++)
            <li class="page-item{{ $page == $currentPage ? ' active' : '' }}">
                <a class="page-link" href="{{ route('fundraising-posts', ['page' => $page, 'searchKey'=>$searchInput, 'category'=>$selectedCategory,'sort'=>$selectedSort]) }}">{{ $page }}</a>
            </li>
        @endfor
    </ul>
</nav>


</div>

    
</div>
@endsection
