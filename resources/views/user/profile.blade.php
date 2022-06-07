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
                <div class="data-user row">
                    <div class="col-md-4 text-center">
                        @if ($user->image)
                            <img src="{{ route('user.avatar', ['filename' => $user->image]) }}" class="img-thumbnail rounded-circle" />
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h1>{{ '@' . $user->nick }}</h1>
                        <h2>{{ $user->name . ' ' . $user->surname }}</h2>
                        <p>{{ 'Se unió: ' . \FormatTime::LongTimeFilter($user->created_at) }}</p>
                        <hr>
                        {{-- <h3>{{ 'Seguidores: ' . $user->followers->count() }}</h3>
                        <h3>{{ 'Siguiendo: ' . $user->following->count() }}</h3>
                        <h3>{{ 'Imágenes: ' . $user->images->count() }}</h3> --}}
                    </div>
                </div>
                @foreach ($user->images as $image)
                    <div class="card mb-3">
                        <div class="card-header">
                            @if ($image->user->image)
                                <img src="{{ url('/user/avatar/' . $image->user->image) }}" alt="Avatar"
                                    class="img-thumbnail rounded-circle" width="50">
                            @endif
                            <a href="{{ route('profile', ['id' => $image->user->id]) }}">
                                <b>{{ $image->user->name . ' ' . $image->user->surname }}</b>
                                <span>{{ ' | @' . $image->user->nick }}</span>
                            </a>
                        </div>

                        <div style="padding: 0px;" class="card-body">
                            <div class="image-container">
                                <img src="{{ url('/image/file/' . $image->image_path) }}" alt="Imagen" />
                            </div>
                            <div class="description">
                                <span class="nickname">{{ '@' . $image->user->nick }}</span>
                                <span
                                    class="nickname">{{ ' | ' . \FormatTime::LongTimeFilter($image->created_at) }}</span>
                                <p>{{ $image->description }}</p>
                            </div>
                            <div class="likes">
                                {{-- Comprobar si el usuario le gusta la imagen --}}
                                <?php $user_like = false; ?>
                                @foreach ($image->likes as $like)
                                    @if ($like->user->id == Auth::user()->id)
                                        <?php $user_like = true; ?>
                                    @endif
                                @endforeach

                                @if ($user_like)
                                    <img src="{{ asset('img/heart-red.png') }}" data-id="{{ $image->id }}"
                                        class="btn-dislike">
                                @else
                                    <img src="{{ asset('img/heart-black.png') }}" data-id="{{ $image->id }}"
                                        class="btn-like">
                                @endif

                                <span class="number_likes_<?= $image->id ?>">{{ $image->likes->count() }}</span>
                            </div>
                            <div class="comments">
                                <a href="{{ route('image.detail', ['id' => $image->id]) }}"
                                    class="btn btn-sm btn-warning btn-comments">
                                    Comentarios ({{ count($image->comments) }})
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
