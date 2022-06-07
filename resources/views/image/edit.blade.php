@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Editar Imagen
                    </div>
                    <div class="card-body">
                        <form action="{{ route('image.update') }}" method="post" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="id" id="id" value="{{ $image->id }}">
                            <div class="row mb-3">
                                <label for="image_path" class="col-md-4 col-form-label text-md-end">Imagen</label>

                                <div class="col-md-6">
                                    <input id="image_path" type="file"
                                        class="form-control @error('image_path') is-invalid @enderror" name="image_path"
                                        autocomplete="image_path">

                                    @error('image_path')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            @if (Auth::user()->image)
                                <div class="row mb-3">
                                    <label class="col-md-4 col-form-label text-md-end"></label>
                                    <div class="col-md-6">
                                        <img src="{{ url('/image/file/' . $image->image_path) }}" alt="Imagen"
                                            class="img-thumbnail" width="200">
                                    </div>
                                </div>
                            @endif

                            <div class="row mb-3">
                                <label for="description" class="col-md-4 col-form-label text-md-end">Descripción</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" required
                                        autocomplete="description">{{ $image->description }}</textarea>

                                    @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>



                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Actualizar Imagen
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
