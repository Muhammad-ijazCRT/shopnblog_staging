<!-- Start Modal payPerViewForm -->
<div class="modal fade" id="buyNowForm" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered @if ($product->type == 'digital') modal-sm @endif" role="document">
		<div class="modal-content">
			<div class="modal-body p-0">
				<div class="card bg-white shadow border-0">

					<div class="card-body px-lg-5 py-lg-5 position-relative">

						<div class="mb-4">
							<i class="bi-cart-plus mr-1"></i> <strong>{{ $product->name }}</strong>
						</div>

						<form method="post" action="{{url('buy/now/product')}}" id="shopProductForm">

							<input type="hidden" name="id" id="pdid" value="{{ $product->id }}" />
							@csrf


								@php
		
									$payment = '<img src="'.url('img/payments', auth()->user()->dark_mode == 'off' ? $paypal_payment->logo : 'paypal-white.png').'" width="70"/> <small class="w-100 d-block">'.trans('general.redirected_to_paypal_website').'</small>';
								@endphp



							<div class="custom-control custom-radio mb-3">
								<input name="paypal_payment_gateway_buy" @if (Helper::userWallet('balance') == 0) disabled @endif value="paypal" id="buy_paypal_radio0" class="custom-control-input" type="radio">
	
								<label class="custom-control-label" for="buy_paypal_radio0">
									<span>
										<strong>
										<span><strong>{!! $payment !!}</strong></span>
									</strong>
									</span>
								</label>
							</div>


							<div class="custom-control custom-radio mb-3">
								<input name="paypal_payment_gateway_buy" @if (Helper::userWallet('balance') == 0) disabled @endif value="wallet" id="buy_radio0" class="custom-control-input" type="radio">
								<label class="custom-control-label" for="buy_radio0">
									<span>
									<strong>
										<i class="fas fa-wallet mr-1 icon-sm-radio"></i> {{ __('general.wallet') }}
										<span class="w-100 d-block font-weight-light">
											{{ __('general.available_balance') }}: <span class="font-weight-bold mr-1 balanceWallet">{{Helper::userWallet()}}</span>

											@if (Helper::userWallet('balance') != 0 && $settings->wallet_format <> 'real_money')
												<i class="bi bi-info-circle text-muted" data-toggle="tooltip" data-placement="top" title="{{Helper::equivalentMoney($settings->wallet_format)}}"></i>
											@endif
											
											<a href="{{ url('my/wallet') }}" class="link-border">{{ __('general.recharge') }}</a>
									
										</span>
									</strong>
									</span>
								</label>
							</div>

							@if ($product->type == 'custom')
							<div class="form-group mb-2">
								<textarea class="form-control textareaAutoSize" name="description_custom_content" id="descriptionCustomContent" placeholder="{{ __('general.description_custom_content') }}" rows="4"></textarea>
							</div>

							<div class="alert alert-warning" role="alert">
							 <i class="bi-exclamation-triangle mr-2"></i> {{ __('general.alert_buy_custom_content') }}
							</div>
						@endif

						@if ($product->type == 'physical')
							<h6 class="mb-3"><i class="bi-truck mr-1"></i> {{ __('general.shipping') }}</h6>

							<div class="row form-group mb-0">

                                  <div class="col-md-12">
									<div class="input-group mb-4">
								<select name="cu_cuntry" id="cu_cun_buy" class="form-control">
                    <option value="" selected>Select Country</option>
                    @foreach (Countries::orderBy('country_name')->get() as $country)
                      <option value="{{$country->id}}">{{ $country->country_name }}</option>
                      @endforeach
                  </select>
									</div>
								</div>
								
								
								<div class="col-md-6">
									<div class="input-group mb-4">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-user"></i></span>
										</div>
										<input class="form-control" name="name" placeholder="Full recipient name"  value="" type="text">
									</div>
								</div>
								
								<div class="col-md-6">
									<div class="input-group mb-4">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-envelope"></i></span>
										</div>
										<input class="form-control" name="email" placeholder="Email address"  value="" type="email">
									</div>
								</div>
								
								
								
								<div class="col-md-6">
									<div class="input-group mb-4">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fas fa-city"></i></span>
										</div>
										<input class="form-control" name="state" placeholder="State/Province"  value="" type="text">
									</div>
								</div>

								<!-- ./col-md-6 -->

								<div class="col-md-6">
										<div class="input-group mb-4">
											<div class="input-group-prepend">
												<span class="input-group-text"><i class="fa fa-map-pin"></i></span>
											</div>
											<input class="form-control" name="city" placeholder="{{trans('general.city')}}"  value="{{auth()->user()->city}}" type="text">
										</div>
									</div><!-- ./col-md-6 -->

										<div class="col-md-6">
												<div class="input-group mb-4">
													<div class="input-group-prepend">
														<span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
													</div>
													<input class="form-control" name="zip" placeholder="{{trans('general.zip')}}"  value="{{auth()->user()->zip}}" type="text">
												</div>
											</div><!-- ./col-md-6 -->

											<div class="col-md-6">
													<div class="input-group mb-4">
														<div class="input-group-prepend">
															<span class="input-group-text"><i class="bi-telephone"></i></span>
														</div>
														<input class="form-control" name="phone" placeholder="{{trans('general.phone')}}" type="tel">
													</div>
												</div><!-- ./col-md-6 -->


                                       <div class="col-md-12">
									<div class="input-group mb-4">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class="fa fa-map-marked-alt"></i></span>
										</div>
										<textarea class="form-control" name="address" placeholder="{{trans('general.address')}}"  value="{{auth()->user()->address}}"></textarea>
									</div>
								</div>
											</div><!-- ./row -->

						<div class="alert alert-warning" role="alert">
						 <i class="bi-exclamation-triangle mr-2"></i> {{ __('general.alert_buy_custom_content') }}
						</div>
					@endif

							@if (auth()->user()->isTaxable()->count() || $product->shipping_fee <> 0.00 && $product->country_free_shipping <> auth()->user()->countries_id)
								<ul class="list-group list-group-flush border-dashed-radius">

									<li class="list-group-item py-1 list-taxes">
								    <div class="row">
								      <div class="col">
								        <small>{{trans('general.subtotal')}}:</small>
								      </div>
								      <div class="col-auto">
								        <small class="subtotal font-weight-bold">
								         {{Helper::amountFormatDecimal($product->price)}} 
								        </small>
								      </div>
								    </div>
								  </li>

									@foreach (auth()->user()->isTaxable() as $tax)
										<li class="list-group-item py-1 list-taxes isTaxable">
									    <div class="row">
									      <div class="col">
									        <small>{{ $tax->name }} {{ $tax->percentage }}%:</small>
									      </div>
									      <div class="col-auto percentageAppliedTax">
									        <small class="font-weight-bold">
									        	{{ Helper::amountFormatDecimal(Helper::calculatePercentage($product->price, $tax->percentage)) }}
									        </small>
									      </div>
									    </div>
									  </li>
									@endforeach

									@if ($product->shipping_fee <> 0.00 && $product->country_free_shipping <> auth()->user()->countries_id)
										<li class="list-group-item py-1 list-taxes" id="shiping_disa">
									    <div class="row">
									      <div class="col">
									        <small>{{trans('general.shipping_feesss')}}:</small>
									      </div>
									      <div class="col-auto">
									        <small class="totalPPV font-weight-bold">
									        {{ Helper::amountFormatDecimal($product->shipping_fee) }}
									        </small>
									      </div>
									    </div>
									  </li>
									@endif
                                    <li class="list-group-item py-1 list-taxes isTaxable " id="spacia_shiping" style="display:none">
									    <div class="row">
									      <div class="col">
									        <small>{{trans('general.sp_cu')}}:</small>
									      </div>
									      <div class="col-auto percentageAppliedTax">
									        <small class="font-weight-bold" id="shipingfees">
									        	
									        </small>
									      </div>
									    </div>
									  </li>
									<li class="list-group-item py-1 list-taxes">
								    <div class="row">
								      <div class="col">
								        <small>{{trans('general.total')}}:</small>
								      </div>
								      <div class="col-auto">
								        <small class="totalPPV font-weight-bold totalsp">
								        {{Helper::calculateProductPriceOnStore($product->price, $product->country_free_shipping <> auth()->user()->countries_id ? $product->shipping_fee : 0.00)}}
								        </small>
								      </div>
								    </div>
								  </li>
								</ul>
							@endif

							<div class="alert alert-danger display-none mb-0 mt-2" id="errorShopProduct">
									<ul class="list-unstyled m-0" id="showErrorsShopProduct"></ul>
								</div>

							<div class="text-center">
								<button type="submit" @if (Helper::userWallet('balance') == 0) disabled @endif id="shopProductBtn" class="btn btn-primary mt-4 BuyNowBtn">
								    <span style="display:none" id='spone'><i class="fas fa-circle-notch fa-spin" style="font-size:24px"></i></span>
								    <span id='sptwo'>
								        <i></i> {{trans('general.pay')}}
								        <span class="totalsp">
								        {{Helper::calculateProductPriceOnStore($product->price, $product->country_free_shipping <> auth()->user()->countries_id ? $product->shipping_fee : 0.00)}}
								        </span>
								       <small>{{$settings->currency_code}}</small>
								    </span>
									</button>

								<div class="w-100 mt-2">
									<a href="#" class="btn e-none p-0" data-dismiss="modal">{{trans('admin.cancel')}}</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Modal BuyNow -->
