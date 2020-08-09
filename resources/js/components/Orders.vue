<template>
<div class="container">
    <!---      ___________NORMAL MODE____________________          -->
    <div class="col-md-12 mt-5">
        <!-- card -->
        <div v-show="!printmode" class="card">
            <!-- card-header -->
            <div class="card-header">
                <h3 class="card-title text-center">Orders</h3>

                <div class="card-tools">
                    <button class="btn btn-info btn-sm" @click="showUnChecked()">showUnChecked</i></button>
                </div>
            </div>
            <!-- /.card-header -->
            <!-- card-body -->
            <div class="card-body table-responsive p-0">

                <table class="table table-hover table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Cart</th>
                            <th>Checked</th>
                            <th>Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders.data" :key="order.id" style="white-space: nowrap;">
                            <td>
                                {{ order.customer.name }}<br />
                                {{ order.customer.email }}<br />
                                {{ order.street }} <br />
                                {{ order.postcode }} - {{ order.country }}
                                <p v-if="order.customer.phone">phone: {{ order.customer.phone }}</p>
                            </td>
                            <td>
                                <strong>{{ order.payment_id }} - total amount: {{ order.cart.totalPrice }} €</strong><br />
                                Date: {{ order.created_at | momDate }}
                                <ul class="list-group list-group-flush">
                                    <li v-for="item in order.cart.items" :key="order.cart.items.id" class="list-group-item">
                                        {{ item['item']['title'] }} - Units: {{ item['qty'] }} - Price: {{ item['price'] }} €
                                    </li>
                                </ul>
                            </td>
                            <td>
                                <button v-show="order.unchecked" type="button" class="btn btn-warning btn-sm" @click="setChecked(order.id)">setChecked</button>&nbsp;&nbsp;&nbsp;
                                <i v-show="!order.unchecked" class="fas fa-check text-green"></i>&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>
                                <!--<a class="nav-link" href="{{ route('astrologische-psychologie') }}">printOrder</a>-->
                                <button type="button" class="btn btn-info btn-sm" @click="printOrder(order.id)">printOrder</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <!-- card-footer -->
            <div class="card-footer">
                <div class="d-flex align-items-center justify-content-center">
                    <!--Pagination for ALL Orders-->
                    <pagination v-show="startmode" :data="orders" @pagination-change-page="getResults"></pagination>
                    <!--Pagination for Search Input-->
                    <pagination v-show="searchmode" :data="orders" @pagination-change-page="getResultsSearch"></pagination>
                    <!--Pagination for show UnCheced-->
                    <pagination v-show="uncheckhmode" :data="orders" @pagination-change-page="getResultsUncheck"></pagination>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
    <!---      ___________END NORMAL MODE____________________          -->
    <!---      ___________PRINT MODE____________________          -->
    <div v-show="printmode" class="row">
        <div v-for="order in orders.data" :key="order.id" class="col-12">
            <!-- Main content -->
            <div>
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h5><i class="fa fa-globe"></i> Sundance Berlin</h5>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row">
                    <div class="col-sm-4 invoice-col">
                        From
                        <address>
                            <strong>Sundance Berlin</strong><br>
                            <strong>Astrologische Beratungspraxis und Schule</strong><br>
                            Georg Stockhorst<br>
                            0049 (0)30 3451233<br>
                            mobil 0049 (0)177 3451233<br>
                            email georgstc@web.de
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        <address>
                            To
                            <strong>{{ order.customer.name }}</strong><br>
                            {{ order.customer.email }}<br />
                            {{ order.street }} <br />
                            {{ order.postcode }} - {{ order.country }}
                            <p v-if="order.customer.phone">phone: {{ order.customer.phone }}</p>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        {{ order.payment_id }}<br>
                        Order Date {{ order.created_at | momDate }}
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                <!-- Table row -->
                <div class="row">
                    <div class="col-8 table-responsive">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Qty</th>
                                    <th>Product</th>
                                    <th>Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in order.cart.items" :key="order.cart.items.id">
                                    <td>{{ item['qty'] }}</td>
                                    <td>{{ item['item']['title'] }}</td>
                                    <td>{{ item['price'] }} €</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <!-- accepted payments column -->
                    <div class="col-6">

                    </div>
                    <!-- /.col -->
                    <div class="col-6">
                        <p class="text-center">Amount</p>

                        <div class="table-responsive table-sm table-bordered">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>{{ order.cart.totalPrice }} €</td>
                                    </tr>
                                    <tr>
                                        <th>Tax (...%)</th>
                                        <td>... €</td>
                                    </tr>
                                    <tr>
                                        <th>Shipping:</th>
                                        <td>... €</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td>{{ order.cart.totalPrice }} €</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12">
                        <a href="" @click.prevent="printme" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                        <button type="button" @click.prevent="loadOrders" class="btn float-right">Back to Orders</button>
                    </div>
                </div>

            </div>
            <!---      ___________END PRINT MODE____________________          -->
        </div>
    </div>
</div>
</template>

<script>
export default {

    data() {
        return {
            orders: {},
            search: '',
            /*Variables-Mode to use for Pagination*/
            startmode: true,
            uncheckhmode: false,
            searchmode: false,
            printmode: false
        }
    },
    methods: {

        // pagination show ALL()
        getResults(page = 1) {
            axios.get('api/getOrders?page=' + page)
                .then(response => {
                    this.orders = response.data;
                });
        },

        // pagination Search Input
        getResultsSearch(page = 1) {
            let query = this.$parent.search;
            axios.get('api/findOrder?page=' + page + '&q=' + query)
                .then(response => {
                    this.orders = response.data;
                });
            this.searchmode = true;
            this.startmode = false;
            this.uncheckhmode = false;
        },

        // pagination show UnChecked()
        getResultsUncheck(page = 1) {
            axios.get('api/findUnChecked?page=' + page)
                .then(response => {
                    this.orders = response.data;
                });
            this.uncheckhmode = true;
            this.searchmode = false;
            this.startmode = false;
        },

        loadOrders() {
            axios.get('api/getOrders').then(({
                data
            }) => (this.orders = data))
            this.printmode = false;
        },

        setChecked(id) {
            axios.put('api/setChecked/' + id)
                .then(() => {
                    swal.fire(
                        'Updated!',
                        'Order has been Checked.'
                    )
                    Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    swal.fire("Failed", "There was something wrong", "warning")
                })
        },

        showUnChecked() {
            axios.get('api/findUnChecked').then(({
                data
            }) => (this.orders = data))
            this.uncheckhmode = true;
            this.searchmode = false;
            this.startmode = false;
        },

        printOrder(id) {
            axios.get('api/printOrder/' + id).then(({
                data
            }) => (this.orders.data = data))

            this.printmode = true;
        },
        printme() {
            window.print();
        }
    },
    created() {

        // search input event
        Fire.$on('searching', () => {
            // take from app.js the data search value
            let query = this.$parent.search;
            axios.get('api/findOrder?q=' + query).then(({
                    data
                }) => (this.orders = data))
                .catch(() => {

                })
            this.searchmode = true;
            this.startmode = false;
            this.uncheckhmode = false;
        })
        // load page
        this.loadOrders();
        // execute Fire event to reload page, $on is for listening for events emitted by the same component.
        Fire.$on('AfterCreate', () => {
            this.loadOrders();
        })

    }
}
</script>
