@extends('layouts.admin')
<style>
    #return_items {
        border-left: 2px solid white;
    }
    .sidebar-return-item {
        color: rgb(182, 182, 182);
        margin-left: 5px;
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Return Items</h4>

<table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
    <thead>
        <tr class="table-primary text-uppercase">
            <td class="text-center">No.</td>
            <td class="text-center">Item Name</td>
            <td class="text-center">Issue</td>
            <td class="text-center">Name</td>
            <td class="text-center">Deparment</td>
            <td class="text-center">Date Returned</td>
            <td class="text-center">Remarks</td>
        </tr>
    </thead>
    <tbody></tbody>
</table>

{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <form name="returnItemForm" id="returnItemForm" enctype="multipart/form-data">

        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Return Item</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
             <input type="hidden" name="id" id="id">
             <div class="form-group col-sm-12">
                <label for="item_name" class="form-label fw-bold">Requisition #:</label>
                <select class="form-select form-select-sm select-statusno" aria-label="Default select example" name="requisition" id="statusno">
                    <option value=""></option>
                    @foreach ($requisitions as $requisition )
                        <option value="{{ $requisition->req_id }}">{{ $requisition->status_no }} - {{ $requisition->item_name }} ({{ $requisition->quantity }} {{ $requisition->quantity_type }} )</option>
                    @endforeach
                </select>
            </div>
              <div class="mb-3">
                <label for="description" class="form-label fw-bold">Issue:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="issue"></textarea>
             </div>
             <div class="mb-3">
                <label for="quantity" class="form-label fw-bold">Date  Return:</label>
                <input type="date" class="form-control form-control-sm text" name="date_returned" id="date_returned">
             </div>
             <div class="mb-3">
                <label for="quantity_type" class="form-label fw-bold">Remakrs <span class="text-muted" style="font-size: 13px">(optional)</span></label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="remarks"></textarea>
             </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-outline-primary" name="savedata" id="savedata" >Save</button>
              <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
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
        ajax: "{{ route('return.items') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'item_name', name: 'item_name'},
            {data: 'issue', name: 'issue'},
            {data: 'name', name: 'name'},
            {data: 'department', name: 'department'},
            {data: 'date_returned', name: 'date_returned'},
            {data: 'remarks', name: 'remarks'},
        ],
        dom: 'fBrtip',
        buttons: [
            @if (auth()->user()->is_role == 0)
            {
                text: '<i class="bi-plus-circle"></i> Add Item',
                className: 'btn btn-success btn-sm',
                action: function(e, dt, node, config){
                    // show modal
                    $('#id').val('');
                    $('#returnItemForm').trigger("reset");
                    $('#addModal').modal('show');
                    $('#savedata').html('Save');
                },
            },
            'spacer',
            @endif
            {
                extend: 'print',

                repeatingHead: {
                    logo: '{{ asset('images/sjcbi.png') }}',
                    logoPosition: 'center',
                    logoStyle: 'width: 90',
                    title: '<h3 class="text-center m-4">Requisition System w/ Inventory - Reports</h3>'
                },
                title: '',
            },
            'spacer',
            'pdf'

        ]

    });

    $('#showModal').click(function(){
        $('#id').val('');
        $('#returnItemForm').trigger("reset");
        $('#addModal').modal('show');
        $('#savedata').html('Save');
    });

    // select inventory 
        $('.select-statusno').select2({
        dropdownParent: $('#addModal'),
        theme: "bootstrap-5",
        placeholder: "Select requisition",
        allowClear: true,
        tags: true
    });

  //add function
  $('#savedata').click(function (e) {
    e.preventDefault();
    $.ajax({
        data: $('#returnItemForm').serialize(),
        url : "{{ route('return.store-items') }}",
        type: "POST",
        dataType: "json",
            success: function (data) {
                $('#returnItemForm').trigger("reset");
                table.draw();
                toastr.success('Return Item added successfully','Success');
            },
            error: function (data) {
                toastr.error(data['responseJSON']['message'],'Error has occured');

            }
        });
    });

    // DELETE 
    $('body').on('click', '.deleteAccount', function () {
    var id = $(this).data("id");
        if (confirm("Are You sure want to delete this account?") === true) {
            $.ajax({
                type: "DELETE",
                url: "{{ url('admin/account/destroy') }}",
                data:{
                id:id
                },
                success: function (data) {
                table.draw();
                toastr.success('Item deleted successfully','Success');
                },
                error: function (data) {
                toastr.error(data['responseJSON']['message'],'Error has occured');
                }
            });
        }
    });

}); //end of script

</script>
@endsection