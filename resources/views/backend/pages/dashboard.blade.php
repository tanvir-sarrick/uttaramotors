@extends('backend.layout.template')
@section('title', 'Dashboard')
@section('home', 'active')
@section('style')
    <style>
        .info-box {
        box-shadow: 0 0 1px rgba(0,0,0,.125),0 1px 3px rgba(0,0,0,.2);
        border-radius: .25rem;
        background-color: #fff;
        display: -ms-flexbox;
        display: flex;
        margin-bottom: 1rem;
        min-height: 80px;
        padding: .5rem;
        position: relative;
        width: 100%;
        }
        .info-box .info-box-icon {
        border-radius: .25rem;
        -ms-flex-align: center;
        align-items: center;
        display: -ms-flexbox;
        display: flex;
        font-size: 2.875rem;
        -ms-flex-pack: center;
        justify-content: center;
        text-align: center;
        width: 70px;
        color: #fff;
        }
        .info-box .info-box-content {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-direction: column;
        flex-direction: column;
        -ms-flex-pack: center;
        justify-content: center;
        line-height: 1.8;
        -ms-flex: 1;
        flex: 1;
        padding: 0 10px;
        overflow: hidden;
        color: #fff;
        }
        .info-box .info-box-text, .info-box .progress-description {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        }
        .info-box .info-box-number {
        display: block;
        margin-top: .25rem;
        font-weight: 700;
        font-size: 25px;
        }
        .info-box .progress {
        background-color: #787878;
        }
        .info-box .progress {
        background-color: rgba(0,0,0,.125);
        height: 2px;
        margin: 5px 0;
        }
        .info-box .progress .progress-bar {
        background-color: #f39c12;
        }
        .col-lg-3 .info-box .progress-description, .col-md-3 .info-box .progress-description, .col-xl-3 .info-box .progress-description {
            font-size: 1rem;
            display: block;
        }
    </style>
@endsection
@section('content')
<div class="row">
    <div class="col-lg-4 col-6">
        <div class="info-box bg-primary">
            <span class="info-box-icon"> <i class="ti ti-users-group"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Users</span>
                <span class="info-box-number"></span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                   Total Online Events
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-lg-4 col-6">
        <div class="info-box bg-success">
            <span class="info-box-icon"> <i class="ti ti-users-group"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Daily Users</span>
                <span class="info-box-number"></span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                    Total Daily Users
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-lg-4 col-6">
        <div class="info-box bg-info">
            <span class="info-box-icon"> <i class="ti ti-users-group"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Monthly Users</span>
                <span class="info-box-number"></span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                    Last 30 Days
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-lg-4 col-6">
        <div class="info-box bg-danger">
            <span class="info-box-icon"> <i class="ti ti-users-group"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total Subscription</span>
                <span class="info-box-number"></span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                   Total Subscriptions
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-lg-4 col-6">
        <div class="info-box bg-danger">
            <span class="info-box-icon"> <i class="ti ti-users-group"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Daily Subscriptions</span>
                <span class="info-box-number"></span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                   Total Daily Subscriptions
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-lg-4 col-6">
        <div class="info-box bg-secondary">
            <span class="info-box-icon"> <i class="ti ti-users-group"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Monthly Subscriptions</span>
                <span class="info-box-number"></span>

                <div class="progress">
                    <div class="progress-bar" style="width: 70%"></div>
                </div>
                <span class="progress-description">
                    Last 30 Days
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
@endsection
