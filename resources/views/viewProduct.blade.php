@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">All products</div>
                    <div class="panel-body">
                        @foreach($product as $row)
                            <div><a href="{{URL::previous()}}"><< Go back </a></div>
                            <div style="text-align: center">
                                <h1>{{$row->title}}</h1>
                                <img style="width: 60%" src="data:image;base64,{{base64_encode($row->image)}}" alt="image">
                                <h3 style="margin-top: 10px">Price: {{$row->price}} $</h3>
                                <hr>
                                <h3 style="margin-top: 10px">Description: <span>{{$row->description}}</span></h3>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                    @if(Auth::user() !== null)
                        <div style="padding: 20px 80px">
                            <div>
                                {{Form::open(['method' => 'POST'])}}
                                {{Form::label('comment', 'Leave commentar')}}
                                <br />
                                    <textarea name="comment" style="width: 100%; border-radius: 10px" rows="5"></textarea>
                                    <div style="margin-top: 10px; text-align: right;">
                                        <button style="border-radius: 10px; border: none; padding: 5px 20px">Comment</button>
                                    </div>

                                {{Form::close()}}
                            </div>
                            <div style="height: 40px"></div>
                            <div>
                                @foreach($comments as $comment)
                                    <div style="border: 1px solid lightgray; margin-top: 10px; border-radius: 10px">
                                        {{Form::open(['method' => 'DELETE'])}}
                                            <div style="padding: 5px 10px; word-wrap: break-word">
                                                <input type="text" name="comment_id" hidden value="{{$comment->id}}">
                                                <span style="font-size: 16px"><strong>From: </strong>{{$comment->user_email}}</span>
                                                <span style="float: right;"><a href="javascript:void(0)"><button style="background: none; border: none">X</button></a></span>
                                                <p style="font-size: 22px">{{$comment->comment}}</p>
                                                <p><strong>Date: </strong> {{$comment->comment_date}}</p>
                                            </div>
                                        {{Form::close()}}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection