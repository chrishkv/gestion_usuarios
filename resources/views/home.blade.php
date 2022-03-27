@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="d-flex justify-content-center">
                {!! $usuarios->links() !!}
            </div>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @elseif (session('error'))
                <div class="alert alert-danger" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <form action="{{ route('search') }}" method="POST">
                @csrf
                @method('GET')
                <div class="mb-3">
                    <label for="formGroupExampleInput" class="form-label">Name</label>
                    <input name="name" type="text" placeholder="Search" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary mx-lg-1">Buscar</button>
            </form>
            <table class="table table-striped mt-5">
                <thead>
                <th>Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>Action</th>
                </thead>
                <tbody>
                @foreach($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td style="display: flex">
                            <a href="{{ route('user-edit', array('user' => $usuario->id)) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('user-edit', array('user' => $usuario->id)) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger mx-lg-1">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
