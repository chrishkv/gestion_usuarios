@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Change password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif
                    <form action="{{ route('update-password') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="formGroupExampleInput" class="form-label">Clave Actual</label>
                            <input name="oldPassword" type="password" placeholder="Clave Actual"
                                   class="form-control @error('oldPassword') is-invalid @enderror" >
                            @error('oldPassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Clave Nueva</label>
                            <input name="newPassword" type="password" placeholder="Clave Nueva"
                                   class="form-control  @error('newPassword') is-invalid @enderror">
                            @error('newPassword')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="formGroupExampleInput2" class="form-label">Confirmar clave</label>
                            <input name="newPassword_confirmation" type="password" class="form-control" placeholder="Confirmar Clave">
                        </div>
                        <div class="card-footer">
                            <button class="btn btn-success" type="submit">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
