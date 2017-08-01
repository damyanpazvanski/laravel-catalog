@extends('layouts.app')
@section('head-js')
    <script src="https://cloud.tinymce.com/stable/tinymce.min.js"></script>
    <script>tinymce.init({ selector:'textarea' });</script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Product</div>

                    <div class="panel-body">
                        {{Form::open([
                            'url' => url($url),
                            'method' => $method,
                            'files' => true
                            ])}}

                        @if(isset($product))

                            {{Form::label('title', 'Product title')}}
                            <br />
                                {{Form::text('title', $product->title)}}
                            <div>{{$errors->First('title')}}</div>
                            <hr />

                            {{Form::label('desc', 'Description')}}
                            <br />
                            {{Form::textarea('desc', $product->description)}}
                            <div>{{$errors->First('desc')}}</div>
                            <hr />

                            {{Form::label('price', 'Price')}}
                            <br />
                            {{Form::text('price', $product->price)}}
                            <div>{{$errors->First('price')}} {{ $errors->First('priceError') }}</div>
                            <hr />

                        @else
                            {{Form::label('title', 'Product title')}}
                            <br />
                                {{Form::text('title')}}
                            <div>{{$errors->First('title')}}</div>
                            <hr />

                            {{Form::label('desc', 'Description')}}
                            <br />
                            {{Form::textarea('desc')}}
                            <div>{{$errors->First('desc')}}</div>
                            <hr />

                            {{Form::label('price', 'Price')}}
                            <br />
                            {{Form::text('price')}}
                            <div>{{$errors->First('price')}} {{ $errors->First('priceError') }}</div>
                            <hr />
                        @endif

                            {{Form::label('image', 'Upload image')}}
                            <br />
                            {{Form::file('image')}}
                        <div>{{$errors->First('image')}}</div>
                        <hr />

                            {{Form::submit($btn)}}
                        {{Form::close()}}

                        @if(isset($edit) && $edit === true)
                        {{Form::open([
                           'url' => url('/products/' . $product->id),
                           'method' => 'DELETE'
                           ])}}
                        {{Form::submit('Delete')}}

                        {{Form::close()}}
                        <br />
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
