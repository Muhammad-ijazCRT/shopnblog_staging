@extends('admin.layout')

@section('css')
<link href="{{ asset('public/plugins/iCheck/all.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/plugins/tagsinput/jquery.tagsinput.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/plugins/select2/select2.min.css') }}?v={{$settings->version}}" rel="stylesheet" type="text/css" />
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
            		{{ trans('admin.earning_settings') }}
          </h4>
        </section>

        <!-- Main content -->
        <section class="content">

        	 @if(Session::has('success_message'))
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
                  <h3 class="box-title">{{ trans('admin.earning_settings') }}</h3>
                </div><!-- /.box-header -->

                <!-- form start -->
                <form class="form-horizontal" method="POST" action="{{ url('panel/admin/moderator-admin') }}" enctype="multipart/form-data">

                	<input type="hidden" name="_token" value="{{ csrf_token() }}">

					@include('errors.errors-forms')

                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.fee_moderator_admin_commission') }}</label>
                      <div class="col-sm-10">
                        @if (auth()->user()->role == 'admin')
                      	    <select name="fee_moderator_admin_commission" class="form-control">
                                @for ($i=0; $i <= 100; ++$i)
                                <option @if ($fee_moderator_admin_commission == $i) selected="selected" @endif value="{{$i}}">{{$i}}%</option>
                                @endfor
                            </select>
                        @else
                            <input type="hidden" value="{{$fee_moderator_admin_commission}}" name="fee_moderator_admin_commission"/>
                            <span class="form-control">{{$fee_moderator_admin_commission}}%</span>
                        @endif
                            <p class="help-block">{{ trans('admin.notice_moderator_admin_fee_commission') }}</p>
                      </div>
                    </div>
                  </div><!-- /.box-body -->
                  <!-- Start Box Body -->
                  <div class="box-body">
                    <div class="form-group">
                      <label class="col-sm-2 control-label">{{ trans('admin.moderator_connect_account_id') }}</label>
                      <div class="col-sm-10">
                        @if (auth()->user()->role == 'admin')
                            <input type="text" value="{{$stripe_moderator_account_id}}" name="stripe_moderator_account_id" class="form-control"/>
                            <p class="help-block"><a href="https://dashboard.stripe.com/connect" target="_blank">https://dashboard.stripe.com/connect</a></p>
                        @elseif (auth()->user()->role == 'moderator_admin')
                            <input type="hidden" value="{{$stripe_moderator_account_id}}" name="stripe_moderator_account_id"/>
                            <span class="form-control">{{$stripe_moderator_account_id}}</span>

                            @if (!$stripe_moderator_account_id)
                                <a href="{{ route('redirect.stripe') }}" class="btn w-100 btn-lg btn-primary btn-arrow" style="margin-top: 10px;">
                                        {{ __('general.connect_stripe_account') }}
                                </a>
                            @else
                                <a href="{{ route('moderator.redirect.stripe_view') }}" class="btn w-100 btn-lg btn-primary btn-arrow" style="margin-top: 10px;">
                                    {{ __('general.view_stripe_account') }}
                                </a>
                            @endif
                        @endif
                      </div>
                    </div>
                  </div><!-- /.box-body -->

                  <!-- Start Box Body -->
               <div class="box-body">
                 <div class="form-group">
                   <label class="col-sm-2 control-label">{{ trans('admin.status') }}</label>
                   <div class="col-sm-10">
                     <div class="radio">
                     <label class="padding-zero">
                       <input type="radio" value="1" name="moderator_payment_enable" @if( $moderator_payment_enable == 1 ) checked="checked" @endif checked>
                       {{ trans('admin.active') }}
                     </label>
                   </div>
                   <div class="radio">
                     <label class="padding-zero">
                       <input type="radio" value="0" name="moderator_payment_enable" @if( $moderator_payment_enable == 0 ) checked="checked" @endif>
                       {{ trans('admin.disabled') }}
                     </label>
                   </div>
                   </div>
                 </div>
               </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-success">{{ trans('admin.save') }}</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
        		</div><!-- /.row -->
        	</div><!-- /.content -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
@endsection
