@extends('mds.admin.layout.admin_dashboard_template')
@section('main')

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->

        <div class="widgets-scrollspy-nav mt-n5 bg-body-emphasis z-5 mx-n4 mx-lg-n6 border-bottom">
          <nav class="simplebar-scrollspy navbar py-0 scrollbar-overlay" id="widgets-scrollspy">
            <ul class="nav flex-nowrap">
              <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap" href="#scrollspyStats">Number Stats and Charts</a></li>
              <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap" href="#scrollspyTables">Tables, Files, and Lists</a></li>
              <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap" href="#scrollspyEcommerce">E-commerce</a></li>
              <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap" href="#scrollspyUsers">Users & Feed</a></li>
              <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap" href="#scrollspyForms">Forms</a></li>
              <li class="nav-item"> <a class="nav-link text-body-tertiary fw-bold py-3 lh-1 text-nowrap" href="#scrollspyOthers">Others</a></li>
            </ul>
          </nav>
        </div>
        <div class="mb-9" data-bs-spy="scroll" data-bs-target="#widgets-scrollspy">
          <div class="d-flex mb-5 pt-8" id="scrollspyStats"><span class="fa-stack me-2 ms-n1"><i class="fas fa-circle fa-stack-2x text-primary"></i><i class="fa-inverse fa-stack-1x text-primary-subtle fas fa-percentage"></i></span>
            <div class="col">
              <h3 class="mb-0 text-primary position-relative fw-bold"><span class="bg-body pe-2">Number Stats &amp; Charts</span><span class="border border-primary position-absolute top-50 translate-middle-y w-100 start-0 z-n1"></span></h3>
              <p class="mb-0">You can easily show your stats content by using these cards.</p>
            </div>
          </div>
          <div class="px-3 mb-5">
            <div class="row justify-content-between">
              <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-end-xxl-0 border-bottom-xxl-0 border-end border-bottom pb-4 pb-xxl-0 "><span class="fa-regular fa-calendar-days text-primary fa-xl"></span>
                <h1 class="fs-5 pt-3">{{ $booking_scheduled_today }}</h1>
                <p class="fs-9 mb-0">Scheduled Today</p>
              </div>
              <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-end-xxl-0 border-bottom-xxl-0 border-end-md border-bottom pb-4 pb-xxl-0"><span class="fa-regular fa-calendar-plus text-info fa-xl"></span>
                <h1 class="fs-5 pt-3">{{ $booking_scheduled_tomorrow }}</h1>
                <p class="fs-9 mb-0">Scheduled Tomorrow</p>
              </div>
              <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-bottom-xxl-0 border-bottom border-end border-end-md-0 pb-4 pb-xxl-0 pt-4 pt-md-0"><span class="fa-solid fa-book text-primary fa-xl"></span>
                <h1 class="fs-5 pt-3">{{ $total_bookings }}</h1>
                <p class="fs-9 mb-0">Total to Date</p>
              </div>
              <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-end-md border-end-xxl-0 border-bottom border-bottom-md-0 pb-4 pb-xxl-0 pt-4 pt-xxl-0"><span class="fa-solid fa-check-double text-primary fa-xl"></span>
                <h1 class="fs-5 pt-3">{{ $total_checked_in }}</h1>
                <p class="fs-9 mb-0">Checked-in to Date</p>
              </div>
              <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-end border-end-xxl-0 pb-md-4 pb-xxl-0 pt-4 pt-xxl-0"><span class="fa-solid fa-user-check text-success fa-xl"></span>
                <h1 class="fs-5 pt-3">{{ $total_users }}</h1>
                <p class="fs-9 mb-0">Registered Users</p>
              </div>
              <div class="col-6 col-md-4 col-xxl-2 text-center border-translucent border-start-xxl border-end-xxl pb-md-4 pb-xxl-0 pt-4 pt-xxl-0"><span class="uil fs-5 lh-1 uil-envelope-block text-danger"></span>
                <h1 class="fs-5 pt-3">500</h1>
                <p class="fs-9 mb-0">Something else</p>
              </div>
            </div>
          </div>
          <div class="row g-3 mb-5">
            <div class="col-md-6 col-xxl-3">
              <div class="card h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h5 class="mb-1">Total orders<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-9 ms-2"><span class="badge-label">-6.8%</span></span></h5>
                      <h6 class="text-body-tertiary">Last 7 days</h6>
                    </div>
                    <h4>16,247</h4>
                  </div>
                  <div class="d-flex justify-content-center px-4 py-6">
                    <div class="echart-total-orders" style="height:85px;width:115px"></div>
                  </div>
                  <div class="mt-2">
                    <div class="d-flex align-items-center mb-2">
                      <div class="bullet-item bg-primary me-2"></div>
                      <h6 class="text-body fw-semibold flex-1 mb-0">Completed</h6>
                      <h6 class="text-body fw-semibold mb-0">52%</h6>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="bullet-item bg-primary-subtle me-2"></div>
                      <h6 class="text-body fw-semibold flex-1 mb-0">Pending payment</h6>
                      <h6 class="text-body fw-semibold mb-0">48%</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xxl-3">
              <div class="card h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h5 class="mb-1">New customers<span class="badge badge-phoenix badge-phoenix-warning rounded-pill fs-9 ms-2"> <span class="badge-label">+26.5%</span></span></h5>
                      <h6 class="text-body-tertiary">Last 7 days</h6>
                    </div>
                    <h4>356</h4>
                  </div>
                  <div class="pb-0 pt-4">
                    <div class="echarts-new-customers" style="height:180px;width:100%;"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xxl-3">
              <div class="card h-100">
                <div class="card-body">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h5 class="mb-2">Top coupons</h5>
                      <h6 class="text-body-tertiary">Last 7 days</h6>
                    </div>
                  </div>
                  <div class="pb-4 pt-3">
                    <div class="echart-top-coupons" style="height:115px;width:100%;"></div>
                  </div>
                  <div>
                    <div class="d-flex align-items-center mb-2">
                      <div class="bullet-item bg-primary me-2"></div>
                      <h6 class="text-body fw-semibold flex-1 mb-0">Percentage discount</h6>
                      <h6 class="text-body fw-semibold mb-0">72%</h6>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                      <div class="bullet-item bg-primary-lighter me-2"></div>
                      <h6 class="text-body fw-semibold flex-1 mb-0">Fixed card discount</h6>
                      <h6 class="text-body fw-semibold mb-0">18%</h6>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="bullet-item bg-info-dark me-2"></div>
                      <h6 class="text-body fw-semibold flex-1 mb-0">Fixed product discount</h6>
                      <h6 class="text-body fw-semibold mb-0">10%</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-xxl-3">
              <div class="card h-100">
                <div class="card-body d-flex flex-column">
                  <div class="d-flex justify-content-between">
                    <div>
                      <h5 class="mb-2">Paying vs non paying</h5>
                      <h6 class="text-body-tertiary">Last 7 days</h6>
                    </div>
                  </div>
                  <div class="d-flex justify-content-center pt-3 flex-1">
                    <div class="echarts-paying-customer-chart" style="height:100%;width:100%;"></div>
                  </div>
                  <div class="mt-3">
                    <div class="d-flex align-items-center mb-2">
                      <div class="bullet-item bg-primary me-2"></div>
                      <h6 class="text-body fw-semibold flex-1 mb-0">Paying customer</h6>
                      <h6 class="text-body fw-semibold mb-0">30%</h6>
                    </div>
                    <div class="d-flex align-items-center">
                      <div class="bullet-item bg-primary-subtle me-2"></div>
                      <h6 class="text-body fw-semibold flex-1 mb-0">Non-paying customer</h6>
                      <h6 class="text-body fw-semibold mb-0">70%</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row gx-4 gy-6 pb-5">
            <div class="col-xxl-6">
              <div class="mb-3">
                <h3>New Users &amp; Leads</h3>
                <p class="text-body-tertiary mb-0">Payment received across all channels</p>
              </div>
              <div class="row g-6">
                <div class="col-md-6 mb-2 mb-sm-0">
                  <div class="d-flex align-items-center"><span class="me-2 text-info" data-feather="users" style="min-height:24px; width:24px"></span>
                    <h4 class="text-body-tertiary mb-0">New Users :<span class="text-body-emphasis"> 42</span></h4><span class="badge badge-phoenix fs-10 badge-phoenix-success d-inline-flex align-items-center ms-2"><span class="badge-label d-inline-block lh-base">+24.5%</span><span class="ms-1 fa-solid fa-caret-up d-inline-block lh-1"></span></span>
                  </div>
                  <div class="pb-0 pt-4">
                    <div class="echarts-new-users" style="min-height:110px;width:100%;"></div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="d-flex align-items-center"><span class="me-2 text-primary" data-feather="zap" style="height:24px; width:24px"></span>
                    <h4 class="text-body-tertiary mb-0">New Leads :<span class="text-body-emphasis"> 45</span></h4><span class="badge badge-phoenix fs-10 badge-phoenix-success d-inline-flex align-items-center ms-2"><span class="badge-label d-inline-block lh-base">+30.5%</span><span class="ms-1 fa-solid fa-caret-up d-inline-block lh-1"></span></span>
                  </div>
                  <div class="pb-0 pt-4">
                    <div class="echarts-new-leads" style="min-height:110px;width:100%;"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-6">
              <div class="row">
                <div class="col-sm-7 col-md-8 col-xxl-8 mb-md-3 mb-lg-0">
                  <h3>New Contacts by Source</h3>
                  <p class="text-body-tertiary">Payment received across all channels</p>
                  <div class="row g-0">
                    <div class="col-6 col-xl-4">
                      <div class="d-flex flex-column flex-center align-items-sm-start flex-md-row justify-content-md-between flex-xxl-column p-3 ps-sm-3 ps-md-4 p-md-3 h-100 border-1 border-bottom border-end border-translucent">
                        <div class="d-flex align-items-center mb-1"><span class="fa-solid fa-square fs-11 me-2 text-primary" data-fa-transform="up-2"></span><span class="mb-0 fs-9 text-body">Organic</span></div>
                        <h3 class="fw-semibold ms-xl-3 ms-xxl-0 pe-md-2 pe-xxl-0 mb-0 mb-sm-3">80</h3>
                      </div>
                    </div>
                    <div class="col-6 col-xl-4">
                      <div class="d-flex flex-column flex-center align-items-sm-start flex-md-row justify-content-md-between flex-xxl-column p-3 ps-sm-3 ps-md-4 p-md-3 h-100 border-1 border-bottom border-end-md-0 border-end-xl border-translucent">
                        <div class="d-flex align-items-center mb-1"><span class="fa-solid fa-square fs-11 me-2 text-success" data-fa-transform="up-2"></span><span class="mb-0 fs-9 text-body">Paid Search</span></div>
                        <h3 class="fw-semibold ms-xl-3 ms-xxl-0 pe-md-2 pe-xxl-0 mb-0 mb-sm-3">65</h3>
                      </div>
                    </div>
                    <div class="col-6 col-xl-4">
                      <div class="d-flex flex-column flex-center align-items-sm-start flex-md-row justify-content-md-between flex-xxl-column p-3 ps-sm-3 ps-md-4 p-md-3 h-100 border-1 border-bottom border-end border-end-md border-end-xl-0 border-translucent">
                        <div class="d-flex align-items-center mb-1"><span class="fa-solid fa-square fs-11 me-2 text-info" data-fa-transform="up-2"></span><span class="mb-0 fs-9 text-body">Direct</span></div>
                        <h3 class="fw-semibold ms-xl-3 ms-xxl-0 pe-md-2 pe-xxl-0 mb-0 mb-sm-3">40</h3>
                      </div>
                    </div>
                    <div class="col-6 col-xl-4">
                      <div class="d-flex flex-column flex-center align-items-sm-start flex-md-row justify-content-md-between flex-xxl-column p-3 ps-sm-3 ps-md-4 p-md-3 h-100 border-1 border-end-xl border-bottom border-bottom-xl-0 border-translucent">
                        <div class="d-flex align-items-center mb-1"><span class="fa-solid fa-square fs-11 me-2 text-info-light" data-fa-transform="up-2"></span><span class="mb-0 fs-9 text-body">Social</span></div>
                        <h3 class="fw-semibold ms-xl-3 ms-xxl-0 pe-md-2 pe-xxl-0 mb-0 mb-sm-3">220</h3>
                      </div>
                    </div>
                    <div class="col-6 col-xl-4">
                      <div class="d-flex flex-column flex-center align-items-sm-start flex-md-row justify-content-md-between flex-xxl-column p-3 ps-sm-3 ps-md-4 p-md-3 h-100 border-1 border-end border-translucent">
                        <div class="d-flex align-items-center mb-1"><span class="fa-solid fa-square fs-11 me-2 text-danger-lighter" data-fa-transform="up-2"></span><span class="mb-0 fs-9 text-body">Referrals</span></div>
                        <h3 class="fw-semibold ms-xl-3 ms-xxl-0 pe-md-2 pe-xxl-0 mb-0 mb-sm-3">120</h3>
                      </div>
                    </div>
                    <div class="col-6 col-xl-4">
                      <div class="d-flex flex-column flex-center align-items-sm-start flex-md-row justify-content-md-between flex-xxl-column p-3 ps-sm-3 ps-md-4 p-md-3 h-100">
                        <div class="d-flex align-items-center mb-1"><span class="fa-solid fa-square fs-11 me-2 text-warning-light" data-fa-transform="up-2"></span><span class="mb-0 fs-9 text-body">Others</span></div>
                        <h3 class="fw-semibold ms-xl-3 ms-xxl-0 pe-md-2 pe-xxl-0 mb-0 mb-sm-3">35</h3>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-5 col-md-4 col-xxl-4 my-3 my-sm-0">
                  <div class="position-relative d-flex flex-center mb-sm-4 mb-xl-0 echart-contact-by-source-container mt-sm-7 mt-lg-4 mt-xl-0">
                    <div class="echart-contact-by-source" style="min-height:245px;width:100%"></div>
                    <div class="position-absolute rounded-circle bg-primary-subtle top-50 start-50 translate-middle d-flex flex-center" style="height:100px; width:100px;">
                      <h3 class="mb-0 text-primary-dark fw-bolder" data-label="data-label"></h3>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis py-5">
            <div class="row g-6">
              <div class="col-12 col-xl-6">
                <div class="me-xl-4">
                  <div>
                    <h3>Projection vs actual</h3>
                    <p class="mb-1 text-body-tertiary">Actual earnings vs projected earnings</p>
                  </div>
                  <div class="echart-projection-actual" style="height:300px; width:100%"></div>
                </div>
              </div>
              <div class="col-12 col-xl-6">
                <div>
                  <h3>Returning customer rate</h3>
                  <p class="mb-1 text-body-tertiary">Rate of customers returning to your shop over time</p>
                </div>
                <div class="echart-returning-customer" style="height:300px;"></div>
              </div>
            </div>
          </div>
          <div class="row g-6 pt-6 align-items-center">
            <div class="col-xxl-6">
              <div class="row flex-between-center mb-4 g-3">
                <div class="col-auto">
                  <h3>Total sells</h3>
                  <p class="text-body-tertiary lh-sm mb-0">Payment received across all channels</p>
                </div>
                <div class="col-8 col-sm-4">
                  <select class="form-select form-select-sm" id="select-gross-revenue-month">
                    <option>Mar 1 - 31, 2022</option>
                    <option>April 1 - 30, 2022</option>
                    <option>May 1 - 31, 2022</option>
                  </select>
                </div>
              </div>
              <div class="echart-total-sales-chart" style="min-height:320px;width:100%"></div>
            </div>
            <div class="col-xxl-6">
              <div class="mx-xxl-0">
                <h3>Project: zero Roadmap</h3>
                <p class="text-body-tertiary">Phase 2 is now ongoing</p>
                <div class="gantt-zero-roadmap">
                  <div class="row g-2 flex-between-center mb-3">
                    <div class="col-12 col-sm-auto">
                      <div class="d-flex">
                        <div class="d-flex align-items-end me-3">
                          <label class="form-check-label mb-0 me-2 lh-1 text-body" for="progress">Progress</label>
                          <div class="form-check form-switch min-h-auto mb-0">
                            <input class="form-check-input" id="progress" type="checkbox" checked="" data-gantt-progress="data-gantt-progress" />
                          </div>
                        </div>
                        <div class="d-flex align-items-end flex-1">
                          <label class="form-check-label mb-0 me-2 lh-1 text-body" for="links">Links</label>
                          <div class="form-check form-switch min-h-auto flex-1 mb-0">
                            <input class="form-check-input" id="links" type="checkbox" checked="" data-gantt-links="data-gantt-links" />
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12 col-sm-auto">
                      <div class="btn-group" role="group" data-gantt-scale="data-gantt-scale">
                        <input class="btn-check" id="weekView" type="radio" name="scaleView" value="week" checked="" />
                        <label class="btn btn-phoenix-secondary bg-body-highlight-hover fs-10 py-1 mb-0" for="weekView">Week</label>
                        <input class="btn-check" id="monthView" type="radio" name="scaleView" value="month" />
                        <label class="btn btn-phoenix-secondary bg-body-highlight-hover fs-10 py-1 mb-0" for="monthView">Month</label>
                        <input class="btn-check" id="yearView" type="radio" name="scaleView" value="year" />
                        <label class="btn btn-phoenix-secondary bg-body-highlight-hover fs-10 py-1 mb-0" for="yearView">Year</label>
                      </div>
                    </div>
                  </div>
                  <div class="gantt-zero-roadmap-chart"></div>
                </div>
              </div>
            </div>
          </div>
          <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-6 pb-3 mt-6">
            <div class="row">
              <div class="col-12 col-xl-7 col-xxl-6">
                <div class="row g-3 mb-3">
                  <div class="col-12 col-md-6">
                    <h3 class="text-body-emphasis text-nowrap">Issues Discovered</h3>
                    <p class="text-body-tertiary mb-md-7">Newly found and yet to be solved</p>
                    <div class="d-flex align-items-center justify-content-between">
                      <p class="mb-0 fw-bold">Issue type </p>
                      <p class="mb-0 fs-9">Total count <span class="fw-bold">257</span></p>
                    </div>
                    <hr class="bg-body-secondary mb-2 mt-2" />
                    <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-info-light bullet-item me-2"></span>
                      <p class="mb-0 fw-semibold text-body lh-sm flex-1">Product design</p>
                      <h5 class="mb-0 text-body">78</h5>
                    </div>
                    <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-warning-light bullet-item me-2"></span>
                      <p class="mb-0 fw-semibold text-body lh-sm flex-1">Development</p>
                      <h5 class="mb-0 text-body">63</h5>
                    </div>
                    <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-danger-light bullet-item me-2"></span>
                      <p class="mb-0 fw-semibold text-body lh-sm flex-1">QA &amp; Testing</p>
                      <h5 class="mb-0 text-body">56</h5>
                    </div>
                    <div class="d-flex align-items-center mb-1"><span class="d-inline-block bg-success-light bullet-item me-2"></span>
                      <p class="mb-0 fw-semibold text-body lh-sm flex-1">Customer queries</p>
                      <h5 class="mb-0 text-body">36</h5>
                    </div>
                    <div class="d-flex align-items-center"><span class="d-inline-block bg-primary bullet-item me-2"></span>
                      <p class="mb-0 fw-semibold text-body lh-sm flex-1">R &amp; D</p>
                      <h5 class="mb-0 text-body">24</h5>
                    </div>
                    <button class="btn btn-outline-primary mt-5">See Details<span class="fas fa-angle-right ms-2 fs-10 text-center"></span></button>
                  </div>
                  <div class="col-12 col-md-6">
                    <div class="position-relative mb-sm-4 mb-xl-0">
                      <div class="echart-issue-chart" style="min-height:390px;width:100%"></div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-xl-5 col-xxl-6">
                <h3>Project: eleven Progress</h3>
                <p class="text-body-tertiary mb-0 mb-xl-3">Deadline &amp; progress</p>
                <div class="echart-zero-burnout-chart" style="min-height:320px;width:100%"></div>
              </div>
            </div>
          </div>
          <div class="mx-lg-n4">
            <div class="row g-3 pt-3">
              <div class="col-xl-5">
                <div class="card h-100">
                  <div class="card-body">
                    <h3>Lead Conversion</h3>
                    <p class="text-body-tertiary mb-0">Stages of deals &amp; conversion</p>
                    <div class="echart-lead-conversion" style="min-height: 250px;"></div>
                  </div>
                </div>
              </div>
              <div class="col-xl-7">
                <div class="card h-100">
                  <div class="card-body">
                    <h3>Revenue Target</h3>
                    <p class="text-body-tertiary">Country-wise target fulfilment</p>
                    <div class="echart-revenue-target-conversion" style="min-height: 230px;"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="mx-n4 px-4 mx-lg-n6 px-lg-6 bg-body-emphasis pt-6 pb-3 mt-3">
            <div class="row gx-6">
              <div class="col-12 col-md-6 col-lg-12 col-xl-6 mb-5 mb-md-3 mb-lg-5 mb-xl-2 mb-xxl-3">
                <div class="scrollbar">
                  <h3>Email Campaign Reports</h3>
                  <p class="text-body-tertiary">Paid and Verified for each piece of content</p>
                  <div class="echart-email-campaign-report echart-contacts-width"></div>
                </div>
              </div>
              <div class="col-12 col-md-6 col-lg-12 col-xl-6 mb-1 mb-sm-0">
                <div class="row align-itms-center mb-5 mb-sm-2 mb-md-4">
                  <div class="col-sm-8 col-md-12 col-lg-8 col-xl-12 col-xxl-8 mb-xl-2 mb-xxl-0">
                    <h3> Marketing Campaign Report</h3>
                    <p class="text-body-tertiary mb-lg-0">According to the sales data.</p>
                  </div>
                  <div class="col-sm-4 col-md-12 col-lg-4 col-xl-12 col-xxl-4">
                    <select class="form-select form-select">
                      <option>Ally Aagaard</option>
                      <option>Alec Haag</option>
                      <option>Aagaard</option>
                    </select>
                  </div>
                </div>
                <div class="row g-3 align-items-center">
                  <div class="col-sm-8 col-md-12 col-lg-8 col-xl-12 col-xxl-8">
                    <div class="echart-social-marketing-radar" style="min-height:320px; width:100%"></div>
                  </div>
                  <div class="col-sm-4 col-md-12 col-lg-4 col-xl-12 col-xxl-4 d-flex justify-content-end-xxl mt-0">
                    <div class="d-flex flex-1 justify-content-center d-sm-block d-md-flex d-lg-block d-xl-flex d-xxl-block">
                      <div class="mb-4 me-6 me-sm-0 me-md-6 me-lg-0 me-xl-6 me-xxl-0">
                        <div class="d-flex align-items-center mb-2">
                          <h4 class="mb-0">15,000</h4><span class="badge badge-phoenix badge-phoenix-primary ms-2">+30.63%</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="fa-solid fa-circle text-warning-light me-2"></div>
                          <h6 class="mb-0">Online Campaign</h6>
                        </div>
                      </div>
                      <div>
                        <div class="d-flex align-items-center mb-2">
                          <h4 class="mb-0">5,000</h4><span class="badge badge-phoenix badge-phoenix-danger ms-2">+13.52%</span>
                        </div>
                        <div class="d-flex align-items-center">
                          <div class="fa-solid fa-circle text-primary-light me-2"></div>
                          <h6 class="mb-0">Offline Campaign</h6>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row g-6 mt-0">
            <div class="col-12 col-md-6">
              <div class="row justify-content-between mb-4">
                <div class="col-12">
                  <h3>Sales Trends</h3>
                  <p class="text-body-tertiary">Updated inventory &amp; the sales report.</p>
                </div>
                <div class="col-12 d-flex">
                  <div class="d-flex">
                    <div class="fa-solid fa-circle text-info-light me-2"></div>
                    <h6 class="mb-0 me-3 lh-base">Profit</h6>
                  </div>
                  <div class="d-flex">
                    <div class="fa-solid fa-circle text-primary-lighter me-2"></div>
                    <h6 class="mb-0 lh-base">Revenue</h6>
                  </div>
                </div>
              </div>
              <div class="echart-sales-trends" style="height:270px; width:100%"></div>
            </div>
            <div class="col-12 col-md-6">
              <div class="row justify-content-between mb-4">
                <div class="col-auto">
                  <h3>Call Campaign Reports</h3>
                  <p class="text-body-tertiary">All call campaigns succeeded.</p>
                </div>
                <div class="col-12 d-flex">
                  <div class="d-flex">
                    <div class="fa-solid fa-circle text-primary me-2"></div>
                    <h6 class="mb-0 me-3 lh-base">Campaign</h6>
                  </div>
                </div>
              </div>
              <div class="echart-call-campaign" style="height:290px; width:100%"></div>
            </div>
          </div>

        </div>



@endsection

@push('script')

<script src="{{asset('fnx/vendors/echarts/echarts.min.js')}}"></script>
<script src="{{asset('fnx/assets/js/crm-dashboard.js')}}"></script>

@endpush