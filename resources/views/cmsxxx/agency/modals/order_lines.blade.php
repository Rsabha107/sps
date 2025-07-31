<div class="modal fade" id="order_lines_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-100">
                        <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis border-top border-bottom border-translucent position-relative top-1">
              <div class="table-responsive scrollbar mx-n1 px-1">
                <table class="table table-sm fs-9 mb-0">
                  <thead>
                    <tr>
                      <th class="white-space-nowrap fs-9 align-middle ps-0" style="width:26px;">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" id="checkbox-bulk-order-select" type="checkbox" data-bulk-select='{"body":"order-table-body"}' />
                        </div>
                      </th>
                      <th class="sort white-space-nowrap align-middle pe-3" scope="col" data-sort="order" style="width:5%;">ORDER</th>
                      <th class="sort align-middle text-end" scope="col" data-sort="total" style="width:6%;">TOTAL</th>
                      <th class="sort align-middle ps-8" scope="col" data-sort="customer" style="width:28%; min-width: 250px;">CUSTOMER</th>
                      <th class="sort align-middle pe-3" scope="col" data-sort="payment_status" style="width:10%;">PAYMENT STATUS</th>
                      <th class="sort align-middle text-start pe-3" scope="col" data-sort="fulfilment_status" style="width:12%; min-width: 200px;">FULFILMENT STATUS</th>
                      <th class="sort align-middle text-start" scope="col" data-sort="delivery_type" style="width:30%;">DELIVERY TYPE</th>
                      <th class="sort align-middle text-end pe-0" scope="col" data-sort="date">DATE</th>
                    </tr>
                  </thead>
                  <tbody class="list" id="order-table-body">
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2453,"total":87,"customer":{"avatar":"/team/32.webp","name":"Carry Anna"},"payment_status":{"label":"Complete","type":"badge-phoenix-success","icon":"check"},"fulfilment_status":{"label":"Cancelled","type":"badge-phoenix-secondary","icon":"x"},"delivery_type":"Cash on delivery","date":"Dec 12, 12:56 PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2453</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$87</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/32.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Carry Anna</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Complete</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><span class="badge-label">Cancelled</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Cash on delivery</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Dec 12, 12:56 PM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2452,"total":7264,"customer":{"avatar":"","name":"Milind Mikuja"},"fulfilment_status":{"label":"Ready to pickup","type":"badge-phoenix-info","icon":"info"},"payment_status":{"label":"Cancelled","type":"badge-phoenix-secondary","icon":"x"},"delivery_type":"Free shipping","date":"Dec 9, 2:28PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2452</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$7264</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m">
                            <div class="avatar-name rounded-circle"><span>M</span></div>
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Milind Mikuja</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><span class="badge-label">Cancelled</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-info"><span class="badge-label">Ready to pickup</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Free shipping</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Dec 9, 2:28PM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2451,"total":375,"customer":{"avatar":"/team/35.webp","name":"Stanly Drinkwater"},"payment_status":{"label":"Pending","type":"badge-phoenix-warning","icon":"clock"},"fulfilment_status":{"label":"Completed","type":"badge-phoenix-success","icon":"check"},"delivery_type":"Local pickup","date":"Dec 4, 12:56 PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2451</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$375</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/35.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Stanly Drinkwater</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">Pending</span><span class="ms-1" data-feather="clock" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Completed</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Local pickup</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Dec 4, 12:56 PM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2450,"total":657,"customer":{"avatar":"/team/57.webp","name":"Josef Stravinsky"},"payment_status":{"label":"Cancelled","type":"badge-phoenix-secondary","icon":"x"},"fulfilment_status":{"label":"Partially Fulfiled","type":"badge-phoenix-warning","icon":"clock"},"delivery_type":"Standard shipping","date":"Dec 1, 4:07 AM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2450</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$657</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/57.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Josef Stravinsky</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><span class="badge-label">Cancelled</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">Partially Fulfiled</span><span class="ms-1" data-feather="clock" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Standard shipping</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Dec 1, 4:07 AM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2449,"total":9562,"customer":{"avatar":"/team/58.webp","name":"Igor Borvibson"},"payment_status":{"label":"Failed","type":"badge-phoenix-danger","icon":"x"},"fulfilment_status":{"label":"Partially Fulfiled","type":"badge-phoenix-success","icon":"check"},"delivery_type":"Express","date":"Nov 28, 7:28 PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2449</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$9562</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/58.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Igor Borvibson</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span class="badge-label">Failed</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Partially Fulfiled</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Express</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Nov 28, 7:28 PM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2448,"total":46,"customer":{"avatar":"/team/59.webp","name":"Katerina Karenin"},"payment_status":{"label":"Paid","type":"badge-phoenix-success","icon":"check"},"fulfilment_status":{"label":"Unfulfiled","type":"badge-phoenix-danger","icon":"x"},"delivery_type":"Local delivery","date":"Nov 24, 10:16 AM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2448</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$46</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/59.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Katerina Karenin</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Paid</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span class="badge-label">Unfulfiled</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Local delivery</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Nov 24, 10:16 AM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2447,"total":953,"customer":{"avatar":"","name":"Roy Anderson"},"payment_status":{"label":"Pending","type":"badge-phoenix-warning","icon":"clock"},"fulfilment_status":{"label":"Fulfiled","type":"badge-phoenix-success","icon":"check"},"delivery_type":"Cash on delivery","date":"Nov 18, 5:43 PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2447</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$953</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m">
                            <div class="avatar-name rounded-circle"><span>R</span></div>
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Roy Anderson</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">Pending</span><span class="ms-1" data-feather="clock" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Fulfiled</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Cash on delivery</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Nov 18, 5:43 PM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2446,"total":12,"customer":{"avatar":"/team/31.webp","name":"Martina scorcese"},"payment_status":{"label":"Pending","type":"badge-phoenix-warning","icon":"clock"},"fulfilment_status":{"label":"Fulfiled","type":"badge-phoenix-success","icon":"check"},"delivery_type":"Standard shipping","date":"Nov 18, 2:09 AM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2446</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$12</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/31.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Martina scorcese</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">Pending</span><span class="ms-1" data-feather="clock" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Fulfiled</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Standard shipping</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Nov 18, 2:09 AM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2445,"total":3927,"customer":{"avatar":"/team/33.webp","name":"Luis Bunuel"},"payment_status":{"label":"Paid","type":"badge-phoenix-success","icon":"check"},"fulfilment_status":{"label":"Canceled","type":"badge-phoenix-secondary","icon":"x"},"delivery_type":"Cash on delivery","date":"Nov 16, 3:22 PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2445</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$3927</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/33.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Luis Bunuel</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Paid</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><span class="badge-label">Canceled</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Cash on delivery</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Nov 16, 3:22 PM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2444,"total":5937,"customer":{"avatar":"/team/34.webp","name":"Jean Renoir"},"payment_status":{"label":"Paid","type":"badge-phoenix-success","icon":"check"},"fulfilment_status":{"label":"Ready to pickup","type":"badge-phoenix-secondary","icon":"info"},"delivery_type":"Local pickup","date":"Nov 09, 8:49 AM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2444</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$5937</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/34.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Jean Renoir</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Paid</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><span class="badge-label">Ready to pickup</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Local pickup</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Nov 09, 8:49 AM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2443,"total":124,"customer":{"avatar":"/team/29.webp","name":"Ricky Antony"},"payment_status":{"label":"Failed","type":"badge-phoenix-danger","icon":"x"},"fulfilment_status":{"label":"Unfulfiled","type":"badge-phoenix-danger","icon":"x"},"delivery_type":"Cash on delivery","date":"Nov 05, 4:35 PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2443</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$124</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/29.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Ricky Antony</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span class="badge-label">Failed</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span class="badge-label">Unfulfiled</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Cash on delivery</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Nov 05, 4:35 PM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2442,"total":542,"customer":{"avatar":"/team/3.webp","name":"Emma Watson"},"payment_status":{"label":"Pending","type":"badge-phoenix-warning","icon":"clock"},"fulfilment_status":{"label":"Fulfiled","type":"badge-phoenix-success","icon":"check"},"delivery_type":"Standard shipping","date":"Nov 05, 12:00 PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2442</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$542</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/3.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Emma Watson</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">Pending</span><span class="ms-1" data-feather="clock" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Fulfiled</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Standard shipping</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Nov 05, 12:00 PM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2441,"total":1480,"customer":{"avatar":"/team/avatar.webp","name":"Jennifer Schramm","placeholder":true},"payment_status":{"label":"Paid","type":"badge-phoenix-success","icon":"check"},"fulfilment_status":{"label":"Ready to pickup","type":"badge-phoenix-info","icon":"info"},"delivery_type":"Local delivery","date":"Nov 02, 2:00 AM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2441</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$1480</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle avatar-placeholder" src="../../../assets/img/team/avatar.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Jennifer Schramm</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Paid</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-info"><span class="badge-label">Ready to pickup</span><span class="ms-1" data-feather="info" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Local delivery</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Nov 02, 2:00 AM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2440,"total":80,"customer":{"avatar":"/team/25.webp","name":"Michael Jenkins"},"payment_status":{"label":"Cancelled","type":"badge-phoenix-secondary","icon":"x"},"fulfilment_status":{"label":"Unfulfiled","type":"badge-phoenix-danger","icon":"x"},"delivery_type":"Free shipping","date":"Oct 30, 4:25 PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2440</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$80</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/25.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Michael Jenkins</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><span class="badge-label">Cancelled</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-danger"><span class="badge-label">Unfulfiled</span><span class="ms-1" data-feather="x" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Free shipping</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Oct 30, 4:25 PM</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="fs-9 align-middle px-0 py-3">
                        <div class="form-check mb-0 fs-8">
                          <input class="form-check-input" type="checkbox" data-bulk-select-row='{"order":2439,"total":999,"customer":{"avatar":"/team/32.webp","name":"Raymond Mims"},"payment_status":{"label":"Pending","type":"badge-phoenix-warning","icon":"clock"},"fulfilment_status":{"label":"Fulfiled","type":"badge-phoenix-success","icon":"check"},"delivery_type":"Cash on delivery","date":"Oct 28, 3:00 PM"}' />
                        </div>
                      </td>
                      <td class="order align-middle white-space-nowrap py-0"><a class="fw-semibold" href="#!">#2439</a></td>
                      <td class="total align-middle text-end fw-semibold text-body-highlight">$999</td>
                      <td class="customer align-middle white-space-nowrap ps-8"><a class="d-flex align-items-center text-body" href="../../../apps/e-commerce/landing/profile.html">
                          <div class="avatar avatar-m"><img class="rounded-circle" src="../../../assets/img/team/32.webp" alt="" />
                          </div>
                          <h6 class="mb-0 ms-3 text-body">Raymond Mims</h6>
                        </a></td>
                      <td class="payment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-warning"><span class="badge-label">Pending</span><span class="ms-1" data-feather="clock" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="fulfilment_status align-middle white-space-nowrap text-start fw-bold text-body-tertiary"><span class="badge badge-phoenix fs-10 badge-phoenix-success"><span class="badge-label">Fulfiled</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span></td>
                      <td class="delivery_type align-middle white-space-nowrap text-body fs-9 text-start">Cash on delivery</td>
                      <td class="date align-middle white-space-nowrap text-body-tertiary fs-9 ps-4 text-end">Oct 28, 3:00 PM</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="row align-items-center justify-content-between py-2 pe-0 fs-9">
                <div class="col-auto d-flex">
                  <p class="mb-0 d-none d-sm-block me-3 fw-semibold text-body" data-list-info="data-list-info"></p><a class="fw-semibold" href="#!" data-list-view="*">View all<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a><a class="fw-semibold d-none" href="#!" data-list-view="less">View Less<span class="fas fa-angle-right ms-1" data-fa-transform="down-1"></span></a>
                </div>
                <div class="col-auto d-flex">
                  <button class="page-link" data-list-pagination="prev"><span class="fas fa-chevron-left"></span></button>
                  <ul class="mb-0 pagination"></ul>
                  <button class="page-link pe-0" data-list-pagination="next"><span class="fas fa-chevron-right"></span></button>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="edit_drivers_modal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">Edit vehicle types
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form novalidate="" class="modal-content form-submit-event needs-validation" id="edit_form_submit_event" action="{{route('mds.setting.driver.update')}}" method="POST">
                @csrf
                <input type="hidden" id="edit_drivers_id" name="id" value="">
                <input type="hidden" id="edit_drivers_table" name="table">
                <div class="modal-body">
                    <div class="col-md-12 mb-2">
                        <label for="nameBasic" class="form-label"><?= get_label('first_name', 'First Name') ?> <span class="asterisk">*</span></label>
                        <input required type="text" id="edit_drivers_first_name" class="form-control" name="first_name" placeholder="<?= get_label('please_enter_first_name', 'Please enter first name') ?>" />
                    </div>

                    <div class="col-md-12 mb-2">
                        <label for="nameBasic" class="form-label"><?= get_label('last_name', 'Last Name') ?> <span class="asterisk">*</span></label>
                        <input required type="text" id="edit_drivers_last_name" class="form-control" name="last_name" placeholder="<?= get_label('please_enter_last_name', 'Please enter last name') ?>" />
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="nameBasic" class="form-label"><?= get_label('mobile_number', 'Mobile Number') ?> <span class="asterisk">*</span></label>
                        <input required type="text" id="edit_drivers_mobile_number" class="form-control" name="mobile_number" placeholder="<?= get_label('please_enter_mobile_number', 'Please enter mobile number') ?>" />
                    </div>
                    <div class="col-md-12 mb-2">
                        <label for="nameBasic" class="form-label"><?= get_label('qid_passport', 'QID/Passport') ?> <span class="asterisk">*</span></label>
                        <input required type="text" id="edit_drivers_national_identifier_number" class="form-control" name="national_identifier_number" placeholder="<?= get_label('please_enter_national_identifier_number', 'Please enter QID/Passport') ?>" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <?= get_label('close', 'Close') ?></label>
                    </button>
                    <button type="submit" class="btn btn-primary" id="submit_btn"><?= get_label('save','Save') ?></label></button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="orderStatusModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-top">
        <div class="modal-content bg-100">
            <div class="modal-header bg-modal-header">
                <h3 class=" text-white mb-0" id="staticBackdropLabel">Change Status</h3>
                <button class="btn p-1" type="button" data-bs-dismiss="modal" aria-label="Close"><span class="fas fa-times fs--1 text-danger"></span></button>
            </div>
            <form class="needs-validation form-submit-event" novalidate="" action="{{route('mds.driver.status.update')}}" method="POST" id="task_status">
                <!-- <form class="needs-validation" novalidate="" action="{{url('/tracki/task/status/update')}}" method="POST" id="task_status"> -->
                @csrf
                <div class="modal-body">
                    <div class="modal-body px-0">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <input type="hidden" id="editDriverId" name="id">
                                <input type="hidden" id="driverStatusTable" name="table">
                                <div class="mb-4">
                                    <label class="text-1000 fw-bold mb-2">Status</label>
                                    <select name="status_id" class="form-select" id="editDriverStatusSelection" required>
                                        <option selected="selected" value="">Select</option>
                                        @foreach ($driver_statuses as $key => $item )
                                        <option value="{{ $item->id  }}">
                                            {{ $item->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <!-- <input class="form-control" type="number" max="100" min="0" name="prorgress_number" id="editPoregessNumber" required /> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-danger" type="button" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" type="submit" id="submit_btn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

