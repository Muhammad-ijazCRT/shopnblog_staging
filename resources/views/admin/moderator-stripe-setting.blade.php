@extends('admin.layout')

@section('css')
<link href="{{ asset('public/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/plugins/select2/select2.min.css') }}?v={{ $settings->version }}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h4>
            {{ trans('admin.admin') }}
            <i class="fa fa-angle-right margin-separator"></i>
            {{ trans('admin.moderator_admin') }}
            <i class="fa fa-angle-right margin-separator"></i>
            {{ trans('admin.payment_settings') }} - {{ trans('admin.moderator_admin_stripe') }}
        </h4>
    </section>

    <!-- Main content -->
    <section class="content">

        @if (Session::has('success_message'))
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            <i class="fa fa-check margin-separator"></i> {{ Session::get('success_message') }}
        </div>
        @endif

        <div class="content">

            <div class="row">

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.payment_settings') }} - {{ trans('admin.moderator_admin_stripe') }}</h3>
                    </div><!-- /.box-header -->

                    <!-- form start -->
                    <form class="form-horizontal d-none" method="POST" action="{{ url('panel/admin/moderator-admin-stripe') }}" enctype="multipart/form-data">

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        @include('errors.errors-forms')

                        <hr />

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Stripe Publishable Key</label>
                                <div class="col-sm-10">
                                    <input type="text" value="{{ $data->key }}" name="key" class="form-control">
                                    <p class="help-block"><a href="https://dashboard.stripe.com/account/apikeys" target="_blank">https://dashboard.stripe.com/account/apikeys</a></p>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Stripe Secret Key</label>
                                <div class="col-sm-10">
                                    <input type="password" value="{{ $data->key_secret }}" name="key_secret" class="form-control">
                                    <p class="help-block"><a href="https://dashboard.stripe.com/account/apikeys" target="_blank">https://dashboard.stripe.com/account/apikeys</a></p>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Stripe Webhook Secret</label>
                                <div class="col-sm-10">
                                    <input type="password" value="{{ $data->webhook_secret }}" name="webhook_secret" class="form-control">
                                    <p class="help-block"><a href="https://dashboard.stripe.com/webhooks" target="_blank">https://dashboard.stripe.com/webhooks</a></p>
                                </div>
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>
                        </div><!-- /.box-footer -->
                    </form>

                    <!-- Connect form -->
                        <!-- Start Box Body -->
                        <div class="box-body">
                            <div class="form-group">
                                <label class="col-sm-2 control-label">{{ trans('admin.moderator_connect_account_id') }}</label>
                                <div class="col-sm-10">
                                <span class="form-control">{{$stripe_moderator_account_id}}</span>
                                    @if (auth()->user()->role == 'moderator_admin')
                                        @if ($stripe_moderator_account_id)
                                            <a href="{{ route('moderator.redirect.stripe_view') }}" class="btn w-100 btn-lg btn-primary btn-arrow" style="margin-top: 10px;">
                                                {{ __('general.view_stripe_account') }}
                                            </a>
                                        @endif
                                            <a href="{{ route('moderator.redirect.stripe') }}" class="btn w-100 btn-lg btn-primary btn-arrow" style="margin-top: 10px;">
                                                {{ __('general.connect_stripe_account') }}
                                            </a>
                                    @endif
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                </div>
            </div><!-- /.row -->
        </div><!-- /.content -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
@endsection