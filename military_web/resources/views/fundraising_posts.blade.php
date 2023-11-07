@extends('shared/layout')
@push('css')
@section('content')
<h1 class="text-center mt-5 text-white"> Збори коштів військовим </h1>
<div class="container">
    <div class="row text-whit my-5 text-white">
     <div class="col-lg-12 text-center display-5">
         Пошук
     </div>
     <div class="col-lg-8 col-md-10 col-sm-12 mx-auto align-items-center">
         <div class="row d-flex justify-content-center">
             <div class="col-lg-8 col-md-10 col-sm-12 text-center">
                 <form method="post" action="">
                     @csrf
                     <div class="input-group">
                         <input value="" name="search-input-key" type="search" class="px-3 form-control"
                             placeholder="Пошук..." aria-label="Search" aria-describedby="search-addon" />
                         <button type="submit" class="btn text-white" style="background-color:#B5C186">Знайти</button>
                     </div>
                     <div class="d-flex justify-content-between mb-2 mt-2">
                         <div class="col-lg-6">
                             <select id="product-category-filter" name="product-category-filter" class="form-select"
                                 aria-label="Категорія" style="width:100%;">
                                 <option value="all">Всі категорії</option>
                                 @foreach($categories as $category)
										<option value="{{ $category->id }}">{{ $category->name }}</option>
									@endforeach
                             </select>

                         </div>
                         <div class="col-lg-6">
                             <select id="product-sort" name="product-sort" class="form-select" aria-label="Категорія"
                                 style="width:100%">
                                 <option value="progress-desc">По прогресу % (↓)</option>
                                 <option value="progress-asc">По прогресу % (↑)</option>
                                 <option value="summ-desc">По сумі яка залишилася (грн) (↓)</option>
                                 <option value="summ-asc">По сумі яка залишилася (грн) (↑)</option>
                                 <option value="header-desc">По заголовку (↓)</option>
                                 <option value="header-asc">По заголовку (↑)</option>
                                 <option value="date-desc">По даті додавання (↓)</option>
                                 <option value="date-asc">По даті додавання (↑)</option>
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
                <a class="page-link text-white" href="{{ route('fundraising-posts', ['page' => $page]) }}" style="background-color:#B5C186">{{ $page }}</a>
            </li>
        @endfor
    </ul>
</nav>


</div>

    
</div>
@endsection
