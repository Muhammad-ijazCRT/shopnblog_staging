@extends('layouts.app')

@section('title') {{trans('users.welcome_message')}} -@endsection

@section('content')
<section class="section section-sm">
    <div class="container">
      <div class="row justify-content-center text-center mb-sm">
        <div class="col-lg-8 py-5">
          <h2 class="mb-0 font-montserrat"><i class="feather icon-user-check mr-2"></i> {{trans('users.welcome_message')}}</h2>
          <p class="lead text-muted mt-0">{{trans('users.welcome_message_subtitle')}}</p>
        </div>
      </div>
      <div class="row">

        @include('includes.cards-settings')

        <div class="col-md-6 col-lg-9 mb-5 mb-lg-0">
          <div class="my-5">
            <div class="w-100 display-none" id="previewFile">
              <div class="previewFile d-inline"></div>
              <a href="javascript:;" class="text-danger" id="removeFile"><i class="fa fa-times-circle"></i></a>
            </div>

            <div class="progress-upload-cover" style="width: 0%; top:0;"></div>

            <div class="blocked display-none"></div>

            <!-- Alert -->
            <div class="alert alert-danger my-3" id="errorMsg" style="display: none;">
             <ul class="list-unstyled m-0" id="showErrorMsg"></ul>
           </div><!-- Alert -->

            <form action="{{url('message/send')}}" method="post" accept-charset="UTF-8" id="formSendMsg" enctype="multipart/form-data">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="file" name="zip" id="zipFile" accept="application/x-zip-compressed" class="visibility-hidden">
              <input type="hidden" id="id" value="{{ $welcomeMessage ? $welcomeMessage->id : '' }}" />
                <div class="w-100 mr-2 position-relative">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Welcome Message</label>
                        <textarea class="form-control" id="welcomeMessage" name="welcomeMessage" rows="10" maxlength="2000">{{ $welcomeMessage ? $welcomeMessage->message : '' }}</textarea>
                    </div>
                    <div class="w-100">
                        <span id="previewImage"></span>
                        <a href="javascript:void(0)" id="removePhoto" class="text-danger p-1 px-2 display-none btn-tooltip" data-toggle="tooltip" data-placement="top" title="{{trans('general.delete')}}"><i class="fa fa-times-circle"></i></a>
                    </div>
                    <input type="file" name="media[]" id="file" accept="image/*,video/mp4,video/x-m4v,video/quicktime,audio/mp3" multiple class="visibility-hidden filepond">
                    
                    
                    <div class="input-group my-2">
                        <div class="input-group-prepend">
                            <span class="input-group-text">$</span>
                        </div>
                        <input value="{{ $welcomeMessage ? $welcomeMessage->price : '' }}" class="form-control isNumber active price" autocomplete="off" name="price" placeholder="Price" type="text">
                    </div>
                    <div class="justify-content-between align-items-center">
                        <button type="button" class="btnMultipleUpload d-flex btn btn-upload btn-tooltip e-none align-bottom @if (auth()->user()->dark_mode == 'off') text-primary @else text-white @endif rounded-pill" data-toggle="tooltip" data-placement="bottom" title="{{trans('general.upload_media')}} ({{ trans('general.media_type_upload') }})">
                            <span>Upload Image / Videos</span>
                            <i class="feather icon-image f-size-25 ml-2"></i>
                        </button>
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button type="button" id="saveWelcomeMessageBtn" class="btn btn-default text-white font-weight-bold" style="background:#03e592">Save</button>
                </div>
            </form>
          </div>

          
      </div>
    </div>
  </section>
@endsection


@section('javascript')
<!-- <script src="{{ asset('public/js/messages.js') }}?v={{$settings->version}}"></script> -->
<script src="{{ asset('public/js/fileuploader/fileuploader-welcome-msg.js') }}?v={{$settings->version}}"></script>
<!-- <script src="{{ asset('public/js/paginator-messages.js') }}"></script> -->
<script>
    $(document).ready(function() {
        $(".btnMultipleUpload").click()
        $.ajax({
            url: URL_BASE+"/my/subscriptions/welcomeMessage/media-files/"+$("#id").val(),
            type: "GET",
            success: function(res) {
                console.log(res);
                // $(".btnMultipleUpload").click();
                for (let i = 0; i < res.length; i++) {
                    const data = res[i];
                    $(".fileuploader-items-list").prepend(`
                        <div class="col-3 h-100"> 
                                    <div class="fileuploader-item w-100" style="height:150px"> 
                                        <div class="fileuploader-item-inner"> 
                                            <div class="type-holder">${data.ext}</div> 
                                            <div class="actions-holder"> 
                                                <button type="button" class="fileuploader-action fileuploader-action-remove" title=""><i class="fileuploader-icon-remove"></i></button> 
                                            </div> 
                                            <div class="thumbnail-holder"> 
                                                <div class="fileuploader-item-image" style=""><img src="${URL_BASE}/public/uploads/messages/${data.file}" draggable="false"></div>
                                                <span class="fileuploader-action-popup"></span> 
                                            </div> 
                                            <div class="content-holder"><h5 title="${data.file}">${data.file}</h5><span>${data.size}</span></div> 
                                            <div class="progress-holder"></div> 
                                        </div> 
                                    </div>
    
                        </div>
                    `)
            }
            },
            error: function(err) {
                console.log(err)
            }
        })

        $('#saveWelcomeMessageBtn').on('click', function() {
            const welcomeMessage = $("#welcomeMessage").val();
            const fileCont = $(".fileuploader-items-list .fileuploader-item")

            if(welcomeMessage == "") {
                alert("Welcome Message is Required.")
                return false;
            }
  
            let media = [];
     
            fileCont.each(function(idx, elem) {
                const price = $(elem).parent('div').find('.input-group .price').val()
                const ext = $(elem).find(".type-holder").text()

                let type = ""
                if(ext == "png" || ext == "jpg" || ext == "PNG" || ext == "JPG" || ext == "jpeg" || ext == "JPEG") {
                    type = "image";
                }
                let videosExtArr = ["MPG","MP2","MPEG","MPE","MPV", "OGG", "MP4", "M4P", "M4V", "AVI", "WMV", "FLV", "SWF", "mpg","mp2","mpeg","mpe","mpv", "ogg", "mp4", "m4p", "m4v", "avi", "wmv", "flv", "swf"]; 
                if(videosExtArr.includes(ext)) {
                    type = "video";
                }

                media.push({
                    filename: $(elem).find(".content-holder h5").attr("title"),
                    // price: price != '' ? parseInt(price) : 0,
                    size: $(elem).find(".content-holder span").text(),
                    ext: ext,
                    type: type
                })
            })
            
            const body = {
                welcome_message: welcomeMessage,
                price: parseInt($("input[name='price']").val()) || 0,
                media: media,
                _token: $('meta[name="csrf-token"]').attr('content')
            }
            console.log(body)
            $.post(URL_BASE+'/my/subscriptions/welcomeMessage/update', body) 
            .done(function(res) {
                console.log( res );
                alert("Successfully Updated")
                window.location.reload();
            })
            .fail(function(err) {
                console.log( err );
            })
            .always(function() {
                console.log( "finished" );
            });

            console.log(body)
        })
    })
    $(document).on("click", ".fileuploader-action-remove", function() {
        let media = $(this).closest(".col-3");
        media.fadeOut("slow", function() {
            media.remove();
        })
    })
</script>
@endsection
