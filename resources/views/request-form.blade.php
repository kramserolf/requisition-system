@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-header text-center">
                <img src="{{ asset('images/sjcbi.png') }}" alt="sjcbi_logo" width="60" height="60">
                <h5 class="mt-2">Requisition Form</h5>
            </div>
            <div class="card-body">
                <form name="requestForm" id="requestForm" enctype="multipart/form-data">
                    <div id="add-block">
                        <div class="row form-row mb-2">
                            <div class="form-group col-sm-8">
                                <label for="item_name" class="form-label fw-bold">Item Name:</label>
                                <select class="form-select form-select-sm select-inventory" multiple="multiple" aria-label="Default select example" name="inventory_id" id="select_inventory">
                                    <option value=""></option>
                                    @foreach ($inventory as $item )
                                        <option value="{{ $item->id }}">{{ $item->item_name }} - {{ $item->quantity }} {{ $item->quantity_type }} <span style="font-size: 11px">(available)</span></option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-4">
                                <label for="quantity" class="form-label fw-bold">Quantity:</label>
                                <input type="text" class="form-control form-control-sm text-end" name="quantity" id="quantity" placeholder="e.g. 20">
                            </div>
                            <input type="text" id="hidden_item" name="hidden_item" hidden>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="care_of" class="form-label fw-bold">Name:</label>
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="e.g. Joreim Badajos">
                    </div>
                    <div class="mb-3">
                        <label for="item_name" class="form-label fw-bold">Department</label>
                        <select class="form-select form-select-sm" aria-label="Default select example" name="department" id="department">
                            <option selected>Select department</option>
                            <option value="Elementary">Elementary</option>
                            <option value="JHS">Junior High School</option>
                            <option value="SHS">Senior High School</option>
                            <option value="CASTE">CASTE</option>
                            <option value="CICS">CICS</option>
                            <option value="CBM">CBM</option>
                            <option value="CCJE">CCJE</option>
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                            <option value="Others">Others</option>
                          </select>
                    </div>
                    <div class="mt-2 text-center" id="status" hidden>
                        <label for="" class="mr-2 p-2" disabled>Requsition status no:</label>
                        <span id="tracking" class="text-decoration-underline fw-bold pt-2 fs-5"></span><br>
                        <span style="font-size: 11px"><strong>Note</strong> Please copy RSN for status inquiry.</span>
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-sm" name="savedata" id="savedata">Request</button>
                        <span style="font-size: 13px">Click <a href="{{ route('tracking') }}">here</a> for status inquiry. </span>
                    </div>
                </form>
            </div>
            <div class="overlay"></div>
        </div>
    </div>
</div>

<script>
    //ajax setup
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });


      //add function
  $('#savedata').click(function (e) {
    e.preventDefault();
    $.ajax({
        data: $('#requestForm').serialize(),
        url : "{{ route('store-requisition') }}",
        type: "POST",
        dataType: "json",
            success: function (data) {
                $('#requestForm').trigger("reset");
                toastr.success('Requsition submitted successfully.','Success');
                $('#status').attr('hidden', false);
                $('#tracking').html(data.tracking);
                $('#savedata').attr('disabled', true);
                $('#select_inventory').val(null).trigger('change');
                $('#select_inventory').attr('disabled', true);
                $('#quantity').attr('disabled', true);
                $('#name').attr('disabled', true);
                $('#department').attr('disabled', true);
            },
            error: function (data) {
                toastr.error(data['responseJSON'][data.message],'Error has occured');
            }
        });
});

    $('#select_inventory').on('change', function(){
        var item = $(this).val();
        $('#hidden_item').val(item);
    });




    $(document).ready(function(){
        // select inventory 
        $('.select-inventory').select2({
            theme: "bootstrap-5",
            selectionCssClass: "select2--small", // For Select2 v4.1
            placeholder: "Select item",
            allowClear: true,
            tags: true
        });
        $('#quantity').keypress(function(e){
            if(e.keyCode == 13){
                $(this).val($(this).val() + ',')
            }
        });
    });


    // $('#select_inventory').on('change', function(){ 
    //     alert($(this).val());
    // });

    // get loading when request submitted
    $(document).on({
        ajaxStart: function(){
            $('body').addClass('loading');
        },
        ajaxStop: function(){
            $('body').removeClass('loading');
        }
    });
</script>
@endsection