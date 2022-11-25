@extends('layouts.admin')
<style>
    #accounts {
        border-left: 2px solid white;
    }
    .sidebar-accounts {
        color: rgb(182, 182, 182);
        margin-left: 5px;
    }
</style>
@section('content')
<h4 class="text-center px-2 fw-bold text-secondary"> Accounts</h4>

<table class="table table-bordered table-sm data-table nowrap" style="width: 100%;">
    <thead>
        <tr class="table-primary text-uppercase">
            <td class="text-center">No.</td>
            <td class="text-center">Account Type</td>
            <td class="text-center">Name</td>
            <td class="text-center">Username</td>
            <td class="text-center">Position</td>
            <td class="text-center">Action</td>
        </tr>
    </thead>
    <tbody></tbody>
</table>

{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <form name="accountForm" id="accountForm" enctype="multipart/form-data">

        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">New Account</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
             <input type="hidden" name="id" id="id">
              <div class="mb-3">
                <label for="account" class="form-label fw-bold">Account Type:</label>
                <input type="text" class="form-control form-control-sm" name="role_type" id="role_type" placeholder="e.g. Admin, Staff">
              </div>
              <div class="mb-3">
                <label for="description" class="form-label fw-bold">Name:</label>
                <input type="text" class="form-control form-control-sm" name="name" id="name">
             </div>
             <div class="mb-3">
                <label for="description" class="form-label fw-bold">Username:</label>
                <input type="text" class="form-control form-control-sm" name="username" id="username">
             </div>
             <div class="mb-3">
                <label for="quantity" class="form-label fw-bold">Email:</label>
                <input type="email" class="form-control form-control-sm text" name="email" id="quantity" placeholder="e.g. 20">
             </div>
             <div class="mb-3">
                <label for="quantity_type" class="form-label fw-bold">Position:</label>
                <input type="text" class="form-control form-control-sm" name="position" id="quantity_type" placeholder="e.g. Basic Ed Secretary">
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
        ajax: "{{ route('admin.accounts') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'role_type', name: 'role_type'},
            {data: 'name', name: 'name'},
            {data: 'username', name: 'username'},
            {data: 'position', name: 'position'},
            {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
        ],
        dom: 'Bfrtip',
        buttons: [
            {
                text: '<i class="bi-plus-circle"></i> Add Account',
                className: 'btn btn-secondary btn-sm',
                action: function(e, dt, node, config){
                    // show modal
                    $('#id').val('');
                    $('#accountForm').trigger("reset");
                    $('#addModal').modal('show');
                    $('#savedata').html('Save');
                },
            }
        ]

    });

  //add function
  $('#savedata').click(function (e) {
    e.preventDefault();
    $.ajax({
        data: $('#accountForm').serialize(),
        url : "{{ route('admin.store-account') }}",
        type: "POST",
        dataType: "json",
            success: function (data) {
                $('#accountForm').trigger("reset");
                table.draw();
                toastr.success('Account added successfully','Success');
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