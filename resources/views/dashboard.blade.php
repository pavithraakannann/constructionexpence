@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')


  <div class="app-container">
    <!-- start page title -->
    <div class="hstack flex-wrap gap-3 mb-5">
      <div class="flex-grow-1">
        <h4 class="mb-1 fw-semibold">E-Commerce</h4>
        <nav>
          <ol class="breadcrumb breadcrumb-arrow mb-0">
            <li class="breadcrumb-item">
              <a href="index.html">Dashboard</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">E-Commerce</li>
          </ol>
        </nav>
      </div>
    </div>
    <!-- end page title -->
    <div class="e-commerce-dashboard">
      <div class="row">
        <div class="col-lg-3">
          <div class="card card-h-100 overflow-hidden">
            <div class="card-body p-4">
              <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                <div class="flex-grow-1">
                  <div class="hstack gap-3 mb-3">
                    <div class="bg-warning-subtle text-warning avatar avatar-item rounded-2">
                      <!-- <i class="ri-money-dollar-circle-line fs-16 fw-medium"></i> -->
                      <i class="bi bi-house-heart-fill fs-16 fw-medium"></i>
                    </div>
                    <h6 class="mb-0 fs-13">Total Sales</h6>
                  </div>
                  <h4 class="fw-semibold fs-5 mb-0">
                    <span data-target="84573" data-duration="5" data-prefix="$">$84573</span>
                  </h4>
                </div>
                <div class="flex-shrink-0 text-end">
                  <div class="d-flex align-items-end justify-content-end gap-3">
                    <span class="text-success"><i class="ri-arrow-right-up-line fs-12"></i>10.18%</span>
                  </div>
                  <div class="text-muted fs-12">+1.01% this week</div>
                </div>
              </div>
            </div>
            <div id="totalSalesDashborad"></div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card card-h-100 overflow-hidden">
            <div class="card-body p-4">
              <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                <div class="flex-grow-1">
                  <div class="hstack gap-3 mb-3">
                    <div class="bg-danger-subtle text-danger avatar avatar-item rounded-2">
                      <i class="ri-money-dollar-circle-line fs-16 fw-medium"></i>
                    </div>
                    <h6 class="mb-0 fs-13">Total Orders</h6>
                  </div>
                  <h4 class="fw-semibold fs-5 mb-0">
                    <span data-target="202557" data-duration="5" data-prefix="$">$202557</span>
                  </h4>
                </div>
                <div class="flex-shrink-0 text-end">
                  <div class="d-flex align-items-end justify-content-end gap-3">
                    <span class="text-danger"><i class="ri-arrow-right-down-line fs-12"></i>1.01%</span>
                  </div>
                  <div class="text-muted fs-12">-0.31% this week</div>
                </div>
              </div>
            </div>
            <div id="totalOrdersDashborad"></div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card card-h-100 overflow-hidden">
            <div class="card-body p-4">
              <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                <div class="flex-grow-1">
                  <div class="hstack gap-3 mb-3">
                    <div class="bg-success-subtle text-success avatar avatar-item rounded-2">
                      <i class="ri-money-dollar-circle-line fs-16 fw-medium"></i>
                    </div>
                    <h6 class="mb-0 fs-13">Total Earnings</h6>
                  </div>
                  <h4 class="fw-semibold fs-5 mb-0">
                    <span data-target="202557" data-duration="5" data-prefix="$">$202557</span>
                  </h4>
                </div>
                <div class="flex-shrink-0 text-end">
                  <div class="d-flex align-items-end justify-content-end gap-3">
                    <span class="text-success"><i class="ri-arrow-right-up-line fs-12"></i>10.10</span>
                  </div>
                  <div class="text-muted fs-12">+1.99% this week</div>
                </div>
              </div>
            </div>
            <div id="totalEarningsDashborad"></div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="card card-h-100 overflow-hidden">
            <div class="card-body p-4">
              <div class="hstack flex-wrap justify-content-between gap-3 align-items-end">
                <div class="flex-grow-1">
                  <div class="hstack gap-3 mb-3">
                    <div class="bg-info-subtle text-info avatar avatar-item rounded-2">
                      <i class="ri-truck-line fs-16 fw-medium"></i>
                    </div>
                    <h6 class="mb-0 fs-13">Total Shipments</h6>
                  </div>
                  <h4 class="fw-semibold fs-5 mb-0">
                    <span data-target="17892" data-duration="5" data-prefix="$">$17,892</span>
                  </h4>
                </div>
                <div class="flex-shrink-0 text-end">
                  <div class="d-flex align-items-end justify-content-end gap-3">
                    <span class="text-success"><i class="ri-arrow-right-up-line fs-12"></i>5.50%</span>
                  </div>
                  <div class="text-muted fs-12">+2.15% this week</div>
                </div>
              </div>
            </div>
            <div id="totalShipmentsDashboard"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</main>

@endsection

@push('scripts')

@endpush