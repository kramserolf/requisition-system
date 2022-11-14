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
                    <div class="mb-3">
                        <label for="item_name" class="form-label fw-bold">Item Name:</label>
                        <select class="form-select" aria-label="Default select example" name="inventory_id">
                            <option selected>Select item</option>
                            @foreach ($inventory as $item )
                                <option value="{{ $item->id }}">{{ $item->item_name }} - {{ $item->quantity }} {{ $item->quantity_type }} remaining</option>
                            @endforeach
                          </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label fw-bold">Quantity:</label>
                        <input type="text" class="form-control form-control-sm text-center" name="quantity" id="quantity" placeholder="e.g. 20">
                    </div>
                    <div class="mb-3">
                        <label for="item_name" class="form-label fw-bold">Unit:</label>
                        <select class="form-select" aria-label="Default select example" name="quantity_type">
                            <option selected>Select type</option>
                            @foreach ($inventory as $item )
                                <option value="{{ $item->quantity_type }}">{{ $item->quantity_type }}</option>
                            @endforeach
                          </select>
                    </div>
                    <div class="mb-3">
                        <label for="item_name" class="form-label fw-bold">Department</label>
                        <select class="form-select" aria-label="Default select example" name="department">
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
                    <div class="mb-3">
                        <label for="care_of" class="form-label fw-bold">Care of:</label>
                        <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="e.g. Joreim Badajos">
                    </div>
                    <div class="text-center">
                        <button type="button" class="btn btn-success btn-sm" name="savedata" id="savedata">Request</button>
                    </div>
                </form>
            </div>
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
        url : "{{ route('admin.store-requisition') }}",
        type: "POST",
        dataType: "json",
            success: function (data) {
                $('#requestForm').trigger("reset");
                toastr.success('Requsition added successfully.','Success');
            },
            error: function (data) {
                toastr.error(data['responseJSON']['message'],'Error has occured');

            }
        });
    });
</script>
@endsection