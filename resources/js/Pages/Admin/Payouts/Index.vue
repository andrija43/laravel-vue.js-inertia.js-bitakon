<template>
    <HeaderSegment
       :title="trans('Payout Requests')"
       :segments="segments"
       :buttons="buttons"
       />
    <div class="container-fluid mt--6">
       <div class="row">
          <div class="col-xl-3 col-md-6">
             <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                   <div class="row">
                      <div class="col">
                         <h5
                            class="card-title text-uppercase text-muted mb-0"
                            >
                            {{ trans("Total Payouts") }}
                         </h5>
                         <span
                            class="h2 font-weight-bold mb-0"
                            >
                         {{ data.total_payouts }}                                   
                         </span>
                      </div>
                      <div class="col-auto">
                         <div
                            class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                            >
                            <i class="fi fi-rs-boxes mt-1"></i>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-xl-3 col-md-6">
             <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                   <div class="row">
                      <div class="col">
                         <Link href="/admin/payouts?status=pending">
                         <h5
                            class="card-title text-uppercase text-muted mb-0"
                            >
                            {{ trans("Pending Payouts") }}
                         </h5>
                         <span
                            class="h2 font-weight-bold mb-0 mt-1"
                            id="pending-orders"
                            >
                         {{ data.total_pending }}
                         </span>
                         </Link>
                      </div>
                      <div class="col-auto">
                         <div
                            class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                            >
                            <i class="fi fi-rs-box-alt mt-2"></i>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-xl-3 col-md-6">
             <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                   <div class="row">
                      <div class="col">
                         <Link href="/admin/payouts?status=approved">
                         <h5
                            class="card-title text-uppercase text-muted mb-0"
                            >
                            {{ trans("Total Approved") }}
                         </h5>
                         <span
                            class="h2 font-weight-bold mb-0"
                            id="open-support"
                            >
                         {{ data.total_approved }}
                         </span>
                         </Link>
                      </div>
                      <div class="col-auto">
                         <div
                            class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                            >
                            <i class="ni ni-calendar-grid-58"></i>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
          <div class="col-xl-3 col-md-6">
             <div class="card card-stats">
                <!-- Card body -->
                <div class="card-body">
                   <div class="row">
                      <div class="col">
                         <Link href="/admin/payouts?status=rejected">
                         <h5
                            class="card-title text-uppercase text-muted mb-0"
                            >
                            {{ trans("Total Rejected") }}
                         </h5>
                         <span
                            class="h2 font-weight-bold mb-0"
                            id="active-customers"
                            >
                         {{ data.total_rejected }}
                         </span>
                         </Link>
                      </div>
                      <div class="col-auto">
                         <div
                            class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                            >
                            <i class="fi fi-rs-users-alt mt-1"></i>
                         </div>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <div class="row">
          <div class="col">
             <div class="card">
                <!-- Card header -->
                <div class="card-header border-0">
                   <h3 class="mb-0">{{ trans("Payouts") }}</h3>
                   <form
                      action=""
                      class="card-header-form"
                      method="GET"
                      @submit.prevent="filterData.get('/admin/payouts')"
                      >
                      <div class="input-group">
                         <input
                            type="text"
                            name="search"
                            v-model="filterData.search"
                            class="form-control"
                            placeholder="Search......"
                            />
                         <select
                            class="form-control"
                            name="type"
                            v-model="filterData.type"
                            >
                            <option value="email">
                               {{ trans("User Email") }}
                            </option>
                            <option value="invoice_no">
                               {{ trans("Invoice No") }}
                            </option>
                         </select>
                         <div class="input-group-btn">
                            <button class="btn btn-neutral btn-icon">
                            <i class="fas fa-search"></i>
                            </button>
                         </div>
                      </div>
                   </form>
                </div>
                <!-- Light table -->
                <div class="table-responsive">
                   <table class="table align-items-center table-flush">
                      <thead class="thead-light">
                         <tr>
                            <th class="col-1">
                               {{ trans("Invoice No") }}
                            </th>
                            <th class="col-2">
                               {{ trans("Amount") }}
                            </th>
                            <th class="col-2">
                               {{ trans("Gateway") }}
                            </th>
                            <th class="col-2">
                               {{ trans("User") }}
                            </th>
                            <th class="col-1">{{ trans("Status") }}</th>
                            <th class="col-2 text-left">
                               {{ trans("Created At") }}
                            </th>
                            <th class="col-1 text-left">
                               {{ trans("View") }}
                            </th>
                         </tr>
                      </thead>
                      <tbody class="list" v-if="data.payouts.data.length != 0">
                         <tr
                            v-for="payout in data.payouts.data"
                            :key="payout.id"
                            >
                            <td class="text-center">
                               <Link
                                  :href="route('admin.payouts.show',payout.id)"
                                  :class="text - dark"
                                  >
                               {{ payout.invoice_no }}
                               </Link>
                            </td>
                            <td class="text-left">
                               {{ payout.amount_with_currency }}
                            </td>
                            <td class="text-left">
                               {{ payout.method.name || '' }}
                            </td>
                            <td class="text-left">
                               <Link :href="route('admin.customer.show', payout.user_id)">
                               {{ payout.user.name || '' }}
                               </Link>
                            </td>
                            <td class="text-left">
                               <span class="badge" :class="payout.status == 'pending' ? 'badge-warning' : (payout.status == 'completed' ? 'badge-success' : 'badge-danger' ) "> {{ payout.status }}</span>
                            </td>
                            <td class="text-left">
                               {{ payout.user.created_at_date }}
                            </td>
                            <td >
                               <Link
                                  :href="route('admin.payouts.show',payout.id)"
                                  class="btn btn-neutral btn-sm"
                                  >
                               {{ trans('View') }}
                               </Link>
                            </td>
                         </tr>
                      </tbody>
                   </table>
                   <div
                      class="text-center mt-2"
                      v-if="data.payouts.data.length == 0"
                      >
                      <div class="alert bg-gradient-primary text-white">
                         <span class="text-left">{{
                         trans("!Opps no orders found")
                         }}</span>
                      </div>
                   </div>
                </div>
                <div class="card-footer py-4">
                   <Paginate
                      :links="data.payouts.links"
                      :currentPage="data.payouts.current_page"
                      :from="data.payouts.from"
                      :lastPage="data.payouts.last_page"
                      :lastPageUrl="data.payouts.last_page_url"
                      :nextpageurl="data.payouts.next_page_url"
                      :perPage="data.payouts.per_page"
                      :prevPageUrl="data.payouts.prev_page_url"
                      :to="data.payouts.to"
                      :total="data.payouts.total"
                      />
                </div>
             </div>
          </div>
       </div>
    </div>
 </template>
 <script setup>
 "use strict";
    import AdminLayout from "@/Pages/Admin/Layout/App.vue";
    import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
    import { useForm } from "@inertiajs/vue3";
    defineOptions({ layout: AdminLayout });
    const props = defineProps(["segments", "buttons", "data", "orders","request"]);
    const filterData = useForm({
        search: props.request.search,
        type: props.type || 'email',
    });
 </script>