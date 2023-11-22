@extends('shared/layout')

@section('content')
    <div class="container text-center text-white">
        <h1>Заява на верифікацію</h1>
        
        <img src="{{ $request->ticket_photo ? asset('storage/app/public/' . $request->ticket_photo) : asset('no-image.jpg') }}" alt="Verification Photo" style="max-width: 300px; margin: 0 auto;">

        @php
            $user = App\Models\User::where('id', $request->user_id)->first();
        @endphp

        <p>Користувач: <a href="{{ route('profile', $user->id) }}">{{ $user->email }}</a></p>
        <p>Статус: {{ $request->approved }}</p>

        @if ($request->approved === 'Очікування')
                <div class="btn-group">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveFormModal">
                        <i class="fas fa-check"></i> Підтвердити заяву
                    </button>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#disapproveReasonModal">
                        <i class="fas fa-times"></i> Відхилити заяву
                    </button>
                    <br>
                </div>


<div class="container text-center my-3">
<button type="submit" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#removeModal">
                    <i class="fas fa-trash-alt"></i> Видалити заяву
                </button>
</div>
               
        @elseif ($request->approved === 'Підтверджено' || $request->approved === 'Відмовлено')
        <form method="post" action="{{ route('verification-to-waiting', ['id' => $request->id]) }}">
                @csrf
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-undo"></i> Змінити на "Очікування"
                </button>
            </form>
        @endif
    </div>

    <div class="container text-center mb-3">
        <a href="{{ asset('storage/app/public/'.$request->ticket_photo) }}" download="{{ $user->email }}_verification.jpg" class="btn btn-primary">
            <i class="fas fa-download"></i> завантажити картинку
        </a>
    </div>


                        <!-- MODALS -->



               <!-- Modal for Disapproval Reason -->
<div class="modal fade" id="disapproveReasonModal" tabindex="-1" role="dialog" aria-labelledby="disapproveReasonModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="disapproveReasonModalLabel">Відхилення заяви</h5>
            </div>
            <form method="post" action="{{ route('disapprove-verification', ['id' => $request->id]) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="reason" class="form-control" placeholder="Причина відхилення заяви" required>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрити</button>
                    <button type="submit" class="btn btn-danger">Відхилити заяву</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal for approving verification and filling soldier data-->
<div class="modal fade" id="approveFormModal" tabindex="-1" role="dialog" aria-labelledby="approveFormModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="approveFormModalLabel">Підтвердження заяви</h5>
            </div>
            <form method="post" action="{{ route('approve-verification', ['id' => $request->id]) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group text-dark">
                        <h4 class="mb-3"> Інформація про військовозобов'язаного: </h4>

                        <!-- Військове звання -->
                        <label for="rankInput">Військове звання</label>
                        <input type="text" class="form-control" id="rankInput" name="rankInput" required>

                        <!-- Склад -->
                        <label for="selectComposition">Склад</label>
                        <select class="form-select" id="selectComposition" name="selectComposition" required>
                            @php 
                                $i = 1;
                            @endphp 
                            @foreach($compositions as $composition)
                                <option value="{{ $i }}">{{ $composition }}</option>
                                @php 
                                    $i = $i + 1;
                                @endphp
                            @endforeach
                        </select>

                        <!-- Профіль -->
                        <label for="selectProfile">Профіль</label>
                        <select class="form-select" id="selectProfile" name="selectProfile" required>
                            @php 
                                $i = 1;
                            @endphp 
                            @foreach($profiles as $profile)
                                <option value="{{ $i }}">{{ $profile }}</option>
                                @php 
                                    $i = $i + 1;
                                @endphp
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer mt-3 d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Повернутися</button>
                    <button type="submit" class="btn btn-success ms-3">Зберегти</button>
                </div>
            </form>



        </div>
    </div>
</div>

         
<div class="modal fade" id="removeModal" tabindex="-1" role="dialog" aria-labelledby="removeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="removeModalLabel">Видалення заяви</h5>
            </div>
            <form method="post" action="{{ route('remove-verification', ['id' => $request->id]) }}">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                    <label class="form-control border-0" for="approving">Ви дійсно хочете видалити заяву?</label>

                      
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button type="button" class="btn btn-secondary me-3" data-bs-dismiss="modal">Ні</button>
                    <button type="submit" class="btn btn-danger ms-3">Так</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
