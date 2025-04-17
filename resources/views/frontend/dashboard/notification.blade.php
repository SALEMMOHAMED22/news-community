@extends('layouts.frontend.app')

@section('title')
    Notification
@endsection

@section('body')
    <!-- Dashboard Start-->
    <div class="dashboard container">
    @include('frontend.dashboard._sidebar' , ['notify_active' =>'active'])
      

        <!-- Main Content -->
        <div class="main-content">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <h2 class="mb-4">Notifications</h2>
                    </div>
                    <div class="col-6">
                        <a  href="{{ route('frontend.dashboard.notification.deleteAll') }}" style="margin-left: 270px" class="btn btn-sm btn-danger">Delete all </a >
                    </div>

                </div>
                    @forelse (auth()->user()->notifications as $notify)
                    <a href="{{ route('frontend.post.show' , $notify->data['post_slug']) }}?notify={{ $notify->id }}">
                        <div class="notification alert alert-info">
                            <strong> You have a notification from : {{ $notify->data['user_name'] }}</strong> Post title: {{ $notify->data['post_title'] }} .  ( {{ $notify->created_at->diffForHumans() }} )
                            <div class="float-right">
                                <button onclick="if(confirm('Are you sure to delete notification !')){document.getElementById('deleteNotify').submit()} return false " class="btn btn-danger btn-sm">Delete</button>
                            </div>
                        </div>
                    </a>

                    <form id="deleteNotify" action="{{ route('frontend.dashboard.notification.delete') }}" method="POST">
                        @csrf
                        <input type="hidden" name="notify_id" value="{{ $notify->id }}">
                    </form>
                        
                    @empty

                        <div class="alert alert-info">
                            No Notifications Yet!
                        </div>                        
                    @endforelse
                    
                    
                  
                    
                        
                 
              
            </div>
        </div>
    </div>
    <!-- Dashboard End-->
@endsection
