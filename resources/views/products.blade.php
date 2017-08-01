@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span>All products</span>
                        <hr style="margin-top: 0px; margin-bottom: 10px">
                        <span style="text-align: right">
                            <form method="GET">
                                <select name="filter" style="padding-top: 3px; padding-bottom: 5px; margin-right: 20px; border-radius: 5px">
                                    <option value="lth">price: low to high</option>
                                    <option value="htl">price: high to low</option>
                                    <option value="a-z">a-z</option>
                                    <option value="z-a">z-a</option>
                                </select>
                                <button style="border-radius: 5px; border: none; padding: 2px 10px">Filter</button>
                            </form>
                        </span>
                    </div>
                    <div class="panel-body">
                        @foreach($data as $row)
                            <div style="width: 43%; margin-left: 3%; margin-right: 3%; float: left">
                                    <h3 style="width: 70%; float: left">{{$row->title}}</h3>
                                    @if($auth)
                                        <a href="{{url('/products/' . $row->id . '/edit')}}">
                                            <h3 style="width: 29%; text-align: right; float: left">Edit</h3>
                                        </a>
                                    @endif
                                <a href="{{url('/products/' . $row->id)}}">
                                    <div style="height: 450px">
                                        <img style="max-width: 100%; max-height: 390px" src="data:image;base64,{{base64_encode($row->image)}}" alt="image">
                                    </div>
                                    <div style="text-align: right; margin-top: 10px; font-size: 15px">{{$row->price}} $</div>
                                    <small>Read more..</small>
                                </a>
                                <hr>
                            </div>
                        @endforeach
                        <div style="float: left; width: 100%; text-align: center">
                            @for($i = 0; $i < $pages ; $i++)
                                <a href="{{ url('/products?page=' . ($i + 1)) }}">
                                    <span style="margin: 5px; padding: 5px; background: lightblue">{{$i + 1}}</span>
                                </a>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection