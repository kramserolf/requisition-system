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
<div class="d-flex justify-content-between">
    <div>
        <button type="button" class="btn btn-secondary btn-sm" id="showModal">
            <i class="bi-plus-circle"></i> Add Item
          </button>
    </div>
<div>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.inventory') }}"> Items</a></li>
          <li class="breadcrumb-item active" aria-current="page">Categories</li>

        </ol>
      </nav>
</div>
</div>
<table class="table table-bordered data-table nowrap" style="width: 100%;">
    <thead>
        <tr class="table-primary text-uppercase">
            <td class="text-center">No.</td>
            <td class="text-center">Title</td>
            <td class="text-center">Description</td>
            <td class="text-center">Action</td>
        </tr>
    </thead>
    <tbody></tbody>
</table>

{{-- add modal --}}
<div class="modal fade" id="addModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <form name="categoryForm" id="categoryForm" enctype="multipart/form-data">

            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">New Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id" id="id">
                <div class="mb-3">
                    <label for="item_name" class="form-label fw-bold">Title:</label>
                    <input type="text" class="form-control form-control-sm" name="title" id="title" placeholder="e.g. Bondpaper, Ballpen">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Description:</label>
                    <input type="text" class="form-control form-control-sm" name="description" id="description" placeholder="e.g. Received 20 boxes">
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
        ajax: "{{ route('admin.category') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false, class:'text-center'},
        ]

    });
    $('#showModal').on('click', function(){
        // show modal
        $('#id').val('');
        $('#categoryForm').trigger("reset");
        $('#addModal').modal('show');
        $('#savedata').html('Save');
    });

  //add function
  $('#savedata').click(function (e) {
    e.preventDefault();
    $.ajax({
        data: $('#categoryForm').serialize(),
        url : "{{ route('admin.store-category') }}",
        type: "POST",
        dataType: "json",
            success: function (data) {
                $('#categoryForm').trigger("reset");
                table.draw();
                toastr.success('Category added successfully','Success');
            },
            error: function (data) {
                toastr.error(data['responseJSON']['message'],'Error has occured');

            }
        });
    });

    // DELETE 
    $('body').on('click', '.deleteCategory', function () {
    var id = $(this).data("id");
        if (confirm("Are You sure want to delete this category?") === true) {
            $.ajax({
                type: "DELETE",
                url: "{{ url('admin/category/destroy') }}",
                data:{
                id:id
                },
                success: function (data) {
                table.draw();
                toastr.success('Category deleted successfully','Success');
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