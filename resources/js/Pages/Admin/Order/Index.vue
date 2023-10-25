<template>
    <HeaderSegment
        :title="'Orders List'"
        :segments="segments"
        :buttons="buttons"
    />
    <div class="container-fluid mt--6">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row d-flex justify-content-between flex-wrap">
                    <div class="col-sm-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span
                                            class="h2 font-weight-bold mb-0 total-transfers"
                                            id="total-device"
                                        >
                                            {{ totalOrders }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div
                                            class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                                        >
                                            <i class="fi fi-rs-boxes mt-2"></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm"></p>
                                <h5 class="card-title text-muted mb-0">
                                    {{ trans("Total Orders") }}
                                </h5>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span
                                            class="h2 font-weight-bold mb-0 total-transfers"
                                            id="total-active"
                                        >
                                            {{ totalCompleteOrders }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div
                                            class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                                        >
                                            <i
                                                class="fi fi-rs-box-check mt-2"
                                            ></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm"></p>
                                <h5 class="card-title text-muted mb-0">
                                    {{ trans("Completed Orders") }}
                                </h5>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span
                                            class="h2 font-weight-bold mb-0 completed-transfers"
                                            id="total-inactive"
                                        >
                                            {{ totalPendingOrders }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div
                                            class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                                        >
                                            <i
                                                class="fi fi-rs-calendar-clock mt-2"
                                            ></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm"></p>
                                <h5 class="card-title text-muted mb-0">
                                    {{ trans("Pending Orders") }}
                                </h5>
                                <p></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card card-stats">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <span
                                            class="h2 font-weight-bold mb-0 completed-transfers"
                                            id="total-inactive"
                                        >
                                            {{ totalDeclinedOrders }}
                                        </span>
                                    </div>
                                    <div class="col-auto">
                                        <div
                                            class="icon icon-shape bg-gradient-primary text-white rounded-circle shadow"
                                        >
                                            <i
                                                class="fi fi-rs-remove-folder mt-2"
                                            ></i>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-3 mb-0 text-sm"></p>
                                <h5 class="card-title text-muted mb-0">
                                    {{ trans("Rejected Orders") }}
                                </h5>
                                <p></p>
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
                        <h3 class="mb-0">{{ trans("Orders") }}</h3>
                        <form
                            action=""
                            class="card-header-form"
                            method="GET"
                            @submit.prevent="filterData.get('/admin/order')"
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
                                        {{ trans("Order No") }}
                                    </th>
                                    <th class="col-2">
                                        {{ trans("Amount") }}
                                        
                                    </th>
                                    <th class="col-2">
                                        {{ trans("Tax") }}
                                    </th>
                                    <th class="col-2">
                                        {{ trans("Payment Mode") }}
                                    </th>
                                    <th class="col-1">{{ trans("Total Items") }}</th>
                                    <th class="col-1">{{ trans("Status") }}</th>
                                    <th class="col-1">{{ trans("User") }}</th>
                                    <th class="col-1 text-left">
                                        {{ trans("Created At") }}
                                    </th>
                                    <th class="col-1 text-left">
                                        {{ trans("View") }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="list" v-if="orders.data.length != 0">
                                <tr
                                    v-for="order in orders.data"
                                    :key="order.id"
                                >
                                    <td class="text-center">
                                        <Link
                                            :href="'/admin/order/' + order.id"
                                            :class="text - dark"
                                        >
                                            {{ order.invoice_no }}
                                        </Link>
                                    </td>
                                    <td>
                                        {{ order.amountFormat }}
                                    </td>
                                    <td class="text-left">
                                        {{ order.taxFormat }}
                                    </td>
                                    <td class="text-center">
                                        {{ order.gateway.name }}
                                    </td>
                                    <td class="text-center">
                                        {{ order.items_count }}
                                    </td>

                                   
                                    <td>
                                        <span
                                            :class="
                                                order.status == 2
                                                    ? 'badge badge-warning'
                                                    : order.status == 1
                                                    ? 'badge badge-success'
                                                    : 'badge badge-danger'
                                            "
                                        >
                                            {{
                                                trans(
                                                    order.status == 2
                                                        ? "pending"
                                                        : order.status == 1
                                                        ? "approved"
                                                        : "declined"
                                                )
                                            }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <Link
                                            :href="
                                                '/admin/customer/' +
                                                order.user_id
                                            "
                                            :class="text - dark"
                                        >
                                            {{ order.user.name }}
                                        </Link>
                                    </td>
                                    <td class="text-center">
                                        {{ order.created_at_diff }}
                                    </td>
                                    <td>
                                        <Link
                                            :href="'/admin/order/' + order.id"
                                            class="btn btn-neutral btn-sm"
                                            >{{ trans("View") }}</Link
                                        >
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div
                            class="text-center mt-2"
                            v-if="orders.data.length == 0"
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
                            :links="orders.links"
                            :currentPage="orders.current_page"
                            :from="orders.from"
                            :lastPage="orders.last_page"
                            :lastPageUrl="orders.last_page_url"
                            :nextpageurl="orders.next_page_url"
                            :perPage="orders.per_page"
                            :prevPageUrl="orders.prev_page_url"
                            :to="orders.to"
                            :total="orders.total"
                        />
                    </div>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="addRecord"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form
                        method="POST"
                        @submit.prevent="
                            updateOption(invoiceFrom, 'invoice_data')
                        "
                    >
                        <div class="modal-header">
                            <h3>{{ trans("Edit Invoice Information") }}</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ trans("Company Name") }}</label>
                                <input
                                    type="text"
                                    v-model="invoiceFrom.company_name"
                                    class="form-control"
                                    required=""
                                />
                            </div>
                            <div class="form-group">
                                <label>{{ trans("Company Address") }}</label>
                                <input
                                    type="text"
                                    name="data[address]"
                                    v-model="invoiceFrom.address"
                                    class="form-control"
                                    required=""
                                />
                            </div>
                            <div class="form-group">
                                <label>{{ trans("Company City") }}</label>
                                <input
                                    type="text"
                                    name="data[city]"
                                    v-model="invoiceFrom.city"
                                    class="form-control"
                                    required=""
                                />
                            </div>
                            <div class="form-group">
                                <label>{{ trans("Post Code") }}</label>
                                <input
                                    type="text"
                                    name="data[post_code]"
                                    v-model="invoiceFrom.post_code"
                                    class="form-control"
                                    required=""
                                />
                            </div>
                            <div class="form-group">
                                <label>{{ trans("Country") }}</label>
                                <input
                                    type="text"
                                    name="data[country]"
                                    v-model="invoiceFrom.country"
                                    class="form-control"
                                    required=""
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-neutral"
                                data-dismiss="modal"
                            >
                                {{ trans("Close") }}
                            </button>
                            <button
                                type="submit"
                                :disabled="isProcessing"
                                class="btn btn-neutral col-4 float-left submit-button"
                            >
                                {{ trans("Update") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="currency"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form
                        method="POST"
                        @submit.prevent="
                            updateOption(currencyFrom, 'base_currency')
                        "
                    >
                        <div class="modal-header">
                            <h3>{{ trans("Currency Settings") }}</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ trans("Currency Name") }}</label>
                                <input
                                    type="text"
                                    name="data[name]"
                                    v-model="currencyFrom.name"
                                    class="form-control"
                                    required=""
                                />
                            </div>
                            <div class="form-group">
                                <label>{{ trans("Currency Icon") }}</label>
                                <input
                                    type="text"
                                    name="data[icon]"
                                    v-model="currencyFrom.icon"
                                    class="form-control"
                                    required=""
                                />
                            </div>
                            <div class="form-group">
                                <label>{{ trans("Currency Icon") }}</label>
                                <select
                                    class="form-control"
                                    name="data[position]"
                                    v-model="currencyFrom.position"
                                >
                                    <option value="left">
                                        {{ trans("Left") }}
                                    </option>
                                    <option value="right">
                                        {{ trans("Right") }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-neutral"
                                data-dismiss="modal"
                            >
                                {{ trans("Close") }}
                            </button>
                            <button
                                type="submit"
                                :disabled="isProcessing"
                                class="btn btn-neutral col-4 float-left submit-button"
                            >
                                {{ trans("Update") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="taxModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form
                        method="POST"
                        @submit.prevent="updateOption(taxFrom, 'tax')"
                    >
                        <div class="modal-header">
                            <h3>{{ trans("Tax Settings") }}</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ trans("Tax Amount") }}</label>
                                <input
                                    type="number"
                                    step="any"
                                    name="data"
                                    v-model="taxFrom"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-neutral"
                                data-dismiss="modal"
                            >
                                {{ trans("Close") }}
                            </button>
                            <button
                                type="submit"
                                :disabled="isProcessing"
                                class="btn btn-neutral col-4 float-left submit-button"
                            >
                                {{ trans("Update") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div
            class="modal fade"
            id="commision"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <form
                        method="POST"
                        @submit.prevent="updateOption(commisionFrom, 'author_fee')"
                    >
                        <div class="modal-header">
                            <h3>{{ trans("Author Fee") }}</h3>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>{{ trans("Add percentage for each orders") }}</label>
                                <input
                                    type="number"
                                    step="any"
                                    name="data"
                                    v-model="commisionFrom"
                                    class="form-control"
                                    required
                                />
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button
                                type="button"
                                class="btn btn-neutral"
                                data-dismiss="modal"
                            >
                                {{ trans("Close") }}
                            </button>
                            <button
                                type="submit"
                                :disabled="isProcessing"
                                class="btn btn-neutral col-4 float-left submit-button"
                            >
                                {{ trans("Update") }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
"use strict";
import AdminLayout from "@/Pages/Admin/Layout/App.vue";
import HeaderSegment from "@/Pages/Admin/Layout/HeaderSegment.vue";
import { useForm, router } from "@inertiajs/vue3";
import Paginate from "@/Components/Paginate.vue";
import { createToast } from "mosha-vue-toastify";
import { ref } from "vue";
defineOptions({ layout: AdminLayout });
const props = defineProps([
    "segments",
    "buttons",
    "orders",
    "request",
    "totalOrders",
    "totalPendingOrders",
    "totalCompleteOrders",
    "totalDeclinedOrders",
    "type",
    "invoice",
    "currency",
    "tax",
    "author_fee"
]);
const isProcessing = ref(false);
const invoiceFrom = ref({
    company_name: props.invoice.company_name,
    address: props.invoice.address,
    city: props.invoice.city,
    post_code: props.invoice.post_code,
    country: props.invoice.country,
});

const currencyFrom = ref({
    name: props.currency.name,
    icon: props.currency.icon,
    position: props.currency.position,
});

const taxFrom = ref(props.tax);

const commisionFrom = ref(props.author_fee);

const filterData = useForm({
    search: props.request.search,
    type: props.type,
});

function updateOption(data, key) {
    isProcessing.value = true;
    router.put(
        route("admin.option.update", key),
        { data: data },
        {
            onSuccess: () => {
                createToast(
                    {
                        title: "Updated",
                        description: "Option Updated successfully",
                    },
                    {
                        transition: "slide",
                        position: "top-right",
                    }
                );
            },
            onFinish: () => (isProcessing.value = false),
        }
    );
}
</script>
