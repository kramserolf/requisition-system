@extends('layouts.admin')
<style>
    #requisitions {
        border-left: 2px solid white;
    }
    .sidebar-requisition {
        color: rgb(182, 182, 182);
        margin-left: 5px;
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Requisition</h4>

<table class="table table-sm table-bordered data-table nowrap" style="width: 100%;">
    <thead>
        <tr class="table-primary text-uppercase">
            <td class="text-center">No.</td>
            <td class="text-center">Deparment</td>
            <td class="text-center">Item</td>
            <td class="text-center">Requisition #</td>
            <td class="text-center">Status</td>
            <td class="text-center">Action</td>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>

{{-- add modal --}}
<div class="modal" id="viewRequisition" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <form name="requisitionForm" id="requisitionForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Requisition Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="d-flex justify-content-center mb-1">
                    <div class="col-sm-2">
                        <span>Mark as : </span>
                    </div>
                    <div class="col-sm-4 text-center">
                        <select class="form-select form-select-sm fw-bold" aria-label="Default select example" name="status" id="status">
                            <option value="approved">Approve</option>
                            <option value="rejected">Reject</option>
                          </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="item_name">Name</label>:
                    <span id="name" class="fw-bold"></span>
                    {{-- <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="e.g. Received 20 boxes"> --}}
                </div>
                <div class="mb-3">
                    <label for="item_name">Item</label>:
                    <span id="item_name" class="fw-bold"></span>
                </div>
                <div class="mb-3">
                    <label for="item_name">Quantity</label>:
                    <span id="quantity" class="fw-bold"></span>
                    {{-- <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="e.g. Received 20 boxes"> --}}
                </div>
                <div class="mb-3">
                    <label for="item_name">Recommending Status</label>:
                    <span id="recommending" class="fw-bold"></span>
                    {{-- <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="e.g. Received 20 boxes"> --}}
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" name="savedata" id="savedata" disabled>Update</button>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Close</button>
            </div> 
        </form>
    </div>
    </div>
</div>

<script>

$(document).ready(function(){
    // $('#barangay').trigger('click');

    //ajax setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    //load table
    let table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        select: true,
        ajax: "{{ route('president.requisition') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'department', name: 'department'},
            {data: 'item_name', name: 'item_name'},
             {data: 'status_no', name: 'status_no'},
             {data: 'recommending_status', name: 'recommending_status', class: 'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
        ],
    });

    $('body').on('click', '.viewRequisition', function(){
        var id = $(this).data('id'); 
        $.ajax({
            type: "GET",
            url: "{{ url('president/requisition/status') }}",
            data:{
            id:id
            },
            success: function (data) {
                console.log(data);
         
                    $('#item_name').html(data.item_name);
                    $('#quantity').html(data.quantity + ' ' +  data.quantity_type );
                    $('#name').html(data.name);
                    $('#id').val(data.id);
                    $('#status').val(data.approval_status);
                    $('#recommending').html(data.recommending_status);
                    $('#viewRequisition').modal('show');
            },
            error: function (data) {
            toastr.error(data['responseJSON']['message'],'Error has occured');
            }
        });
    });

    // update status
    $('#savedata').click(function(e){
        e.preventDefault();
        var status = $('#status').val();
        var id = $("#id").val();
            $.ajax({
            type: "POST",
            url: "{{ url('president/requisition/update') }}",
            data:{
            id:id, status:status
            },
            success: function (data) {
                table.draw();
                toastr.success('Requisition updated successfully','Success');
                $('#viewRequisition').modal('hide');
            },
            error: function (data) {
            toastr.error(data['responseJSON']['message'],'Error has occured');
            }
        });
    })

    $('#status').on('change', function(){
        $('#savedata').attr('disabled', false);
    });

}); //end of script

</script>
@endsection