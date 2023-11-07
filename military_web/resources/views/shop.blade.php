@extends('shared/layout')
@push('css')

@endpush
@section('content')
<!-- Start Hero Section -->
<div class="hero">
	<div class="container">
		<div class="row justify-content-between">
			<div class="col-lg-5">
				<div class="intro-excerpt">
					<h1>Асортимент</h1>
				</div>
			</div>
			<div class="col-lg-7">

			</div>
		</div>
	</div>
</div>
<!-- End Hero Section -->

<div class="untree_co-section product-section before-footer-section">
	<div class="container">
		<div class="row">
			<div class="mb-2 mt-5 col-lg-12 text-center display-5">
				Пошук
			</div>
			<div class="col-lg-8 col-md-10 col-sm-12 mx-auto align-items-center">
				<!-- Search bar -->
				<div class="row d-flex justify-content-center">
					<div class="col-lg-8 col-md-10 col-sm-12 text-center">
						<form method="post" action="{{ route('search') }}">
							@csrf
							<div class="input-group">
								<input value="{{ ($searchInput!=='null' ? $searchInput : '') }}" name="search-input-key" type="search" class="px-3 form-control"
									placeholder="Пошук..." aria-label="Search" aria-describedby="search-addon" />
								<button type="submit" class="btn btn-outline-dark">Знайти</button>
							</div>
							<div class="d-flex justify-content-between mb-2 mt-2">
								<div class="col-lg-6">
								<select id="product-category-filter" name="product-category-filter" class="form-select" aria-label="Категорія" style="width:100%;">
									<option value="all" {{ $selectedCategory == 'all' ? 'selected' : '' }}>Всі категорії</option>
									@foreach($categories as $category)
										<option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
									@endforeach
								</select>

								</div>
								<div class="col-lg-6">
										<select id="product-sort" name="product-sort" class="form-select" aria-label="Категорія" style="width:100%">
											<option value="price-desc" {{ $selectedSort == 'price-desc' ? 'selected' : '' }}>По ціні (↓)</option>
											<option value="price-asc" {{ $selectedSort == 'price-asc' ? 'selected' : '' }}>По ціні (↑)</option>
											<option value="name-desc" {{ $selectedSort == 'name-desc' ? 'selected' : '' }}>По назві (↓)</option>
											<option value="name-asc" {{ $selectedSort == 'name-asc' ? 'selected' : '' }}>По назві (↑)</option>
											<option value="review-desc" {{ $selectedSort == 'review-desc' ? 'selected' : '' }}>По відгукам (↓)</option>
											<option value="review-asc" {{ $selectedSort == 'review-asc' ? 'selected' : '' }}>По відгукам (↑)</option>
											<option value="date-desc" {{ $selectedSort == 'date-desc' ? 'selected' : '' }}>По даті додавання (↓)</option>
											<option value="date-asc" {{ $selectedSort == 'date-asc' ? 'selected' : '' }}>По даті додавання (↑)</option>
									</select>
								</div>
							</div>
					</div>
					</form>

				</div>
			</div>
			<div class="row">

				@if (!$currentPageProducts)
				<div class='mb-5 text-muted col-lg-12 text-center display-4'>
					Не знайдено продуктів
				</div>
				@else
				@foreach($currentPageProducts as $currentPageProduct)
				@include("cards/shop-product")
				@endforeach
				@endif
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">

						@for ($page = 1; $page <= $totalPages; $page++) <li
							class="page-item{{ $page == $currentPage ? ' active' : '' }}">
							<a class="page-link" href="{{ route('shop', ['page' => $page, 'searchKey'=>$searchInput, 'category'=>$selectedCategory,'sort'=>$selectedSort]) }}">{{ $page }}</a>
							</li>
							@endfor
					</ul>
				</nav>
			</div>
			<div class="row">
			</div>

		</div>
	</div>
	@endsection

	@push('js')
	@endpush