@extends('tracki.layout.dashboard')
@section('main')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<div class="content">


    <div class="row profile-body">
        <!-- left wrapper start -->
        <div class="d-none d-md-block col-md-4 col-xl-3 left-wrapper">
            <div class="card rounded">
                <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="ms-2">
                            <img class="wd-100 rounded-circle" src="{{(!empty($profileData->photo)) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg')}}" alt="profile">
                            <span class="h4 ms-3">{{ $profileData->username }}</span>
                            </div>
                        </div>
                        <div class="dropdown">
                            <a type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="icon-lg pb-3px" data-feather="more-horizontal"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="meh" class="icon-sm me-2"></i> <span class="">Unfollow</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="corner-right-up" class="icon-sm me-2"></i> <span class="">Go to
                                        post</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="share-2" class="icon-sm me-2"></i> <span class="">Share</span></a>
                                <a class="dropdown-item d-flex align-items-center" href="javascript:;"><i
                                        data-feather="copy" class="icon-sm me-2"></i> <span class="">Copy
                                        link</span></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Name:</label>
                        <p class="text-muted">{{ $profileData->name }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Email:</label>
                        <p class="text-muted">{{ $profileData->email }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Phone:</label>
                        <p class="text-muted">{{ $profileData->phone }}</p>
                    </div>
                    <div class="mt-3">
                        <label class="tx-11 fw-bolder mb-0 text-uppercase">Address:</label>
                        <p class="text-muted">{{ $profileData->address }}</p>
                    </div>
                    <div class="mt-3 d-flex social-links">
                        <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="github"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="twitter"></i>
                        </a>
                        <a href="javascript:;" class="btn btn-icon border btn-xs me-2">
                            <i data-feather="instagram"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- left wrapper end -->
        <!-- middle wrapper start -->
        <div class="col-md-8 col-xl-6 middle-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin">
                    <div class="card rounded">

                        <div class="card-body">
                            <h6 class="card-title">Update User Profile</h6>

                            <form method="POST" action="{{ route('tracki.profile.store')}}" class="forms-sample"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="exampleInputUsername1" class="form-label">Username</label>
                                    <input type="text" name="username" class="form-control"
                                        value="{{$profileData->username}}" id="exampleInputUsername1" autocomplete="off"
                                        placeholder="Username">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputName1" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" value="{{$profileData->name}}"
                                        id="exampleInputName1" autocomplete="off" placeholder="name">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                                    <input type="email" name="email" class="form-control"
                                        value="{{$profileData->email}}" id="exampleInputEmail1" placeholder="Email">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPhone1" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{$profileData->phone}}"
                                        id="exampleInputPhone1" autocomplete="off" placeholder="phone">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputAddress1" class="form-label">Address</label>
                                    <input type="text" name="address" class="form-control"
                                        value="{{$profileData->address}}" id="exampleInputAddress1" autocomplete="off"
                                        placeholder="address">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleInputPhoto1" class="form-label">Photo</label>
                                    <input type="file" name="photo" class="form-control" id="image">
                                </div>

                                <div class="mb-3">
                                    <label for="exampleInputPhoto1" class="form-label"></label>
                                    <img id="showImage" class="wd-50 rounded-circle"
                                        src="{{(!empty($profileData->photo)) ? url('upload/admin_images/'.$profileData->photo) : url('upload/no_image.jpg')}}"
                                        alt="profile">

                                </div>

                                <button type="submit" class="btn btn-primary me-2">Save Changes</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </div> -->
        <!-- middle wrapper end -->
        <!-- right wrapper start -->

        <!-- right wrapper end -->
    </div>
</div>,

<script type="text/javascript">
$(document).ready(function() {
    $('#image').change(function(e) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#showImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.target.files['0']);
    });
});
</script>
@endsection
