<script>
    // $(".generate_qr_vouchers").on("click", function(e) {
    //     e.preventDefault(); // Prevent default action
    //     const orderLineId = $(this).data("order-line-id");
    //     console.log(`Generating QR for order line ID: ${orderLineId}`);

    //                     $.ajax({
    //         url: "/mds/admin/booking/schedule",
    //         method: "post", // Change to GET if you want
    //         data: {
    //             // Our data
    //             venue_id: venue_id, // Team ID
    //         },
    //         headers: {
    //             "X-CSRF-TOKEN": $('input[name="_token"]').attr("value"), // Replace with your method of getting the CSRF token
    //         },
    //         dataType: "json",
    //         success: function (data) {
    //             console.log(data);
    //             successCallback(data);
    //         },
    //         // error: function(error) {
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             $("#cover-spin").hide();
    //             console.log(xhr.status);
    //             console.log(thrownError);
    //             alert(thrownError);
    //         },
    //     });
    //     // Simulate QR code generation (replace with actual logic)
    //     // setTimeout(() => {
    //     //     alert(`QR code generated for order line ID: ${orderLineId}`);
    //     //     // Optionally, you can update the UI or perform other actions here
    //     // }, 1000); // Simulate network latency
    // });


</script>
<div class="mx-n4 px-4 mx-lg-n8 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1 mt-4">
    <h5 class="mb-0 py-3">Order#: {{ $order->order_number }}</h5>
    <div class="table-responsive scrollbar mx-n1 px-1">
        <table class="table table-sm fs-9 mb-0" id="orderLinesTable">
            <thead>
                <tr>
                    <th class="sort white-space-nowrap align-middle ps-3" scope="col" data-sort="order" style="width:3%;"></th>
                    <th class="sort white-space-nowrap align-middle ps-2" scope="col" data-sort="order" style="width:5%;">Service Date</th>
                    <th class="sort align-middle text-end" scope="col" data-sort="total" style="width:10%;">Menu</th>
                    <th class="sort align-middle ps-8" scope="col" data-sort="customer" style="width:10%;">Service Time</th>
                    <th class="sort align-middle pe-3" scope="col" data-sort="payment_status" style="width:10%;">Venue</th>
                    <th class="sort align-middle text-start pe-3" scope="col" data-sort="fulfilment_status" style="width:12%; min-width: 200px;">Location</th>
                    <th class="sort align-middle text-start" scope="col" data-sort="delivery_type" style="width:6%;">Qnty</th>
                    <th class="sort align-middle text-start" scope="col" data-sort="delivery_type" style="width:6%;">Chkn</th>
                    <th class="sort align-middle text-start" scope="col" data-sort="delivery_type" style="width:6%;">M/L</th>
                    <th class="sort align-middle text-start" scope="col" data-sort="delivery_type" style="width:6%;">Vegi</th>
                    <th class="sort align-middle text-end pe-0" scope="col" data-sort="date" style="width:6%;">Unit Price</th>
                    <th class="sort align-middle text-end pe-2" scope="col" data-sort="date" style="width:10%;">Total</th>
                </tr>
            </thead>
            <tbody class="list" id="order-table-body">
                @foreach ($lines as $line)
                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                    <td class="order align-middle white-space-nowrap ps-3 btn btn-sm me-3 generate_qr_vouchers" data-order-line-id="{{ $line->id }}">
                        <a href="{{ route('cms.contractor.orders.voucher.qr.pdf', $token = app(\App\Services\OrderTokenService::class)->encode($line->id, now()->addMinutes(30)))}}" target="_blank"><span class="fa-solid fa-qrcode"></span></a></td>
                    <td class="order align-middle white-space-nowrap ps-3"><span class="text-body-tertiary">{{ $line->service_date }}</span></td>
                    <td class="total align-middle text-end fw-semibold text-body-highlight">{{ $line->product->product_name }}</td>
                    <td class="customer align-middle white-space-nowrap ps-8">{{ $line->service_time->service_time_range }}</td>
                    <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary">{{ $line->venue->short_name }}</td>
                    <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary">{{ $line->service_location->title }}</td>

                    <!-- <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2453</a></td>
                                    <td class="total align-middle text-end fw-semibold text-body-highlight">$87</td>
                                    <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                                            <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/32.webp" alt="" />
                                            </div>
                                            <h6 class="mb-0 ms-3 text-body">Carry Anna</h6>
                                        </a></td>
                                    <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Complete</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                                    <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><span class="badge-label">Cancelled</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                                     -->
                    <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">{{ $line->quantity }}</td>
                    <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">{{ $line->chicken_quantity }}</td>
                    <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">{{ $line->meat_quantity }}</td>
                    <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">{{ $line->vegetarian_quantity }}</td>
                    <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">{{ format_currency($line->unit_price, 'QAR') }}</td>
                    <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 pe-2 text-end">{{ format_currency($line->line_total, 'QAR') }}</td>
                </tr>
                @endforeach
            <tfoot>
                <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                    <th class="order align-middle text-end white-space-nowrap text-body-tertiary" colspan="5">Total</th>
                    <th class="order align-middle  white-space-nowrap text-body-tertiary">{{ $total_orders->total_quantity }}</th>
                    <th class="total align-middle text-end fw-semibold text-body-highlight pe-2" colspan="8">{{ format_currency($total_orders->total_amount, 'QAR') }}</th>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
    {{-- <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                        <div class="col-auto d-flex">
                            <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p>
                            <a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                            <a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                        </div>
                        <div class="col-auto d-flex">
                            <button class="page-link" data-list-pagination="prev">{{ format_currency($total_orders->total_amount, 'QAR') }}</span></button>
    <ul class="mb-0 pagination"></ul>
    <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
</div>
</div> --}}
</div>