@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-4">
        <div class="card">
            <div class="card-header text-center">
                <img src="{{ asset('images/sjcbi.png') }}" alt="sjcbi_logo" width="60" height="60">
                <h5 class="mt-3">Requisition Status Tracking</h5>
            </div>
            <div class="card-body">
                <form name="trackingForm" id="trackingForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="care_of" class="form-label fw-bold">Requisition No:</label>
                        <input type="text" class="form-control form-control-sm" name="tracking" id="tracking" placeholder="e.g. SJCBI-0023145">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-sm" name="savedata" id="savedata">Submit</button>
                    </div>
                </form>
                <div class="mt-3 text-center" id="requisition_no" hidden>
                    <label for="item_name" class="form-label" style="font-size: 13px;">Requisition number </label>
                    <span id="received_status" class="badge bg-danger"><strong>not found.</strong> </span>
                </div>
                <div class="mt-3 text-center" id="div_name" hidden>
                    <label for="item_name" class="form-label" style="font-size: 13px;">Name </label>
                    <span id="name" class=""><strong></strong> </span>
                </div>

                <div class="mt-1 text-center" id="div_dept" hidden>
                    <label for="item_name" class="form-label" style="font-size: 13px;">Department </label>
                    <span id="department" class=""><strong></strong> </span>
                </div>
                <div class="mt-1 text-center" id="div_approval" hidden>
                    <label for="item_name" class="form-label" style="font-size: 13px;">Approval Status: </label>
                    <span id="approval" class="badge bg-warning"><strong></strong> </span>
                </div>
                <div class="mt-1 text-center" id="recommending_status">

                </div>
                <div class="mt-3 text-center" id="item_name">

                </div>
                
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
  $('#savedata').click(function () {
    $tracking = $('#tracking').val();
    $.ajax({
        type: "GET",
        url : "{{ url('tracking/status') }}",
        data: {tracking:$tracking},
            success: function (data) {
                if(data.status == false){
                    $('#requisition_no').attr('hidden', false);
                } else{
                  $.each(data.message, function(index, value){
                    console.log(index + ":" + value['item_name']);
                    $('#recommending_status').append('<label for="item_name" class="form-label" style="font-size: 13px;">Item Name: </label><span class=""><strong>'+ ' ' +value['item_name'] +' '+ 'qty ' +value['quantity'] +'</strong> </span><br>');
                  });
                  $('#name').append(data.message[0]['name']);
                  $('#department').append(data.message[0]['department']);
                  $('#approval').append(data.message[0]['approval_status']);
                  $('#div_name').attr('hidden', false);
                  $('#div_dept').attr('hidden', false);
                  $('#div_approval').attr('hidden', false);
                  $('#requisition_no').attr('hidden', true);
                  $('#savedata').attr('hidden', true);
                }
            },
            error: function (data) {
                toastr.error(data['responseJSON']['message'],'Error has occured');
            }
        });
});

</script>
@endsection