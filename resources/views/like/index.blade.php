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
                <h1>Mis imágenes favoritas</h1>
                <hr>
                @foreach ($likes as $like)
                    <div class="card mb-3">
                        <div class="card-header">
                            @if ($like->image->user->image)
                                <img src="{{ url('/user/avatar/' . $like->image->user->image) }}" alt="Avatar"
                                    class="img-thumbnail rounded-circle" width="50">
                            @endif
                            <a href="{{ url('image/' . $like->image->id) }}">
                                <b>{{ $like->image->user->name . ' ' . $like->image->user->surname }}</b>
                                <span>{{ ' | @' . $like->image->user->nick }}</span>
                            </a>
                        </div>

                        <div style="padding: 0px;" class="card-body">
                            <div class="image-container">
                                <img src="{{ url('/image/file/' . $like->image->image_path) }}" alt="Imagen" />
                            </div>
                            <div class="description">
                                <span class="nickname">{{ '@' . $like->image->user->nick }}</span>
                                <span
                                    class="nickname">{{ ' | ' . \FormatTime::LongTimeFilter($like->image->created_at) }}</span>
                                <p>{{ $like->image->description }}</p>
                            </div>
                            <div class="likes">
                                {{-- Comprobar si el usuario le gusta la imagen --}}
                                <?php $user_like = false; ?>
                                @foreach ($like->image->likes as $like)
                                    @if ($like->user->id == Auth::user()->id)
                                        <?php $user_like = true; ?>
                                    @endif
                                @endforeach

                                @if ($user_like)
                                    <img src="{{ asset('img/heart-red.png') }}" data-id="{{ $like->image->id }}"
                                        class="btn-dislike">
                                @else
                                    <img src="{{ asset('img/heart-black.png') }}" data-id="{{ $like->image->id }}"
                                        class="btn-like">
                                @endif

                                <span
                                    class="number_likes_<?= $like->image->id ?>">{{ $like->image->likes->count() }}</span>
                            </div>
                            <div class="comments">
                                <a href="" class="btn btn-sm btn-warning btn-comments">
                                    Comentarios ({{ count($like->image->comments) }})
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{$likes->links(
                    'pagination::bootstrap-4',
                    ['paginator' => $likes]
                )}}
            </div>
        </div>
    </div>
@endsection
