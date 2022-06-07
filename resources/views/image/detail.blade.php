@extends('layouts.app')

@section('content')
    <style>
        .image-container {
            width: 100%;
            height: 500px;
            overflow: hidden;
        }

        .image-container img {
            width: 100%;
            height: 500px;
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

        .clearfix {
            clear: both;
            float: none;
        }

        .comments {
            padding: 20px;
        }

        .nickname {
            color: gray;
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
            <div class="col-md-9">

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

                <div class="card mb-3">
                    <div class="card-header">
                        @if ($image->user->image)
                            <img src="{{ url('/user/avatar/' . $image->user->image) }}" alt="Avatar"
                                class="img-thumbnail rounded-circle" width="50">
                        @endif
                        <b>{{ $image->user->name . ' ' . $image->user->surname }}</b>
                        <span>{{ ' | @' . $image->user->nick }}</span>
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

                        @if (Auth::check() && Auth::user()->id == $image->user->id)
                            <div class="actions">
                                <a href="{{ route('image.edit', ['id' => $image->id]) }}" class="btn btn-sm btn-primary">Actualizar</a>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#modalEliminar">
                                    Eliminar
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="modalEliminar" data-bs-backdrop="static"
                                    data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalEliminarLabel"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="modalEliminarLabel">¿Está seguro/a?</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    Si eliminas esta imagen nunca podrás recuperarla.<br>
                                                    ¿Está seguro/a de querer borrarla?
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <a href="{{ route('image.delete', ['id' => $image->id]) }}"
                                                    class="btn btn-danger">Eliminar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="clearfix"></div>
                        <div class="comments">
                            <h2>Comentarios ({{ count($image->comments) }})</h2>
                            <hr>
                            <form action="{{ route('comment.save') }}" method="post">
                                @csrf

                                <input type="hidden" name="image_id" value="{{ $image->id }}">

                                <p>
                                    <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content"></textarea>

                                    @error('content')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </p>
                                <button type="submit" class="btn btn-success">
                                    Enviar
                                </button>
                            </form>
                            <hr>
                            @foreach ($image->comments as $comment)
                                <div class="comment">
                                    <span class="nickname">{{ '@' . $comment->user->nick }}</span>
                                    <span
                                        class="nickname">{{ ' | ' . \FormatTime::LongTimeFilter($comment->created_at) }}</span>
                                    <p>
                                        {{ $comment->content }}<br />
                                        @if (Auth::check() && ($comment->user_id == Auth::user()->id || $comment->image->user_id == Auth::user()->id))
                                            <a href="{{ route('comment.delete', ['id' => $comment->id]) }}"
                                                class="btn btn-sm btn-danger">
                                                Eliminar
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
