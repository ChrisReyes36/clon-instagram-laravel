@extends('layouts.app')

@section('content')
    <style>
        .image-container {
            width: 100%;
            height: 450px;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 450px;
        }

        .description {
            padding: 20px;
            padding-bottom: 0px;
        }

        .btn-comments {
            margin: 20px;
            margin-top: 0px;
            margin-left: 0px;
        }

        .likes {
            float: left;
            padding-left: 20px;
            padding-right: 10px;
        }

        .likes img {
            width: 20px;
        }

        .card-header a {
            color: black;
            text-decoration: none;
        }

        .nickname {
            color: gray;
        }

        .number_likes {
            color: gray;
            font-size: 11px;
        }

    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h1>Gente</h1>
                <form method="" id="buscador">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Buscar..." id="search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
                <hr>
                @foreach ($users as $user)
                    <div class="data-user row mb-3">
                        <div class="col-md-4 text-center">
                            @if ($user->image)
                                <img src="{{ route('user.avatar', ['filename' => $user->image]) }}"
                                    class="img-thumbnail rounded-circle" />
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h1>{{ '@' . $user->nick }}</h1>
                            <h2>{{ $user->name . ' ' . $user->surname }}</h2>
                            <p>{{ 'Se unió: ' . \FormatTime::LongTimeFilter($user->created_at) }}</p>
                            <a class="btn btn-success" href="{{ route('profile', ['id' => $user->id]) }}">Ver Perfil</a>
                            <hr>
                            {{-- <h3>{{ 'Seguidores: ' . $user->followers->count() }}</h3>
                        <h3>{{ 'Siguiendo: ' . $user->following->count() }}</h3>
                        <h3>{{ 'Imágenes: ' . $user->images->count() }}</h3> --}}
                        </div>
                    </div>
                @endforeach
                {{ $users->links(
                    'pagination::bootstrap-4',
                    ['paginator' => $users]
                ) }}
            </div>
        </div>
    </div>
@endsection
