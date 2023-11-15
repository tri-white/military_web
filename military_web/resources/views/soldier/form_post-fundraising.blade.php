@extends('shared/layout')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 text-white">
            <h2 class="text-center mt-4 mb-4">Створення збору коштів</h2>
            <form action="{{ route('create_post-fundraising', Auth::user()->id) }}" method="POST">
                @csrf

                <div class="form-group mb-3">
                    <label for="purpose">Заголовок для оголошення про збір коштів:</label>
                    <input type="text" class="form-control" id="purpose" name="purpose" value="{{ old('purpose') }}" required>
                </div>

                <div class="form-group">
                    <label for="goal_amount">Сума, яку необхідно зібрати (грн):</label>
                    <input type="number" class="form-control" id="goal_amount" name="goal_amount" value="{{ old('goal_amount') }}" required>
                </div>

                <div class="form-group">
                    <label for="current_amount">Скільки вже зібрано (грн):</label>
                    <input type="number" class="form-control" id="current_amount" name="current_amount" value="{{ old('current_amount', 0) }}" required>
                </div>

                <div class="form-group mt-3">
                    <label for="category_id">Категорія:</label>
                    <select class="form-control" id="category_id" name="category_id">
                        @php 
                         $categories = App\Models\Category::all();
                         @endphp
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="div d-flex justify-content-center">
                <button type="submit" class="btn btn-block mt-4 text-white px-5" style="background-color: #2B2C27;">Розпочати збір коштів</button>
                </div>
            </form>
            
            <!-- Progress bar -->
            <div class="progress mt-4">
                <div id="progress-bar" style=" background-color: #B5C186;" class="progress-bar text-white" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {

        const goalAmountInput = $('#goal_amount');
        const currentAmountInput = $('#current_amount');
        const progressBar = $('#progress-bar');

        function updateProgressBar() {
            const goalAmount = parseInt(goalAmountInput.val());
            const currentAmount = parseInt(currentAmountInput.val());

            const progressPercentage = (currentAmount / goalAmount) * 100;

            progressBar.css('width', progressPercentage + '%');
            progressBar.text(progressPercentage.toFixed(2) + '%');
        }

        goalAmountInput.on('input', updateProgressBar);
        currentAmountInput.on('input', updateProgressBar);
    });
</script>
@endpush
