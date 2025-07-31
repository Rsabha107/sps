@extends('mds.operator.layout.customer_template')
@section('main')
    <!-- <div class="modal-dialog modal-lg modal-dialog-top"> -->
    <div class="container-small mt-5">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between m-2">
                    <div class="mb-0">
                        <h4 class="fw-bolder lh-sm" id="overviewtaskTitle">Reference: {{ $booking->booking_ref_number }}
                        </h4>
                        <p class="text-body-highlight fw-semibold mb-0">Booking Status:
                            <!-- <a class="ms-1 fw-bold" href="#!" id="overviewProjectName">Review </a> -->
                            <span
                                class="badge badge-phoenix badge-phoenix-{{ $booking->status->color }} fs-10 me-2">{{ $booking->status->title }}</span>
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('mds.operator.booking.rsp.status', $booking->id) }}">
                            <button class="btn px-3 btn-phoenix-secondary" data-bs-toggle="tooltip"
                                data-bs-placement="right" data-bs-original-title="Mark as Arrived at RSP">
                                <span class="fa-solid fa-edit me-sm-2"></span><span class="d-none d-sm-inline">Mark as
                                    Arrived at RSP</span>
                            </button>
                        </a>
                    </div>
                    {{-- <div class="col-12 col-md-auto">
                        <div class="d-flex">
                            <button class="btn btn-primary me-2"><a
                                    href="{{ route('mds.operator.booking.rsp.status', $booking->id) }}" class="text-white">
                                    <span class="far fa-edit me-2"></span><span>Mark as Arrived at RSP</span></a></button>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="card-body p-2 px-md-3 bg-body mb-3">
            {{-- <div class="row">
                <div class="col-12">
                    <div class="row align-items-center justify-content-between g-3 mb-3">
                        <div class="col-12 col-md-auto">
                            <div class="d-flex">
                                <button class="btn btn-primary me-2"><a
                                        href="{{ route('mds.operator.booking.rsp.status', $booking->id) }}"
                                        class="text-white">
                                        <span class="far fa-edit me-2"></span><span>Mark as Arrived at
                                            RSP</span></a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <div class="row g-2">
                <div class="col-12 col-md-12">
                    <div class="card py-3 px-3 mb-3">
                        <ul class="nav nav-underline fs-9 border-bottom" id="myTab" role="tablist">
                            <li class="nav-item"><a class="nav-link active" data-id="{{ $booking->id }}"
                                    id="booking-info-tab" data-bookingid="" data-bs-toggle="tab" href="#tab-booking-info"
                                    role="tab" aria-controls="tab-booking-info" aria-selected="ttrue">Booking
                                    Information</a></li>
                        </ul>
                        <div class="tab-content mt-3" id="myTabContent">

                            <div class="tab-pane fade  active show" id="tab-booking-info" role="tabpanel"
                                aria-labelledby="booking-info-tab">

                                <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 row-cols-xxl-2 g-3 mb-9">
                                                                        <div class="col">
                                        <div class="card h-100 ">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="me-1">Delivery Schedule</h4>
                                                    <button class="btn btn-link p-0">
                                                        <!-- <span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span> -->
                                                    </button>
                                                </div>

                                                <div class="col-md-12 col-sm-auto flex-1">
                                                    <table class="lh-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Scheduled Date : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ format_date($booking->booking_date) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Time : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->schedule->rsp_booking_slot }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Site :</td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->venue?->title }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    RSP :</td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->schedule->rsp->title }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 ">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="me-1">Company Party</h4>
                                                    <button class="btn btn-link p-0">
                                                        <!-- <span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span> -->
                                                    </button>
                                                </div>
                                                <div class="col-12 col-sm-auto flex-1">
                                                    <table class="lh-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Company : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->booking_party_company_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Name : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->booking_party_contact_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Email :</td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->booking_party_contact_email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Phone :</td>
                                                                <td class="text-warning fw-semibold ps-3">
                                                                    {{ $booking->booking_party_contact_number }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 ">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="me-1">Driver Information</h4>
                                                    <button class="btn btn-link p-0">
                                                        <!-- <span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span> -->
                                                    </button>
                                                </div>

                                                <div class="col-12 col-sm-auto flex-1">
                                                    <table class="lh-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Name : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->driver->first_name }}
                                                                    {{ $booking->driver->last_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Phone : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->driver->mobile_number }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    QID/Passport :</td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->driver->national_identifier_number }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 ">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="me-1">Vehicle Information</h4>
                                                    <button class="btn btn-link p-0">
                                                        <!-- <span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span> -->
                                                    </button>
                                                </div>

                                                <div class="col-12 col-sm-auto flex-1">
                                                    <table class="lh-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Type : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->vehicle_type->title }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    License Plate : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->vehicle->license_plate }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Make : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->vehicle->make }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Cargo : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->cargo->title }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 ">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="me-1">Delivery Information</h4>
                                                    <button class="btn btn-link p-0">
                                                        <!-- <span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span> -->
                                                    </button>
                                                </div>

                                                <div class="col-12 col-sm-auto flex-1">
                                                    <table class="lh-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Client : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->client?->title }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Receiver Name : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->receiver_name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Delivery/Collection : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->delivery_type->title }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Loading Zone : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->zone->title }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="card h-100 ">
                                            <div class="card-body">
                                                <div class="d-flex align-items-center mb-3">
                                                    <h4 class="me-1">Booking</h4>
                                                    <button class="btn btn-link p-0">
                                                        <!-- <span class="fas fa-pen fs-8 ms-3 text-body-quaternary"></span> -->
                                                    </button>
                                                </div>

                                                <div class="col-12 col-sm-auto flex-1">
                                                    <table class="lh-sm">
                                                        <tbody>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Created by : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->created_by_who->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Created at : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ format_date($booking->created_at) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    Email : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->created_by_who->email }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="align-top py-1 text-body text-nowrap fw-bold">
                                                                    phone : </td>
                                                                <td
                                                                    class="text-body-tertiary text-opacity-85 fw-semibold ps-3">
                                                                    {{ $booking->created_by_who->phone }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
    </div>
@endsection

@push('script')
@endpush
