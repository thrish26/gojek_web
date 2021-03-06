{{ App::setLocale(  isset($_COOKIE['admin_language']) ? $_COOKIE['admin_language'] : 'en'  ) }}
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card-header border-bottom">
            @if(empty($id))
                @php($action_text=__('admin.add'))
            @else
                @php($action_text=__('admin.edit'))
                    
            @endif
            <h6 class="m-0"style="margin:10!important;">{{$action_text}} {{ __('Ticket Categories') }}</h6>
        </div>
        <div class="popup-card-content">
        <div class="popup-card-content-in">
            <form class="validateForm">
                @csrf()
                @if(!empty($id))
                    <input type="hidden" name="_method" value="PATCH">
                    <input type="hidden" name="id" value="{{$id}}">
                @endif
                @if(count(Helper::getServiceList())> 1)
                    <div class="form-row">
                        <div class="form-group col-md-6">
                        <label for="notify_type" class="col-xs-2 col-form-label">@lang('admin.service')    </label>
                            <select name="admin_service" class="form-control">
                                <option value="">Select</option>
                                    @foreach(Helper::getServiceList() as $service)
                                        <option value={{$service}}>{{$service}}</option>
                                    @endforeach
                            </select>
                        </div>
                        
                    </div>
                @endif
               
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">{{ __('admin.ticket_categories.name') }}</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Category" value="" autocomplete="off">
                    </div>
                    <div class="form-group col-md-6">
					<label for="notify_status" >@lang('admin.ticket_categories.status')</label>
						<select name="status" class="form-control">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
					</div>
                </div>
               
                <button type="submit" class="btn btn-accent">{{$action_text}} {{ __('Ticket Category') }}</button>
                <button type="reset" class="btn btn-danger cancel">{{ __('Cancel') }}</button>

            </form>
        </div>
        </div>
    </div>
</div>


@include('common.admin.includes.redirect')
<script>
$(document).ready(function()
{

     basicFunctions();

     var id = "";

     if($("input[name=id]").length){
        id = "/"+ $("input[name=id]").val();
        var url = getBaseUrl() + "/admin/ticketCategory"+id;
        setData( url );
     }

     $('.validateForm').validate({
		errorElement: 'span', //default input error message container
		errorClass: 'help-block', // default input error message class
		focusInvalid: false, // do not focus the last invalid input
		rules: {
            type: { required: true },
            reason: { required: true },
            status: { required: true },
            service: { required: true },
		},

		messages: {
			type: { required: "Type is required." },
			reason: { required: "Reason is required." },
            status: { required: "Status is required." },
            service: { required: "Service is required." },

		},
		highlight: function(element)
		{
			$(element).closest('.form-group').addClass('has-error');
		},
		success: function(label) {
			label.closest('.form-group').removeClass('has-error');
			label.remove();
		},

		submitHandler: function(form) {

            var formGroup = $(".validateForm").serialize().split("&");
            var data = new FormData();
            for(var i in formGroup) {
                var params = formGroup[i].split("=");
                data.append( params[0], decodeURIComponent(params[1]) );
            }
            var url = getBaseUrl() + "/admin/ticketCategory"+id;
            saveRow( url, table, data);

		}
    });

    $('.cancel').on('click', function(){
        $(".crud-modal").modal("hide");
    });

});
</script>
