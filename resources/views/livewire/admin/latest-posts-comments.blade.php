 
<div class="row">
     <!-- Latest Posts -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Latest Posts</h6>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Comments</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                     
                       @forelse ($latest_posts as $post)
                       <tr>
                        <th>
                        @can('posts')
                        <a href="{{ route('admin.posts.show', $post->id) }}">
                            {{ Illuminate\Support\Str::limit($post->title, 10) }}
                        </a>
                        @endcan
                        @cannot('posts')
                        {{ Illuminate\Support\Str::limit($post->title, 10) }}
                        @endcannot

                        
                    </th>
                        <th>{{ $post->category->name }}</th>
                        <th>{{ $post->comments_count }}</th>
                        <th>{{ $post->status == 1 ? 'Active' : 'Inactive' }}</th>
                    </tr>
                       @empty
                       <tr>
                        <th colspan="4" class="text-center">No Data Found</th>
                       </tr>
                       @endforelse

                    </tbody>
                </table>
            </div>
        </div>

     
    </div>

    <!-- Latest Comments -->
    <div class="col-lg-6 mb-4"> 
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Latest Comments</h6>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Post</th>
                            <th>Comment</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @forelse ($latest_comments as $comment)
                        <tr>
                            <th>{{ $comment->user->name }}</th>
                            <th>
                                @can('posts')
                                <a href="{{ route('admin.posts.show', $comment->post->id) }}">
                                    {{ Illuminate\Support\Str::limit($comment->post->title, 10) }}
                                </a>
                                @endcan
                                @cannot('posts')
                                {{ Illuminate\Support\Str::limit($comment->post->title, 10) }}
                                @endcannot
                            </th>
                            <th>{{ Illuminate\Support\Str::limit($comment->comment, 40) }}</th>
                            <th>{{ $comment->status == 1 ? 'Active' : 'Inactive' }}</th>
                        </tr>
                        @empty
                        <tr>
                            <th colspan="4" class="text-center">No Data Found</th>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>
        </div>

        

    </div>
</div>
