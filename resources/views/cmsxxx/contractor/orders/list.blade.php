@extends('cms.contractor.layout.template')
@section('main')
<div class="container-fluid">

    <div class="d-flex justify-content-between mb-2 mt-2">
        <div class="d-flex justify-content-between m-2">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="#"><?= get_label('home', 'Home') ?></a>
                        </li>
                        <li class="breadcrumb-item active">
                            All Orders ({{ $orders->count() }})
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <div id="cover-spin" style="display:none;" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <div>
            <x-formy.button_insert_js table="order_table" selectionId="offcanvas-add-order" dataId="0"
                title="Add new Order" class="btn btn-primary px-5"
                icon="fa-solid fa-plus me-2">
            </x-formy.button_insert_js>
            <a class="btn btn-phoenix-primary px-3 me-1" href="{{ route('cms.contractor.orders', ['vw' => 'list']) }}"
                data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Orders view"><svg
                    class="svg-inline--fa fa-list fs-10" aria-hidden="true" focusable="false" data-prefix="fas"
                    data-icon="list" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                    data-fa-i2svg="">
                    <path fill="currentColor"
                        d="M40 48C26.7 48 16 58.7 16 72v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V72c0-13.3-10.7-24-24-24H40zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32H480c17.7 0 32-14.3 32-32s-14.3-32-32-32H192zM16 232v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V232c0-13.3-10.7-24-24-24H40c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24v48c0 13.3 10.7 24 24 24H88c13.3 0 24-10.7 24-24V392c0-13.3-10.7-24-24-24H40z">
                    </path>
                </svg><!-- <span class="fa-solid fa-list fs-10"></span> Font Awesome fontawesome.com -->
            </a>
            <a class="btn btn-phoenix-primary px-3 me-1 border-0 text-body"
                href="{{ route('cms.contractor.orders', ['vw' => 'lines']) }}" data-bs-toggle="tooltip"
                data-bs-placement="top" data-bs-title="Lines view">
                <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0 0.5C0 0.223857 0.223858 0 0.5 0H1.83333C2.10948 0 2.33333 0.223858 2.33333 0.5V1.83333C2.33333 2.10948 2.10948 2.33333 1.83333 2.33333H0.5C0.223857 2.33333 0 2.10948 0 1.83333V0.5Z"
                        fill="currentColor"></path>
                    <path
                        d="M3.33333 0.5C3.33333 0.223857 3.55719 0 3.83333 0H5.16667C5.44281 0 5.66667 0.223858 5.66667 0.5V1.83333C5.66667 2.10948 5.44281 2.33333 5.16667 2.33333H3.83333C3.55719 2.33333 3.33333 2.10948 3.33333 1.83333V0.5Z"
                        fill="currentColor"></path>
                    <path
                        d="M6.66667 0.5C6.66667 0.223857 6.89052 0 7.16667 0H8.5C8.77614 0 9 0.223858 9 0.5V1.83333C9 2.10948 8.77614 2.33333 8.5 2.33333H7.16667C6.89052 2.33333 6.66667 2.10948 6.66667 1.83333V0.5Z"
                        fill="currentColor"></path>
                    <path
                        d="M0 3.83333C0 3.55719 0.223858 3.33333 0.5 3.33333H1.83333C2.10948 3.33333 2.33333 3.55719 2.33333 3.83333V5.16667C2.33333 5.44281 2.10948 5.66667 1.83333 5.66667H0.5C0.223857 5.66667 0 5.44281 0 5.16667V3.83333Z"
                        fill="currentColor"></path>
                    <path
                        d="M3.33333 3.83333C3.33333 3.55719 3.55719 3.33333 3.83333 3.33333H5.16667C5.44281 3.33333 5.66667 3.55719 5.66667 3.83333V5.16667C5.66667 5.44281 5.44281 5.66667 5.16667 5.66667H3.83333C3.55719 5.66667 3.33333 5.44281 3.33333 5.16667V3.83333Z"
                        fill="currentColor"></path>
                    <path
                        d="M6.66667 3.83333C6.66667 3.55719 6.89052 3.33333 7.16667 3.33333H8.5C8.77614 3.33333 9 3.55719 9 3.83333V5.16667C9 5.44281 8.77614 5.66667 8.5 5.66667H7.16667C6.89052 5.66667 6.66667 5.44281 6.66667 5.16667V3.83333Z"
                        fill="currentColor"></path>
                    <path
                        d="M0 7.16667C0 6.89052 0.223858 6.66667 0.5 6.66667H1.83333C2.10948 6.66667 2.33333 6.89052 2.33333 7.16667V8.5C2.33333 8.77614 2.10948 9 1.83333 9H0.5C0.223857 9 0 8.77614 0 8.5V7.16667Z"
                        fill="currentColor"></path>
                    <path
                        d="M3.33333 7.16667C3.33333 6.89052 3.55719 6.66667 3.83333 6.66667H5.16667C5.44281 6.66667 5.66667 6.89052 5.66667 7.16667V8.5C5.66667 8.77614 5.44281 9 5.16667 9H3.83333C3.55719 9 3.33333 8.77614 3.33333 8.5V7.16667Z"
                        fill="currentColor"></path>
                    <path
                        d="M6.66667 7.16667C6.66667 6.89052 6.89052 6.66667 7.16667 6.66667H8.5C8.77614 6.66667 9 6.89052 9 7.16667V8.5C9 8.77614 8.77614 9 8.5 9H7.16667C6.89052 9 6.66667 8.77614 6.66667 8.5V7.16667Z"
                        fill="currentColor"></path>
                </svg>
            </a>
            <button class="btn px-3 btn-phoenix-secondary" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#scheduleFilterOffcanvas" aria-haspopup="true" aria-expanded="false"
                data-bs-reference="parent"><svg class="svg-inline--fa fa-filter text-primary" data-fa-transform="down-3"
                    aria-hidden="true" focusable="false" data-prefix="fas" data-icon="filter" role="img"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" data-fa-i2svg=""
                    style="transform-origin: 0.5em 0.6875em;">
                    <g transform="translate(256 256)">
                        <g transform="translate(0, 96)  scale(1, 1)  rotate(0 0 0)">
                            <path fill="currentColor"
                                d="M3.9 54.9C10.5 40.9 24.5 32 40 32H472c15.5 0 29.5 8.9 36.1 22.9s4.6 30.5-5.2 42.5L320 320.9V448c0 12.1-6.8 23.2-17.7 28.6s-23.8 4.3-33.5-3l-64-48c-8.1-6-12.8-15.5-12.8-25.6V320.9L9 97.3C-.7 85.4-2.8 68.8 3.9 54.9z"
                                transform="translate(-256 -256)"></path>
                        </g>
                    </g>
                </svg><!-- <span class="fa-solid fa-filter text-primary" data-fa-transform="down-3"></span> Font Awesome fontawesome.com -->
            </button>
            <button class="btn btn-sm btn-phoenix-secondary bg-body-emphasis bg-body-hover action-btn" type="button"
                data-bs-toggle="dropdown" data-boundary="window" aria-haspopup="true" aria-expanded="false"
                data-bs-reference="parent"><svg class="svg-inline--fa fa-ellipsis" data-fa-transform="shrink-2"
                    aria-hidden="true" focusable="false" data-prefix="fas" data-icon="ellipsis" role="img"
                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" data-fa-i2svg=""
                    style="transform-origin: 0.4375em 0.5em;">
                    <g transform="translate(224 256)">
                        <g transform="translate(0, 0)  scale(0.875, 0.875)  rotate(0 0 0)">
                            <path fill="currentColor"
                                d="M8 256a56 56 0 1 1 112 0A56 56 0 1 1 8 256zm160 0a56 56 0 1 1 112 0 56 56 0 1 1 -112 0zm216-56a56 56 0 1 1 0 112 56 56 0 1 1 0-112z"
                                transform="translate(-224 -256)"></path>
                        </g>
                    </g>
                </svg><!-- <span class="fas fa-ellipsis-h" data-fa-transform="shrink-2"></span> Font Awesome fontawesome.com -->
            </button>
            <ul class="dropdown-menu dropdown-menu-end" style="">
                <li><a class="dropdown-item ms-2 text-warning" href="#">
                        <span class="fa-solid fa-upload text-warning me-2"></span>Import</a></li>
                <li><a class="dropdown-item ms-2 text-success me-2" href="#">
                        <span class="fa-solid fa-download text-success me-2"></span>Export</a></li>
            </ul>
            {{-- <a href="javascript:void(0)" data-table="purchase_table" id="offcanvas-add-purchase" data-id="0">
                <button type="button" class="btn btn-primary px-5" data-bs-toggle="tooltip" data-bs-placement="right"
                    data-bs-original-title=" <?= get_label('add_new_purchase', 'Add new purchase order') ?>">
                    <i class="fa-solid fa-plus me-2"></i>Add new order
                </button>
            </a> --}}
        </div>
    </div>
    {{-- {{ $view_type }} --}}

    @if ($view_type == 'list')
    <x-cms.orders.contractor-order-card />
    @elseif ($view_type == 'lines')
    <x-cms.orders.contractor-order-lines-card />
    @endif

</div>
@include('cms.modals.contractor.orders_modal')
@endsection

@push('script')
<script src="{{ asset('assets/js/pages/cms/order_header.js') }}"></script>
@endpush