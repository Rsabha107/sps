@extends('cms.agency.layout.template')
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
        <div class="d-flex justify-content-end m-2 ">
            Agency
            {{-- <x-formy.button_insert_js
                table="order_table"
                selectionId="offcanvas-add-order"
                dataId="0"
                title="Add new Order"
                class="btn btn-primary px-5"
                icon="fa-solid fa-plus me-2"
            ></x-formy.button_insert_js> --}}
        </div>
    </div>

    <x-cms.orders.agency-order-card />
</div>
@include('cms.modals.agency.orders_modal')

@endsection

@push('script')
<script src="{{ asset('assets/js/pages/cms/agency/order_header.js') }}"></script>
@endpush