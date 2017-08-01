@extends('layouts.app')

<style>
    .contact-form input {
        border-radius: 5px;
        padding: 5px;
        width: 300px;
    }
    .contact-form tr{
        height: 55px;
    }
    .contact-form tr:first-of-type {
        height: 0px;
    }
    .contact-form textarea {
        width: 300px;
        border-radius: 10px;
    }
</style>

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Contact us</div>
                    <div style="margin-left: 40px; margin-top: 20px"><h3>Send a report <span style="margin-left: 40px; color: limegreen;">{{Session::get('message')}}</span></h3></div>
                    <div class="contact-form" style="padding: 20px 40px;">
                        {{Form::open([
                            'url' => url('/sendmail'),
                            'method' => 'POST'
                            ])}}
                        <table>
                            <thead>
                            <th style="width: 150px"></th>
                            <th style="width: 200px"></th>
                            </thead>
                            <tbody>

                            <tr>
                                <td>{{Form::label('name', 'Name')}}<strong>:</strong></td>
                                <td>{{Form::text('name')}}</td>
                            </tr>
                            <tr>
                                <td>{{Form::label('email', 'Email')}}<strong>:</strong></td>
                                <td>{{Form::text('email')}}</td>
                            </tr>
                            <tr>
                                <td style="vertical-align: top">{{Form::label('description', 'Description')}} <strong>:</strong> </td>
                                <td>{{Form::textarea('description')}}</td>
                            </tr>
                            </tbody>

                            <tr>
                                <td></td>
                                <td>
                                    <div class="text-right" style="margin-top: 20px">
                                        <button style=" padding: 10px 30px; border-radius: 10px">Send</button>
                                    </div>
                                </td>
                            </tr>

                        </table>

                        {{Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection