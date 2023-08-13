<!-- Start Modal payPerViewForm -->
<div class="modal fade" id="editForm" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
	<div class="modal-dialog modal- modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-body p-0">
				<div class="card bg-white shadow border-0">

					<div class="card-body px-lg-5 py-lg-5 position-relative">

						<div class="mb-4">
							{{ __('admin.edit') }} <i class="bi-arrow-right ml-1 mr-1"></i> <strong>{{ $product->name }}</strong>
						</div>

						<form method="post" action="{{url('edit/product', $product->id)}}" id="shopProductForm">

							<input type="hidden" name="id" value="{{ $product->id }}" />
							@csrf

							<div class="form-group">
                <input type="text" class="form-control" value="{{ $product->name }}" name="name" placeholder="{{ __('admin.name') }}">
              </div>

							<div class="form-group">
								<input type="text" class="form-control isNumber" value="{{ $product->price }}" autocomplete="off" name="price" placeholder="{{ __('general.price') }}">
							</div>

							@if ($product->type == 'physical')
							<div class="form-group">
								<input type="text" class="form-control isNumber" value="{{ $product->shipping_fee }}" autocomplete="off" name="shipping_fee" placeholder="{{ __('general.shipping_fee') }}">
							</div>

						<div class="form-group">
							<select name="country_free_shipping" class="form-control custom-select" id="cu_free">
								<option value="" selected>{{ __('general.country_free_shipping') }}</option>
								@foreach (Countries::orderBy('country_name')->get() as $country)
									<option @if ($product->country_free_shipping == $country->id ) selected="selected" @endif value="{{$country->id}}">{{ $country->country_name }}</option>
									@endforeach
							</select>
						</div>
                         <div class="form-group" id="cuntryF">
                    <div style="background:#a9a9a9;">
                    <center><b>Specific Country Shipping Fees</b></center>
                   <div class="d-flex justify-content-between bd-highlight mb-3 ">
    <div class="col-md-6 p-2 bd-highlight">
    <select name="cu_cuntry" id="cu_cuntry" class="form-control">
                    <option value="" selected>Select Country</option>
                    @foreach (Countries::orderBy('country_name')->get() as $country)
                      <option value="{{$country->id}}">{{ $country->country_name }}</option>
                      @endforeach
                  </select>
    </div>
    <div class="col-md-6 p-2 bd-highlight">
      <div class="text-right"><a class="btn btn-primary" id="cu_fess">
                       Add Fees
                </a></div>
                </div>
              </div></div>
                 
                
                  
                  
                  
                 @php
                 $spacial=json_decode($product->spacial_country_fees); 
                 @endphp
                 @if($spacial)
                  @foreach($spacial as $spacials_k => $spacials_v)
                  <uy class="form-group row"><div class="col-md-6 col-sm-6 col-6"><input class="cu form-control {{Helper::spacial($spacials_k)->country_name}}" value="{{Helper::spacial($spacials_k)->country_name}}" disabled=""></div><div class="col-md-5 col-sm-5 col-4"><input type="text" name="addmore[{{$loop->index}}][{{$spacials_k}}]" placeholder="Enter Fees" class="form-control" value="{{$spacials_v}}"></div> <div class="col-md-1 col-sm-1 col-1"><button aria-hidden="true" class="remove-tr">×</button></div></uy>
                  @endforeach
                  @endif
                  
                  
                    
                </div>
                
                
                
                
                
                
             <div class="form-group" id="cuntryFs">
                    <div style="background:#a9a9a9;">
                    <center><b>Disabled Shipping Country</b></center>
                   <div class="d-flex justify-content-between bd-highlight mb-3 ">
    <div class="p-2 bd-highlight">
    <select name="cu_cuntrys" id="cu_cuntrys" class="form-control">
                    <option value="" selected>Select Country</option>
                    @foreach (Countries::orderBy('country_name')->get() as $country)
                      <option value="{{$country->id}}">{{ $country->country_name }}</option>
                      @endforeach
                  </select>
                      </div>
    <div class="p-2 bd-highlight"><a class="btn btn-primary" id="cu_fesss">
                       Add Country
                </a></div>
  </div></div>

@php
                 $disable_cu=json_decode($product->disable_shiping); 
                 @endphp
                 <table id="cucounty" style="">
  <tr>
    <th style="width:80%">Country</th>
    <th>Remove</th>
  </tr>
  <tbody id="ff">
                 @if($disable_cu)
                  @foreach($disable_cu as $disable_cu_k => $disable_cu_v)
                  
                  <tr><td>{{Helper::spacial($disable_cu_v)->country_name}}</td><td><input type="hidden" class="cuc form-control {{Helper::spacial($disable_cu_v)->country_name}}" name="addmores[{{$disable_cu_k}}]" value="{{$disable_cu_v}}" placeholder="Enter Fees">
     
     <button aria-hidden="true" class="remove-tr">×</button></td></tr> 
                  
                  
                  
                  
                  
                  
                  
                   @endforeach 
        @endif
  </tbody>

</table>

  
  
                </div>   
                
                
                
                
                
                
                
                
						@endif

							<div class="form-group">
								<input type="text" class="form-control" name="tags" value="{{ $product->tags }}" placeholder="{{ __('general.tags') }}">
							</div>

							@if ($product->type == 'custom')
							<div class="form-group">
								<select name="delivery_time" class="form-control custom-select">
									<option disabled value="" selected>{{ __('general.delivery_time') }}</option>
									@for ($i=1; $i <= 30; ++$i)
										<option @if ($product->delivery_time == $i) selected @endif value="{{$i}}">{{$i}} {{ trans_choice('general.days', $i) }}</option>
									@endfor
								</select>
							</div>
						@endif

						@if ($product->type == 'physical')
						<div class="form-group">
							<select name="quantity" class="form-control custom-select">
								<option disabled value="" selected>{{ __('general.quantity') }}</option>
								@for ($i=0; $i <= 100; ++$i)
									<option @if ($product->quantity == $i) selected @endif value="{{$i}}">{{$i}}</option>
								@endfor
							</select>
						</div>

					<div class="form-group">
						<input type="text" class="form-control" value="{{ $product->box_contents }}" name="box_contents" placeholder="{{ __('general.box_contents') }}">
					</div>
					@endif

					<div class="form-group">
						<select name="category" class="form-control custom-select">
							<option disabled value="" selected>{{ __('general.category') }}</option>
							@foreach (App\Models\ShopCategories::orderBy('name')->get() as $category)
								<option @if ($product->category == $category->id) selected @endif value="{{ $category->id }}">
									{{ Lang::has('shop-categories.' . $category->slug) ? __('shop-categories.' . $category->slug) : $category->name }}
								</option>
							@endforeach
						</select>
					</div>

						<div class="form-group">
							<textarea class="form-control" name="description" placeholder="{{ __('general.description') }}" rows="5">{{ $product->description }}</textarea>
						</div>

						<div class="form-group">
							<div class="custom-control custom-switch custom-switch-lg">
								<input type="checkbox" class="custom-control-input" name="status" value="1" @if ($product->status) checked @endif id="customSwitch2">
								<label class="custom-control-label switch" for="customSwitch2">{{ __('general.status') }}</label>
							</div>
						</div>

							<div class="alert alert-danger display-none mb-0" id="errorShopProduct">
									<ul class="list-unstyled m-0" id="showErrorsShopProduct"></ul>
								</div>

							<div class="text-center">
								<a href="#" class="btn e-none mt-4" data-dismiss="modal">{{trans('admin.cancel')}}</a>

								<button type="submit" id="shopProductBtn" class="btn btn-primary mt-4">
									<i></i> {{trans('admin.save')}}
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- End Modal BuyNow -->


