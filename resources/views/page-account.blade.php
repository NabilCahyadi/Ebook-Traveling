@extends('layouts_lp.app')

@section('title', 'My Account - MeatMap')

@section('content')
<main class="main pages">
    <div class="page-header mt-30 mb-30">
        <div class="container">
            <div class="archive-header">
                <div class="row align-items-center">
                    <div class="col-xl-3">
                        <h1 class="mb-15">My Account</h1>
                        <div class="breadcrumb">
                            <a href="/" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                            <span></span> My Account
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-content">
        <div class="col-lg-10 m-auto">
            <div class="row">
                <div class="col-md-3">
                    <div class="dashboard-menu">
                        <ul class="nav flex-column" role="tablist">
                            <!-- DASHBOARD -->
                            <li class="nav-item">
                                <a class="nav-link active" id="dashboard-tab" data-bs-toggle="tab" href="#dashboard" role="tab" aria-controls="dashboard" aria-selected="false">
                                    <i class="fi-rs-settings-sliders mr-10"></i>Dashboard
                                </a>
                            </li>

                            <!-- WISHLIST -->
                            <li class="nav-item">
                                <a class="nav-link" id="orders-tab" data-bs-toggle="tab" href="#orders" role="tab" aria-controls="orders" aria-selected="false">
                                    <i class="fi fi-rs-heart mr-10"></i>Wishlist
                                </a>
                            </li>

                            <!-- PROFILE SETTINGS -->
                            <li class="nav-item">
                                <a class="nav-link" id="account-detail-tab" data-bs-toggle="tab" href="#account-detail" role="tab" aria-controls="account-detail" aria-selected="true">
                                    <i class="fi-rs-user mr-10"></i>Profile Settings
                                </a>
                            </li>

                            <!-- PAYMENT HISTORY -->
                            <li class="nav-item">
                                <a class="nav-link" id="payment-tab" data-bs-toggle="tab" href="#payment" role="tab" aria-controls="payment" aria-selected="true">
                                    <i class="fi-rs-credit-card mr-10"></i>Payment History
                                </a>
                            </li>

                            <!-- LOGOUT -->
                            <li class="nav-item">
                                {{-- Form Logout User --}}
                                <form method="POST" action="{{ route('user.logout') }}" id="nav-logout-form" style="display: none;">
                                    @csrf
                                </form>
                                <a class="nav-link" onclick="event.preventDefault(); document.getElementById('nav-logout-form').submit();">
                                    <i class="fi-rs-sign-out mr-10"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content account dashboard-content pl-50">
                        <!-- DASHBOARD TAB -->
                        <div class="tab-pane fade active show" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="mb-0">Hello Lala Kahla!</h3>
                                </div>
                                <div class="card-body">
                                    <p>
                                        From your account dashboard. you can easily check &amp; view your <a href="#">recent orders</a>,<br />
                                        manage your <a href="#">shipping and billing addresses</a> and <a href="#">edit your password and account details.</a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- WISHLIST TAB -->
                        <div class="tab-pane fade" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Your Wishlist</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Ebook</th>
                                                    <th>Category</th>
                                                    <th>Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Bali Travel Guide 2024</td>
                                                    <td>Travel Guide</td>
                                                    <td>$9.99</td>
                                                    <td><a href="#" class="btn-small d-block">Read Now</a></td>
                                                </tr>
                                                <tr>
                                                    <td>Japan Culinary Journey</td>
                                                    <td>Culinary</td>
                                                    <td>$12.99</td>
                                                    <td><a href="#" class="btn-small d-block">Read Now</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- PROFILE SETTINGS TAB -->
                        <div class="tab-pane fade" id="account-detail" role="tabpanel" aria-labelledby="account-detail-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Profile Settings</h5>
                                </div>
                                <div class="card-body">
                                    <form method="post" name="enq">
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label>First Name <span class="required">*</span></label>
                                                <input required="" class="form-control" name="name" type="text" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label>Last Name <span class="required">*</span></label>
                                                <input required="" class="form-control" name="phone" />
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Display Name <span class="required">*</span></label>
                                                <input required="" class="form-control" name="dname" type="text" />
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Email Address <span class="required">*</span></label>
                                                <input required="" class="form-control" name="email" type="email" />
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Current Password <span class="required">*</span></label>
                                                <input required="" class="form-control" name="password" type="password" />
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>New Password <span class="required">*</span></label>
                                                <input required="" class="form-control" name="npassword" type="password" />
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label>Confirm Password <span class="required">*</span></label>
                                                <input required="" class="form-control" name="cpassword" type="password" />
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-fill-out submit font-weight-bold" name="submit" value="Submit">Save Change</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- PAYMENT HISTORY TAB -->
                        <div class="tab-pane fade" id="payment" role="tabpanel" aria-labelledby="payment-tab">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Payment History</h5>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Order ID</th>
                                                    <th>Date</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>#SUB001</td>
                                                    <td>Jan 15, 2024</td>
                                                    <td>$9.99</td>
                                                    <td><span class="badge bg-success">Paid</span></td>
                                                    <td><a href="#" class="btn-small d-block">View</a></td>
                                                </tr>
                                                <tr>
                                                    <td>#SUB002</td>
                                                    <td>Feb 15, 2024</td>
                                                    <td>$9.99</td>
                                                    <td><span class="badge bg-warning">Pending</span></td>
                                                    <td><a href="#" class="btn-small d-block">Pay Now</a></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection