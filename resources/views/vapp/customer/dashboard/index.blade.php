@extends('vapp.customer.layout.customer_template')
@section('main')

<!-- ===============================================-->
<!--    Main Content-->
<!-- ===============================================-->
<div class="row gy-3 mb-4 justify-content-between">
          <div class="col-xxl-6">
            <h2 class="mb-2 text-body-emphasis">CRM Dashboard</h2>
            <h5 class="text-body-tertiary fw-semibold mb-4">Check your business growth in one place</h5>
            <div class="row g-3 mb-3">
              <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex d-sm-block justify-content-between">
                      <div class="border-bottom-sm border-translucent mb-sm-4">
                        <div class="d-flex align-items-center">
                          <div class="d-flex align-items-center icon-wrapper-sm shadow-primary-100" style="transform: rotate(-7.45deg);"><span class="fa-solid fa-phone-alt text-primary fs-7 z-1 ms-2"></span></div>
                          <p class="text-body-tertiary fs-9 mb-0 ms-2 mt-3">Outgoing call</p>
                        </div>
                        <p class="text-primary mt-2 fs-6 fw-bold mb-0 mb-sm-4">3 <span class="fs-8 text-body lh-lg">Leads Today</span></p>
                      </div>
                      <div class="d-flex flex-column justify-content-center flex-between-end d-sm-block text-end text-sm-start"><span class="badge badge-phoenix badge-phoenix-success fs-10 mb-2">+24.5%</span>
                        <p class="mb-0 fs-9 text-body-tertiary">Than Yesterday</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-4">
                <div class="card h-100">
                  <div class="card-body">
                    <div class="d-flex d-sm-block justify-content-between">
                      <div class="border-bottom-sm border-translucent mb-sm-4">
                        <div class="d-flex align-items-center">
                          <div class="d-flex align-items-center icon-wrapper-sm shadow-info-100" style="transform: rotate(-7.45deg);"><span class="fa-solid fa-calendar text-info fs-7 z-1 ms-2"></span></div>
                          <p class="text-body-tertiary fs-9 mb-0 ms-2 mt-3">Outgoing meeting</p>
                        </div>
                        <p class="text-info mt-2 fs-6 fw-bold mb-0 mb-sm-4">12 <span class="fs-8 text-body lh-lg">This Week</span></p>
                      </div>
                      <div class="d-flex flex-column justify-content-center flex-between-end d-sm-block text-end text-sm-start"><span class="badge badge-phoenix badge-phoenix-warning fs-10 mb-2">+24.5%</span>
                        <p class="mb-0 fs-9 text-body-tertiary">Than last week</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-md-4 col-xl-6 col-xxl-4 gy-5 gy-md-3">
                <div class="border-bottom border-translucent">
                  <h5 class="pb-4 border-bottom border-translucent">Top 5 Lead Sources</h5>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-transparent list-group-crm fw-bold text-body fs-9 py-2">
                      <div class="d-flex justify-content-between"><span class="fw-normal fs-9 mx-1"> <span class="fw-bold">1. </span>None </span><span>(65)</span></div>
                    </li>
                    <li class="list-group-item bg-transparent list-group-crm fw-bold text-body fs-9 py-2">
                      <div class="d-flex justify-content-between"><span class="fw-normal mx-1"><span class="fw-bold">2. </span>Online Store</span><span>(74)</span></div>
                    </li>
                    <li class="list-group-item bg-transparent list-group-crm fw-bold text-body fs-9 py-2">
                      <div class="d-flex justify-content-between"><span class="fw-normal fs-9 mx-1"><span class="fw-bold">3.</span> Advertisement</span><span>(32)</span></div>
                    </li>
                    <li class="list-group-item bg-transparent list-group-crm fw-bold text-body fs-9 py-2">
                      <div class="d-flex justify-content-between"><span class="fw-normal fs-9 mx-1"><span class="fw-bold">4.</span> Seminar Partner</span><span>(25)</span></div>
                    </li>
                    <li class="list-group-item bg-transparent list-group-crm fw-bold text-body fs-9 py-2">
                      <div class="d-flex justify-content-between"><span class="fw-normal fs-9 mx-1"> <span class="fw-bold">5.</span> Partner</span><span>(23)</span></div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xxl-6 mb-6">
            <h3>Contacts Created</h3>
            <p class="text-body-tertiary mb-1">Payment received across all channels</p>
            <div class="echart-contacts-created" style="min-height:270px; width:100%"></div>
          </div>
          <div class="col-12 col-xxl-6 mb-3 mb-sm-0">
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
          <div class="col-12 col-xxl-6 mb-8">
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
          <div class="col-12 col-xxl-6">
            <div class="row align-items-start justify-content-between mb-4 g-3">
              <div class="col-auto">
                <h3>Ad Clicks</h3>
                <p class="text-body-tertiary lh-sm mb-0">Check effectiveness of your ads</p>
              </div>
              <div class="col-12 col-sm-4">
                <select class="form-select form-select-sm" id="select-ad-clicks-month">
                  <option>Mar 1 - 31, 2022</option>
                  <option>April 1 - 30, 2022</option>
                  <option>May 1 - 31, 2022</option>
                </select>
              </div>
            </div>
            <div class="echart-add-clicks-chart" style="min-height:385px;width:100%"></div>
          </div>
          <div class="col-12 col-xxl-6 mb-6 gy-0 gy-xxl-3">
            <div class="row align-items-start justify-content-between mb-4 g-3">
              <div class="col-auto">
                <h3>Deal Forecast<span class="fw-semibold">- $90,303</span></h3>
                <p class="text-body-tertiary mb-1">Show what you offer here</p>
              </div>
              <div class="col-12 col-sm-4">
                <select class="form-select form-select-sm" id="select-ad-forcast-month">
                  <option>Mar 1 - 31, 2022</option>
                  <option>April 1 - 30, 2022</option>
                  <option>May 1 - 31, 2022</option>
                </select>
              </div>
            </div>
            <div class="w-100">
              <div class="d-flex flex-start">
                <p class="mb-2 text-body-tertiary fw-semibold fs-9" style="width: 20.72%">$21.0k</p>
                <p class="mb-2 text-body-tertiary fw-semibold fs-9" style="width: 35.76%">$3.4k</p>
                <p class="mb-2 text-body-tertiary fw-semibold fs-9" style="width: 25.38%">$15.1k</p>
                <p class="mb-2 text-body-tertiary fw-semibold fs-9" style="width: 25.14%">$4.6k</p>
              </div>
              <div class="progress mb-3 rounded-3" style="height: 10px;">
                <div class="progress-bar border-end border-2 bg-primary-dark" role="progressbar" style="width: 20.72%" aria-valuenow="20.72" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" title="Appointment"></div>
                <div class="progress-bar border-end border-2" role="progressbar" style="width: 35.76%" aria-valuenow="35.76" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" title="Qualified"></div>
                <div class="progress-bar bg-success border-end border-2" role="progressbar" style="width: 25.38%" aria-valuenow="25.38" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" title="Closed Won"></div>
                <div class="progress-bar bg-info" role="progressbar" style="width: 25.14%" aria-valuenow="25.14" aria-valuemin="0" aria-valuemax="100" data-bs-toggle="tooltip" data-bs-placement="top" title="Contact Sent"></div>
              </div>
            </div>
            <h4 class="mt-4 mb-3">Deal Forecast by Owner </h4>
            <div class="border-top border-bottom-0" id="dealForecastTable" data-list='{"valueNames":["contact","appointment","qualified","closed-won","contact-sent"],"page":5}'>
              <div class="table-responsive scrollbar">
                <table class="table fs-9 mb-0">
                  <thead>
                    <tr>
                      <th class="sort border-end border-translucent white-space-nowrap align-middle ps-0 text-uppercase text-body-tertiary" scope="col" data-sort="contact" style="width:15%; min-width:100px">Contact</th>
                      <th class="sort border-end border-translucent align-middle text-end px-3 text-uppercase text-body-tertiary" scope="col" data-sort="appointment" style="width:15%; min-width:95px">
                        <div class="d-inline-flex flex-center"><span class="fa-solid fa-square fs-11 text-primary me-2" data-fa-transform="up-2"></span><span class="mb-0 fs-9">Appointment</span></div>
                      </th>
                      <th class="sort border-end border-translucent align-middle text-end px-3 text-uppercase text-body-tertiary" scope="col" data-sort="qualified" style="width:20%; min-width:100px">
                        <div class="d-inline-flex flex-center"><span class="fa-solid fa-square fs-11 text-primary-light me-2" data-fa-transform="up-2"></span><span class="mb-0 fs-9">Qualified</span></div>
                      </th>
                      <th class="sort border-end border-translucent align-middle text-end px-3 text-uppercase text-body-tertiary" scope="col" data-sort="closed-won" style="width:20%; min-width:100px">
                        <div class="d-inline-flex flex-center"><span class="fa-solid fa-square fs-11 text-success me-2" data-fa-transform="up-2"></span><span class="mb-0 fs-9">Closed Won</span></div>
                      </th>
                      <th class="sort align-middle text-end ps-3 text-uppercase text-body-tertiary" scope="col" data-sort="contact-sent" style="width:20%; min-width:100px">
                        <div class="d-inline-flex flex-center"><span class="fa-solid fa-square fs-11 text-info me-2" data-fa-transform="up-2"></span><span class="mb-0 fs-9">Contact Sent</span></div>
                      </th>
                    </tr>
                  </thead>
                  <tbody class="list" id="table-deal-forecast-body">
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="contact border-end border-translucent align-middle white-space-nowrap py-2 ps-0 px-3"><a class="fw-semibold" href="#!">Carrie Anne</a></td>
                      <td class="appointment border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">1000</td>
                      <td class="qualified border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$1256</td>
                      <td class="closed-won border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$1200</td>
                      <td class="contact-sent border-end-0 align-middle white-space-nowrap text-end fw-semibold text-body ps-3 py-2">$1200</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="contact border-end border-translucent align-middle white-space-nowrap py-2 ps-0 px-3"><a class="fw-semibold" href="#!">Milind Mikuja</a></td>
                      <td class="appointment border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">558</td>
                      <td class="qualified border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$2531</td>
                      <td class="closed-won border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$2200</td>
                      <td class="contact-sent border-end-0 align-middle white-space-nowrap text-end fw-semibold text-body ps-3 py-2">$2200</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="contact border-end border-translucent align-middle white-space-nowrap py-2 ps-0 px-3"><a class="fw-semibold" href="#!">Stanley Drinkwater</a></td>
                      <td class="appointment border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">1100</td>
                      <td class="qualified border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$100</td>
                      <td class="closed-won border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$100</td>
                      <td class="contact-sent border-end-0 align-middle white-space-nowrap text-end fw-semibold text-body ps-3 py-2">$100</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="contact border-end border-translucent align-middle white-space-nowrap py-2 ps-0 px-3"><a class="fw-semibold" href="#!">Josef Stravinsky</a></td>
                      <td class="appointment border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">856</td>
                      <td class="qualified border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$326</td>
                      <td class="closed-won border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$265</td>
                      <td class="contact-sent border-end-0 align-middle white-space-nowrap text-end fw-semibold text-body ps-3 py-2">$265</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="contact border-end border-translucent align-middle white-space-nowrap py-2 ps-0 px-3"><a class="fw-semibold" href="#!">Roy Anderson</a></td>
                      <td class="appointment border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">1200</td>
                      <td class="qualified border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$1452</td>
                      <td class="closed-won border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$865</td>
                      <td class="contact-sent border-end-0 align-middle white-space-nowrap text-end fw-semibold text-body ps-3 py-2">$865</td>
                    </tr>
                    <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                      <td class="contact border-end border-translucent align-middle white-space-nowrap py-2 ps-0 px-3"><a class="fw-semibold" href="#!">Oscar Wilde</a></td>
                      <td class="appointment border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">1020</td>
                      <td class="qualified border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$950</td>
                      <td class="closed-won border-end border-translucent align-middle white-space-nowrap text-end fw-semibold text-body py-2 px-3">$1000</td>
                      <td class="contact-sent border-end-0 align-middle white-space-nowrap text-end fw-semibold text-body ps-3 py-2">$800</td>
                    </tr>
                  </tbody>
                  <tr class="hover-actions-trigger btn-reveal-trigger position-static">
                    <td class="align-middle border-bottom-0 border-end border-translucent white-space-nowrap text-end fw-bold text-body-emphasis pt-2 lh-sm pb-0 px-3"> </td>
                    <td class="align-middle border-bottom-0 border-end border-translucent white-space-nowrap text-end fw-bold text-body-emphasis pt-2 lh-sm pb-0 px-3">4,744</td>
                    <td class="align-middle border-bottom-0 border-end border-translucent white-space-nowrap text-end fw-bold text-body-emphasis pt-2 lh-sm pb-0 px-3">$5,665</td>
                    <td class="align-middle border-bottom-0 border-end border-translucent white-space-nowrap text-end fw-bold text-body-emphasis pt-2 lh-sm pb-0 px-3">$4630</td>
                    <td class="border-bottom-0 align-middle white-space-nowrap text-end fw-bold text-body-emphasis pt-2 pb-0 ps-3">$4630</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="mx-lg-n4">
          <div class="row g-3 mb-9 mt-n7">
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

@endsection

@push('script')

<script src="{{asset('fnx/vendors/echarts/echarts.min.js')}}"></script>
<script src="{{asset('fnx/assets/js/crm-dashboard.js')}}"></script>

@endpush