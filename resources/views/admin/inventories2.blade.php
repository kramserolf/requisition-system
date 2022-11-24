@extends('layouts.admin')
<style>
    #items {
        border-left: 2px solid white;
    }
    .sidebar-items {
        color: rgb(182, 182, 182);
        margin-left: 5px;
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Inventory</h4>

<table class="table table-bordered data-table nowrap" style="width: 100%;">
    <thead>
        <tr class="table-primary text-uppercase">
            <td class="text-center">No.</td>
            <td class="text-center">Category</td>
            <td class="text-center">Item Name</td>
            <td class="text-center">Quantity</td>
            <td class="text-center">Date acquired</td>
            <td class="text-center">Description</td>
        </tr>
    </thead>
    <tbody></tbody>
</table>

{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <form name="inventoryForm" id="inventoryForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="mb-3">
                    <label for="item_name" class="form-label fw-bold">Item Name:</label>
                    <input type="text" class="form-control form-control-sm" name="item_name" id="item_name" placeholder="e.g. Bondpaper, Ballpen">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description:</label>
                    <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="e.g. Received 20 boxes">
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label fw-bold">Quantity:</label>
                    <input type="text" class="form-control form-control-sm text" name="quantity" id="quantity" placeholder="e.g. 20">
                </div>
                <div class="mb-3">
                    <label for="quantity_type" class="form-label fw-bold">Unit:</label>
                    <input type="text" class="form-control form-control-sm" name="quantity_type" id="quantity_type" placeholder="e.g. pcs / box / rim">
                </div>
                <div class="mb-3">
                    <label for="date_acquired" class="form-label fw-bold">Date Received:</label>
                    <input type="date" class="form-control form-control-sm" name="date_acquired" id="date_acquired">
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
        ajax: "{{ route('vp.inventory') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'item_name', name: 'item_name'},
            {data: 'quantity', name: 'quantity'},
            {data: 'date_acquired', name: 'date_acquired'},
            {data: 'description', name: 'description'},
        ],
        columnDefs: [ 
          {
            'targets': 3,
            'render': function(data, type, row){
              return data +' - '+row.quantity_type;
            }
        }
      ]

    });
}); //end of script

</script>
@endsection