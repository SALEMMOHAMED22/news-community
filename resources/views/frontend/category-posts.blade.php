@extends('layouts.frontend.app')
@section('title')
    category : {{ $category->name }}
@endsection
@push('header')
    <link rel="canonical" href="{{ url()->full() }}">
@endpush    


@section('breadcrumb')
    @parent
<li class="breadcrumb-item active"  >{{ $category->name }}</li>
@endsection
        
 


@section('body')
<br><br><br>
<div class="main-news">
    <div class="container">
      <div class="row">
        <div class="col-lg-9">
          <div class="row">

            @forelse ($posts as $post)
            <div class="col-md-4">
                <div class="mn-img">
                  <img src="{{asset( $post->images->first()->path) }}" />
                  <div class="mn-title">
                    <a href="">{{ $post->title }}</a>
                  </div>
                </div>
              </div>

            @empty
                
            @endforelse
            <div class="col-md-4">
              <div class="mn-img">
                <img src="img/news-350x223-1.jpg" />
                <div class="mn-title">
                  <a href="">Lorem ipsum dolor sit</a>
                </div>
              </div>
            </div>
      
          </div>
          {{ $posts->links() }}
        </div>

        <div class="col-lg-3">
          <div class="mn-list">
            <h2>Other Categories</h2>
            <ul>
              @foreach ($categories as $category)
              
              <li><a href="{{ route('frontend.category.posts' , $category->slug) }}" title="{{ $category->name }}"> {{ $category->name }}</a></li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection