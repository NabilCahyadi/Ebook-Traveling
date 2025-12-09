@extends('layouts.admin')

@section('title', 'Edit Profile')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-4">
                    <h5 class="card-header">Profile Details</h5>
                    <!-- Account -->
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="formAccountSettings" method="POST" action="{{ route('admin.profile.update') }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="d-flex align-items-start align-items-sm-center gap-4 mb-4">
                                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/admin/img/avatars/default.jpeg') }}"
                                    alt="user-avatar" class="d-block w-px-100 h-px-100 rounded" id="uploadedAvatar" />
                                <div class="button-wrapper">
                                    <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                        <span class="d-none d-sm-block">Upload new photo</span>
                                        <i class="ti ti-upload d-block d-sm-none"></i>
                                        <input type="file" id="upload" class="account-file-input" hidden
                                            accept="image/png, image/jpeg, image/jpg, image/gif" name="avatar" />
                                    </label>
                                    <button type="button" class="btn btn-label-secondary account-image-reset mb-3"
                                        id="resetAvatar">
                                        <i class="ti ti-refresh d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Reset</span>f
                                    </button>

                                    <div class="text-muted small">Allowed JPG, GIF or PNG. Max size of 2MB</div>
                                    @error('avatar')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        id="name" name="name" value="{{ old('name', $user->name) }}" autofocus
                                        required />
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phone">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">ID (+62)</span>
                                        <input type="text" id="phone" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            placeholder="812 3456 7890" value="{{ old('phone', $user->phone) }}" />
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="city" class="form-label">City</label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror"
                                        id="city" name="city" value="{{ old('city', $profile->city ?? '') }}" />
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control @error('address') is-invalid @enderror"
                                        id="address" name="address"
                                        value="{{ old('address', $profile->address ?? '') }}" />
                                    @error('address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="country" class="form-label">Country</label>
                                    <input type="text" class="form-control @error('country') is-invalid @enderror"
                                        id="country" name="country"
                                        value="{{ old('country', $profile->country ?? 'Indonesia') }}" />
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label for="bio" class="form-label">Bio</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3"
                                        maxlength="1000">{{ old('bio', $profile->bio ?? '') }}</textarea>
                                    <div class="form-text">Brief description for your profile. Max 1000 characters.</div>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2">Save changes</button>
                                <button type="reset" class="btn btn-label-secondary">Cancel</button>
                            </div>
                        </form>
                    </div>
                    <!-- /Account -->
                </div>

                <!-- Change Password -->
                <div class="card mb-4">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                        <form id="formChangePassword" method="POST"
                            action="{{ route('admin.profile.password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="mb-3 col-md-12 form-password-toggle">
                                    <label class="form-label" for="current_password">Current Password</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control @error('current_password') is-invalid @enderror"
                                            type="password" id="current_password" name="current_password" required />
                                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                        @error('current_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="password">New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control @error('password') is-invalid @enderror"
                                            type="password" id="password" name="password" required />
                                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="form-text">Password must be at least 8 characters long.</div>
                                </div>

                                <div class="mb-3 col-md-6 form-password-toggle">
                                    <label class="form-label" for="password_confirmation">Confirm New Password</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" id="password_confirmation"
                                            name="password_confirmation" required />
                                        <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary me-2">Change Password</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ Change Password -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview uploaded image
            const accountFileInput = document.querySelector('.account-file-input');
            const uploadedAvatar = document.getElementById('uploadedAvatar');
            const resetAvatar = document.getElementById('resetAvatar');
            const originalAvatar = uploadedAvatar.src;

            if (accountFileInput) {
                accountFileInput.onchange = function() {
                    if (this.files && this.files[0]) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            uploadedAvatar.src = e.target.result;
                        }
                        reader.readAsDataURL(this.files[0]);
                    }
                };
            }

            // Reset avatar to original
            if (resetAvatar) {
                resetAvatar.onclick = function() {
                    uploadedAvatar.src = originalAvatar;
                    accountFileInput.value = '';
                };
            }
        });
    </script>
@endpush
