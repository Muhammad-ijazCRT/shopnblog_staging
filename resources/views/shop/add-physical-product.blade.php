@extends('layouts.app')

@section('title') {{ __('general.add_physical_product') }} -@endsection

@section('content')
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
  background:#a9a9a9;
  height:20px;
  overflow:auto;
}

 th {
  text-align: left;
  padding: 8px;
  background:#5b5b5b;
  color:white;
}

td{
  text-align: left;
  padding: 8px;
}
</style>
<section class="section section-sm">
    <div class="container">
      <div class="row justify-content-center text-center mb-sm">
        <div class="col-lg-12 py-5">
          <h2 class="mb-0 font-montserrat">
            {{ __('general.add_physical_product') }}
          </h2>
          <p class="lead text-muted mt-0">
            {{ __('general.physical_products_desc') }}
        </p>
        </div>
      </div>
      <div class="row justify-content-center">

        <div class="col-lg-7">
            <form action="{{ url()->current() }}" method="post" enctype="multipart/form-data" id="shopProductForm">
              @csrf

              <div class="form-group preview-shop">
                <label for="preview">{{ __('general.preview') }} <small>(JPG, PNG)</small></label>
                <input type="file" name="preview" id="preview" accept="image/*">
              </div>

              <div class="form-group">
                <input type="text" class="form-control" name="name" placeholder="{{ __('admin.name') }}">
              </div>

                <div class="form-group">
                  <input type="text" class="form-control isNumber" name="price" autocomplete="off" placeholder="{{ __('general.price') }}">
                </div>

                <div class="form-group">
                  <input type="text" class="form-control isNumber" name="shipping_fee" autocomplete="off" placeholder="{{ __('general.shipping_feess') }}">
                </div>

                <div class="form-group">
                  <select name="country_free_shipping" class="form-control custom-select" id="cu_free">
                    <option value="" selected>{{ __('general.country_free_shipping') }}</option>
                    @foreach (Countries::orderBy('country_name')->get() as $country)
                      <option value="{{$country->id}}">{{ $country->country_name }}</option>
                      @endforeach
                  </select>
                </div>
                
                
                
                <div class="form-group" id="cuntryF">
                    <div style="background:#a9a9a9;">
                    <center><b>Specific Country Shipping Fees</b></center>
                   <div class="d-flex justify-content-between bd-highlight mb-3 ">
    <div class="p-2 bd-highlight">
    <select name="cu_cuntry" id="cu_cuntry" class="form-control">
                    <option value="" selected>Select Country</option>
                    @foreach (Countries::orderBy('country_name')->get() as $country)
                      <option value="{{$country->id}}">{{ $country->country_name }}</option>
                      @endforeach
                  </select>
    </div>
    <div class="p-2 bd-highlight"><a class="btn btn-primary" id="cu_fess">
                       Add Fees
                </a></div>
  </div></div>
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

<table id="cucounty" style="display:none">
  <tr>
    <th style="width:80%">Country</th>
    <th>Remove</th>
  </tr>
  <tbody id="ff">
      
      
  </tbody>

</table>
  
  
  
                </div>
                
                
                
                
                

                <div class="form-group">
                  <input type="text" class="form-control" name="tags" placeholder="{{ __('general.tags') }} ({{ __('general.separate_with_comma') }})">
                </div>

                <div class="form-group">
                  <select name="quantity" class="form-control custom-select">
                    <option disabled value="" selected>{{ __('general.quantity') }}</option>
                    @for ($i=1; $i <= 100; ++$i)
                      <option value="{{$i}}">{{$i}}</option>
                    @endfor
                  </select>
                </div>

                <div class="form-group">
                  <input type="text" class="form-control" name="box_contents" placeholder="{{ __('general.box_contents') }}">
                </div>

                <div class="form-group">
                  <select name="category" class="form-control custom-select">
                    <option disabled value="" selected>{{ __('general.category') }}</option>
                    @foreach (App\Models\ShopCategories::orderBy('name')->get() as $category)
                      <option value="{{ $category->id }}">
                        {{ Lang::has('shop-categories.' . $category->slug) ? __('shop-categories.' . $category->slug) : $category->name }}
                      </option>
                    @endforeach
                  </select>
                </div>

              <div class="form-group">
                <textarea class="form-control textareaAutoSize" name="description" placeholder="{{ __('general.description') }}" rows="3"></textarea>
              </div>

              <!-- Alert -->
            <div class="alert alert-danger my-3 display-none" id="errorShopProduct">
               <ul class="list-unstyled m-0" id="showErrorsShopProduct"><li></li></ul>
             </div><!-- Alert -->

              <button class="btn btn-1 btn-primary btn-block" id="shopProductBtn" type="submit"><i></i> {{ __('users.create') }}</button>
            </form>
        </div><!-- end col-md-12 -->
      </div>
    </div>
  </section>
@endsection

@section('javascript')

<script type="text/javascript">

$("#cu_free").on('change',function(){
     var country=$("#cu_free").val();
   var countryts=$("#cu_free option:selected").text();
 if(country !='' && $("input").hasClass(countryts)===false){
        }else{
            var type =$('.'+countryts+'').data('type');
            if(type==1){
                alert('country already listed on free shipping');
            }else if(type==2){
                
                alert('country already listed on specific shipping');
            }else{
                alert('country already listed on disabled shipping');
            }
            $("#cu_free option:selected").prop("selected", false);
        }   
    
});
    var i = 0;
    $("#cu_fess").click(function(){
   var country=$("#cu_cuntry").val();
   var countryts=$("#cu_cuntry option:selected").text();
   var free_shiping=$("#cu_free option:selected").text();
        ++i;
        if(country !='' && $("input").hasClass(countryts)===false && free_shiping!=countryts){
        $("#cuntryF").append('<uy class="form-group row"><div class="col-md-6 col-sm-6 col-6"><input class="cu form-control '+countryts+'" data-type="2" value="'+countryts+'" disabled></div><div class="col-md-5 col-sm-5 col-4"><input type="text" name="addmore['+i+']['+country+']" placeholder="Enter Fees" class="form-control" /></div> <div class="col-md-1 col-sm-1 col-1"><button aria-hidden="true" class="remove-tr">&times;</button></div></uy>');
    
        $("#cu_cuntry option:selected").prop("selected", false);
        }else{
            if(free_shiping==countryts){var type =1;}else{var type =$('.'+countryts+'').data('type');}
            if(type==1){
                alert('country already listed on free shipping');
            }else if(type==2){
                
                alert('country already listed on specific shipping');
            }else{
                alert('country already listed on disabled shipping');
            }
            
        }
    });
   
    $("#cuntryF").on('click', '.remove-tr', function(){  
         $(this).parents('uy').remove();
    });  
   
</script>   
<script type="text/javascript">

    var is = 1;
    $("#cu_fesss").click(function(){
   var country=$("#cu_cuntrys").val();
   if(is){
       $("#cucounty").show();
   }
   var countryts=$("#cu_cuntrys option:selected").text();
   var free_shiping=$("#cu_free option:selected").text();
        ++is;
        if(country !='' && $("input").hasClass(countryts)===false && free_shiping!=countryts){
        $("#ff").append('<tr><td>'+countryts+'</td><td><input type="hidden" data-type="3" class="cuc form-control '+countryts+'" name="addmores['+is+']" value='+country+' placeholder="Enter Fees" class="form-control" /><button aria-hidden="true" class="remove-tr">&times;</button></td></tr>');
    
        $("#cu_cuntrys option:selected").prop("selected", false);
        }
        else{
            if(free_shiping==countryts){var type =1;}else{var type =$('.'+countryts+'').data('type');}
            if(type==1){
                alert('country already listed on free shipping');
            }else if(type==2){
                
                alert('country already listed on specific shipping');
            }else{
                alert('country already listed on disabled shipping');
            }
            
        }
    });
   
    $("#ff").on('click', '.remove-tr', function(){  
         $(this).parents('tr').remove();
         if($("input").hasClass("cuc")===false){
           $("#cucounty").hide();  
         }
    });  
   
</script> 





  <script src="{{ asset('public/js/fileuploader/fileuploader-shop-preview.js') }}"></script>
  <script src="{{ asset('public/js/shop.js') }}"></script>
@endsection
