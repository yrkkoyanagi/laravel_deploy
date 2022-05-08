@extends('layouts.app', ['authgroup' => 'admin'])

@section('content')
<div class="container">
    <div class="row justify-content-center">
    @if(session('flash_message'))
        <div class="alert alert-primary text-center" role="alert">
            {{session('flash_message')}}
        </div>
    @endif
            <h2>{{ Auth::user()->name }}が検索したお店</h2>
            <div class="row">
            @foreach($shops as $shop)
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">{{ $shop->shop_name}}</h3>
                            <a href="{{route('detail',$shop->id)}}" class="btn btn-warning">{{__('Detail')}}</a>
                       　</div>
                    </div>
                </div>

            @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
