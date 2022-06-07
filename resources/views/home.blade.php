@extends('layouts.app')

@section('content')
    <style>
        .image-container {
            width: 100%;
            height: 400px;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 400px;
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
    <svg xmlns="http://www.w3.org/2000/svg" style="display: none;">
        <symbol id="check-circle-fill" fill="currentColor" viewBox="0 0 16 16">
            <path
                d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
        </symbol>
    </svg>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                @if (session('message'))
                    <div class="alert alert-success alert-dismissible fade show d-flex align-items-center" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Success:">
                            <use xlink:href="#check-circle-fill" />
                        </svg>
                        <div>
                            <strong>{{ session('message') }}</strong>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                @foreach ($images as $image)
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
                                <a href="{{route('image.detail', ['id' => $image->id])}}" class="btn btn-sm btn-warning btn-comments">
                                    Comentarios ({{ count($image->comments) }})
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
                {{$images->links(
                    'pagination::bootstrap-4',
                    ['paginator' => $images]
                )}}
            </div>
        </div>
    </div>
@endsection
