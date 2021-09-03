@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card" style="margin-bottom:15px;">
            <div class="card-header h4">
                {{$post->caption}}
            </div>
            <div class="card-body">
                <p class="card-text">{{$post->description}}</p>
                <p class="card-text"><small class="text-muted">{{$post->user->name}} - {{$post->created_at->diffForHumans()}}</small></p>
            </div>
            <div class="card text-white" >
                <img class="card-img-bottom img-fluid rounded" alt="100%x180" style="width: 100%; display: block;" src="{{$post->image}}" data-holder-rendered="true">
                <div class="card-img-overlay">
                    <button type="button" class="btn btn-primary" style="top:20;">Likes: {{$post->rating}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection