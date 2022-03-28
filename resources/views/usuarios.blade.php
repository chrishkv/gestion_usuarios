@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit User') }}</div>
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
                        <form action="{{ route('user-edit', array('user' => $usuario->id)) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name *</label>
                                <input name="name" type="text" value="{{ $usuario->name }}"
                                       class="form-control @error('name') is-invalid @enderror" >
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input name="last_name" type="text" value="{{ $usuario->last_name }}"
                                       class="form-control @error('last_name') is-invalid @enderror" >
                                @error('last_name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input name="email" type="text" value="{{ $usuario->email }}"
                                       class="form-control @error('email') is-invalid @enderror" >
                                @error('email')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input name="phone" type="text" value="{{ $usuario->phone }}"
                                       class="form-control @error('phone') is-invalid @enderror" >
                                @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input name="birthday" type="date" value="{{ $usuario->birthday }}"
                                       class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="addres" class="form-label">Addres</label>
                                <input name="addres" type="text" value="{{ $usuario->addres }}"
                                       class="form-control">
                            </div>
                            @can('change_role')
                            <div class="mb-3">
                                @foreach($roles as $role)
                                    <div>
                                        <label>
                                            <input type="checkbox" name="roles[]" class="mr-1"
                                                   value="{{ $role->id }}"
                                                   {{ in_array($role->name, $usuarioRoleNames) ? ' checked' : '' }}/>
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @endcan


                            <div class="card-footer">
                                <button class="btn btn-success" type="submit">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
