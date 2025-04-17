@extends('layouts.frontend.app')

@section('title')
    Setting
@endsection

@section('body')
    <!-- Dashboard Start-->

    <div class="dashboard container">
        @include('frontend.dashboard._sidebar', ['setting_active' => 'active'])


        <!-- Main Content -->
        <div class="main-content">
            <!-- Settings Section -->
            <h2>Settings</h2>
            <form class="settings-form" action="{{ route('frontend.dashboard.setting.update') }}" enctype="multipart/form-data"
                method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input name="name" type="text" id="name" value="{{ $user->name }}" />
                    @error('name')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input name="username" type="text" id="username" value="{{ $user->username }}" />
                    @error('username')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input name="email" type="email" id="email" value="{{ $user->email }}" />
                    @error('email')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="profile-image">Profile Image:</label>
                    <input name="image" type="file" id="profile-image" accept="image/*" />
                    @error('image')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <img id="profile_image" class="img-thumbnail" src="{{ asset($user->image) }}" width="180px">
                </div>
                <div class="form-group">
                    <label for="country">Country:</label>
                    <input name="country" type="text" id="country" value="{{ $user->country }}"
                        placeholder="Enter your country" />
                    @error('country')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="city">City:</label>
                    <input name="city" type="text" id="city" value="{{ $user->city }}"
                        placeholder="Enter your city" />
                    @error('city')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="street">Street:</label>
                    <input name="street" type="text" id="street" value="{{ $user->street }}"
                        placeholder="Enter your street" />
                    @error('street')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input name="phone" type="text" id="phone" value="{{ $user->phone }}"
                        placeholder="Enter your phone" />
                    @error('phone')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="save-settings-btn">
                    Save Changes
                </button>
            </form>

            <!-- Form to change the password -->
            <form class="change-password-form" action="{{ route('frontend.dashboard.setting.changePassword') }}"
                method="POST">
                @csrf
                <h2>Change Password</h2>
                <div class="form-group">
                    <label for="current-password">Current Password:</label>
                    <input name="current_password" type="password" id="current-password"
                        placeholder="Enter Current Password" />
                    @error('current_password')
                        <strong class="text-danger">
                            {{ $message }}
                        </strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="new-password">New Password:</label>
                    <input name="newPassword" type="password" id="new-password" placeholder="Enter New Password" />
                    @error('newPassword')
                        <strong class="text-danger">
                            {{ $message }}
                        </strong>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="confirm-password">Confirm New Password:</label>
                    <input name="newPassword_confirmation" type="password" id="confirm-password"
                        placeholder="Enter Confirm New " />
                </div>
                <button type="submit" class="change-password-btn">
                    Change Password
                </button>
            </form>

        </div>
    </div>

    <!-- Dashboard End-->
@endsection


@push('js')
<script>
    $(document).on('change', '#profile-image', function(e) {
        e.preventDefault();
        var file = this.files[0];

        if (file) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#profile_image').attr('src', e.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
</script>

@endpush
