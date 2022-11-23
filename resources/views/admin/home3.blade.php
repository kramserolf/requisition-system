@extends('layouts.admin')
<style>
    #home {
        border-left: 2px solid white;
    }
    .sidebar-home {
        color: rgb(182, 182, 182);
    }
</style>
@section('content')

<h4 class="text-center px-2 fw-bold text-secondary"> Analytics</h4>

<div class="mt-4">
    <div class="row px-5 mt-2 mb-5">
        <div class="col-md-3 p-2 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body text-center">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-secondary fw-bold mb-2">Total Requisition</div>
                            <div class="h2 m-4 fw-bold">{{ $totalRequisition }}</div>
                        </div>
                    </div>
                    <div class="m-1">
                        <span class="text-success fw-bold">
                            <i class="bi-file-earmark-text" style="font-size: 22px; margin-right: 6px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-3 p-2 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body text-center">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-secondary fw-bold mb-2">Total Items Released</div>
                            <div class="h2 m-4 fw-bold">{{ $totalReleased }}</div>
                        </div>
                    </div>
                    <div class="m-1">
                        <span class="text-success fw-bold">
                            <i class="bi-box-arrow-up" style="font-size: 22px; margin-right: 6px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-3 p-2 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body text-center">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-secondary fw-bold mb-2">Total Approvals</div>
                            <div class="h2 m-4 fw-bold">{{ $totalApprovals }}</div>
                        </div>
                    </div>
                    <div class="m-1">
                        <span class="text-success fw-bold">
                            <i class="bi-file-earmark-check" style="font-size: 22px; margin-right: 6px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-md-3 p-2 mt-2">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body text-center">
                    <div class="row no-gutters">
                        <div class="col">
                            <div class="text-xs font-weight-bold text-secondary fw-bold mb-2">Total Rejected</div>
                            <div class="h2 m-4 fw-bold">{{ $totalRejected }}</div>
                        </div>
                    </div>
                    <div class="m-1">
                        <span class="text-success fw-bold">
                            <i class="bi-x-circle" style="font-size: 22px; margin-right: 6px"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
    
@endsection