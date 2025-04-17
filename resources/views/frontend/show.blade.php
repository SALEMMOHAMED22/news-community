@extends('layouts.frontend.app')
@section('title')
    show: {{ $mainPost->title }}
@endsection
@section('meta_desc')
    {{ $mainPost->small_desc }}
@endsection
@push('header')
    <link rel="canonical" href="{{ url()->full() }}">
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">{{ $mainPost->title }}</li>
@endsection



@section('body')
    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Carousel -->
                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#newsCarousel" data-slide-to="1"></li>
                            <li data-target="#newsCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach ($mainPost->images as $index => $image)
                                <div class="carousel-item @if ($index == 0) active @endif ">
                                    <img src="{{ asset($image->path) }}" class="d-block w-100" alt="First Slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{ $mainPost->title }}</h5>
                                        <p>
                                            {{-- {!! substr($mainPost->desc, 0, 80) !!} --}}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                            {{-- <div class="carousel-item">
                        <img src="./img/news-825x525.jpg" class="d-block w-100" alt="First Slide">
                        <div class="carousel-caption d-none d-md-block">  
                          <h5>Lorem ipsum dolor sit amet</h5>
                          <p>
                            laoreet. Aliquam vel felis felis. Proin sed sapien erat. Etiam a quam et metus tempor rutrum.
                          </p>
                        </div>
                      </div> --}}
                            <!-- Add more carousel-item blocks for additional slides -->
                        </div>
                        <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>


                    <div class="sn-content">
                        {!! $mainPost->desc !!}
                    </div>


                    @auth
                        <!-- Comment Section -->
                        @if (auth('web')->user()->status != 0)
                            <div class="comment-section">
                                <!-- Comment Input -->
                                @if ($mainPost->comment_able == true)
                                    <form id="commentForm" method="POST">
                                        @csrf
                                        <div class="comment-input">
                                            <input id="commentInput" type="text" name="comment"
                                                placeholder="Add a comment..." />
                                            <input name="user_id" type="hidden" value="{{ auth()->user()->id }}">
                                            <input type="hidden" name="post_id" value="{{ $mainPost->id }}">
                                            <button type="submit">Comment</button>
                                        </div>
                                    </form>

                                @else
                                    <div class="alert alert-info">
                                        Unable to comment

                                </div>
                                 @endif

                            <div style="display: none" id="errorMsg" class="alert alert-danger">

                            </div>
                        @else
                            <div class="alert alert-info">
                                You are blocked from commenting
                            </div>
                        @endif
                    @endauth
                    @auth
                        <!-- Display Comments -->
                        <div class="comments">


                            @foreach ($mainPost->comments as $comment)
                                <div class="comment">
                                    <img src="{{ asset($comment->user->image) }}" alt="User Image" class="comment-img" />
                                    <div class="comment-content">
                                        <span class="username">{{ $comment->user->name }}</span>
                                        <p class="comment-text">{{ $comment->comment }}</p>

                                    </div>
                                    <div for = 'human'>

                                    </div>
                                </div>
                            @endforeach

                            <!-- Add more comments here for demonstration -->
                        </div>

                        <!-- Show More Button -->
                        @if ($mainPost->comments->count() > 2)
                            <button id="showMoreBtn" class="show-more-btn">Show more</button>
                        @endif
                    </div>

                @endauth
                <!-- Related News -->
                <div class="sn-related">
                    <h2>Related News</h2>
                    <div class="row sn-slider">
                        @foreach ($posts_belongs_to_category as $post)
                            <div class="col-md-4">
                                <div class="sn-img">
                                    <img src="{{ asset($post->images->first()->path) }}" class="img-fluid"
                                        alt="{{ $post->title }}" />
                                    <div class="sn-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}"
                                            title="{{ $post->title }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar">
                    <div class="sidebar-widget">
                        <h2 class="sw-title">In This Category</h2>
                        <div class="news-list">

                            @foreach ($posts_belongs_to_category as $post)
                                <div class="nl-item">
                                    <div class="nl-img">
                                        <img src="{{ asset($post->images->first()->path) }}" />
                                    </div>
                                    <div class="nl-title">
                                        <a href="{{ route('frontend.post.show', $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>


                    <div class="sidebar-widget">
                        <div class="tab-news">
                            <ul class="nav nav-pills nav-justified">

                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#popular">Popular</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#latest">Latest</a>
                                </li>
                            </ul>

                            <div class="tab-content">

                                <div id="popular" class="container tab-pane active">
                                    @foreach ($greetest_posts_comments as $post)
                                        <div class="tn-news">
                                            <div class="tn-img">
                                                <img src="{{ asset($post->images->first()->path) }}"
                                                    alt="{{ $post->title }}" />
                                            </div>
                                            <div class="tn-title">
                                                <a href="{{ route('frontend.post.show', $post->slug) }} "
                                                    title="{{ $post->title }}">{{ $post->title }} </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>


                                <div id="latest" class="container tab-pane fade">
                                    @foreach ($latest_posts as $post)
                                        <div class="tn-news">
                                            <div class="tn-img">
                                                <img src="{{ asset($post->images->first()->path ?? ' ') }}"
                                                    alt="{{ $post->title }}" />
                                            </div>
                                            <div class="tn-title">
                                                <a href="{{ route('frontend.post.show', $post->slug) }}"
                                                    title="{{ $post->title }}">{{ $post->title }}</a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="sidebar-widget">
                        <h2 class="sw-title">News Category</h2>
                        <div class="category">
                            <ul>
                                @foreach ($categories as $category)
                                    <li><a href="{{ route('frontend.category.posts', $category->slug) }}"
                                            title="{{ $category->name }}">{{ $category->name }}</a><span>({{ $category->posts()->count() }})</span>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Single News End-->
@endsection

@push('js')
    <script>
        // Show More Comments:
        $(document).on('click', '#showMoreBtn', function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('frontend.post.getAllComments', $mainPost->slug) }}",
                type: 'GET',
                success: function(data) {
                    $('.comments').empty();
                    $.each(data, function(key, comment) {
                        $('.comments').append(`<div class="comment">
                      <img src="${comment.user.image}" alt="User Image" class="comment-img" />
                      <div class="comment-content">
                        <span class="username">${comment.user.name}</span>
                        <p class="comment-text">${comment.comment}</p>
                      </div>
                    </div>`);


                        $('#showMoreBtn').hide();
                    });


                },
                error: function(data) {

                },

            });
        });



        // Add Comment 

        $(document).on('submit', '#commentForm', function(e) {
            e.preventDefault();

            var formData = new FormData($(this)[0]);

            $('#commentInput').val('');


            $.ajax({

                url: "{{ route('frontend.post.comments.store') }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,

                success: function(data) {
                    $('#errorMsg').hide();

                    $('.comments').prepend(`<div class="comment">
                                    <img src="${data.comment.user.image}" alt="User Image" class="comment-img" />
                                    <div class="comment-content">
                                        <span class="username">${data.comment.user.name}</span>
                                        <p class="comment-text">${data.comment.comment}</p>
                                    </div>
                                </div>
                    
                    
                    
                    `);
                },

                error: function(data) {
                    var response = $.parseJSON(data.responseText);
                    $('#errorMsg').text(response.errors.comment).show();


                },


            });

        });
    </script>
@endpush
