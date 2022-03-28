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
            <div class="card-header">
                <form action="{{ route('search') }}" method="POST">
                    @csrf
                    @method('GET')
                    <div class="mb-3">
                        <label for="formGroupExampleInput" class="form-label">Name</label>
                        <input name="name" type="text" placeholder="Search" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary mx-lg-1">Buscar</button>
                </form>
            </div>
            @if ($usuarios->count())
                <table class="table table-striped mt-5">
                    <thead>
                        <th>Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Birthday</th>
                        <th>Addres</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->last_name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->phone }}</td>
                            <td>{{ $usuario->birthday }}</td>
                            <td>{{ $usuario->addres }}</td>
                            <td style="display: flex">
                                @can('edit')
                                    <a href="{{ route('user-edit', array('user' => $usuario->id)) }}" class="btn btn-primary">Edit</a>
                                @endcan
                                @can('delete')
                                    <form action="{{ route('user-edit', array('user' => $usuario->id)) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger mx-lg-1">Remove</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="card-body">No records</div>
            @endif

        </div>
    </div>
</div>
@endsection
