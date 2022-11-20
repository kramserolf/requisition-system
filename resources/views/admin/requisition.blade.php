@extends('layouts.admin')
<style>
    .sidebar-requisition {
        color: rgb(13, 84, 8);
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Inventory</h4>

<table class="table table-sm table-bordered data-table nowrap" style="width: 100%;">
    <thead>
        <tr class="table-primary text-uppercase">
            <td class="text-center">No.</td>
            <td class="text-center">Item Name</td>
            <td class="text-center">Quantity</td>
            <td class="text-center">Name</td>
            <td class="text-center">Deparment</td>
            <td class="text-center">Status</td>
            <td class="text-center">Action</td>
        </tr>
    </thead>
    <tbody>
        
    </tbody>
</table>


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
        ajax: "{{ route('admin.requisition') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'item_name', name: 'item_name'},
            {data: 'quantity', name: 'quantity'},
             {data: 'name', name: 'name'},
             {data: 'department', name: 'department'},
             {data: 'approval_status', name: 'approval_status', class: 'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                text: '<i class="bi-plus-circle"></i> Add item',
                className: 'btn btn-secondary btn-sm',
                action: function(e, dt, node, config){
                    // show modal
                    $('#id').val('');
                    $('#inventoryForm').trigger("reset");
                    $('#addModal').modal('show');
                    $('#savedata').html('Save');
                },
            }
        ],
        // columnDefs: [ 
        //   {
        //     'targets': 5,
        //     'render': function(data, type, row){
        //       return data +', '+row.recommending_status+', ' +row.approval_status;
        //     },
        //     'targets': 5
        //   }
        // ]

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

        // Approve 
    $('body').on('click', '.approveRequisition', function () {
    var id = $(this).data("id");
        if (confirm("Are you sure want to approve this requisition?") === true) {
            $.ajax({
                type: "POST",
                url: "{{ url('admin/requisition/update') }}",
                data:{
                id:id
                },
                success: function (data) {
                table.draw();
                toastr.success('Requisiton approved successfully','Success');
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