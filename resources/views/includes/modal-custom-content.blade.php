<!-- Start Modal payPerViewForm -->
<div class="modal fade" id="customContentForm{{$sale->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true" style="z-index: 10500 !important;Overflow: visible">
	<div class="modal-dialog modal- modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body p-0">
				<div class="card bg-white shadow border-0">

					<div class="card-body px-lg-5 py-lg-5 position-relative">

						<div class="mb-4 position-relative">
							 <strong>{{ $sale->products()->type == 'physical' ? __('general.shipping_information') : __('general.details_custom_content') }}</strong>
							 <small data-dismiss="modal" class="btn-cancel-msg"><i class="bi bi-x-lg"></i></small>
						</div>
                            <h6 class="font-weight-light">{{ __('general.name') }} : @if($sale->name){{ $sale->name }}@endif</h6>
						    <h6 class="font-weight-light">{{ __('general.phone') }} : @if($sale->phone){{ $sale->phone }}@endif</h6>
						<h6 class="font-weight-light">
							{{ __('auth.email') }}:

							@if (! isset($sale->user()->email))
								{{ trans('general.no_available') }}
							@else
							@if($sale->email)
							{{ $sale->email }}
							@else
							{{ $sale->user()->email }}
							@endif
						@endif
						</h6>

						@if ($sale->products()->type == 'physical')
						    <h6 class="font-weight-light">{{ __('general.country') }} : @if($sale->cu_cuntry){{Helper::spacial($sale->cu_cuntry)->country_name }}@endif</h6>
						    <h6 class="font-weight-light">{{ __('general.state') }} : {{ $sale->state }}</h6>
							<h6 class="font-weight-light">{{ __('general.city') }} : {{ $sale->city }}</h6>
							<h6 class="font-weight-light">{{ __('general.zip') }} : {{ $sale->zip }}</h6>
							<h6 class="font-weight-light">{{ __('general.address') }} : {{ $sale->address }}</h6>
							
						@endif

						<p>
							{!! Helper::checkText($sale->description_custom_content) !!}
						</p>

					</div><!-- End card-body -->
				</div><!-- End card -->
			</div><!-- End modal-body -->
		</div><!-- End modal-content -->
	</div><!-- End Modal-dialog -->
</div><!-- End Modal BuyNow -->
