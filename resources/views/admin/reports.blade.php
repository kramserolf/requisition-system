@extends('layouts.admin')
<style>
    #reports {
        border-left: 2px solid white;
    }
    .admin-report {
        color: rgb(182, 182, 182);
        margin-left: 5px;
    }
    @media print
    {
    html, body { height: auto; }
    .dt-print-table, .dt-print-table thead, .dt-print-table th, .dt-print-table tr {border: 0 none !important;}
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Reports</h4>

<table class="table table-bordered data-table dt-print-table nowrap" style="width: 100%;">
    <thead>
        <tr class="table-primary text-uppercase">
            <td class="text-center">No.</td>
            <td class="text-center">Department</td>
            <td class="text-center">Name</td>
            <td class="text-center">Item</td>
            <td class="text-center">Quantity</td>
            <td class="text-center">Approval Status</td>
            <td class="text-center">Date Released</td>
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
        ajax: "{{ route('reports') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'department', name: 'department'},
            {data: 'name', name: 'description'},
            {data: 'item_name', name: 'item_name', searchable: true},
            {data: 'quantity', name: 'quantity'},
            {data: 'approval_status', name: 'approval_status'},
            {data: 'released_date', name: 'released_date'},
        ],
        dom: 'frBtlip',
        autoWidth: true,
        buttons: [
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
        ],
        columnDefs: [ 
          {
            'targets': 4,
            'render': function(data, type, row){
              return data +' - '+row.quantity_type;
            }
        }
      ]

    });

  //add function
  $('#savedata').click(function (e) {
    e.preventDefault();
    $.ajax({
        data: $('#inventoryForm').serialize(),
        url : "{{ route('admin.store-inventory') }}",
        type: "POST",
        dataType: "json",
            success: function (data) {
                $('#inventoryForm').trigger("reset");
                table.draw();
                toastr.success('Item added successfully','Success');
            },
            error: function (data) {
                toastr.error(data['responseJSON']['message'],'Error has occured');

            }
        });
    });

    // DELETE 
    $('body').on('click', '.deleteInventory', function () {
    var id = $(this).data("id");
        if (confirm("Are You sure want to delete this item?") === true) {
            $.ajax({
                type: "DELETE",
                url: "{{ url('admin/inventory/destroy') }}",
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