<template>
<div class="container">
    <!---      ___________NORMAL MODE____________________          -->
    <div class="col-md-12 mt-5">
        <!-- card -->
        <div v-show="!printmode" class="card">
            <!-- card-header -->
            <div class="card-header">
                <h3 class="card-title text-center">Consultations</h3>

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
                            <th>Consultation</th>
                            <th>Checked</th>
                            <th>Print</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="consultation in consultations.data" :key="consultation.id" style="white-space: nowrap;">
                            <td>
                                {{ consultation.customer.name }}<br />
                                {{ consultation.customer.email }}<br />
                                Birthdate: {{ consultation.customer.birthdate }} <br />
                                Birthtime: {{ consultation.customer.birthtime }}
                                <p v-if="consultation.customer.phone">phone: {{ consultation.customer.phone }}</p>
                            </td>
                            <td>
                                <strong>{{ consultation.payment_id }}<br />
                                    Amount: {{ consultation.amount }} €</strong><br />
                                Payment Date: {{ consultation.created_at | momDate }}
                            </td>
                            <td>
                                <button v-show="consultation.unchecked" type="button" class="btn btn-warning btn-sm" @click="setChecked(consultation.id)">setChecked</button>&nbsp;&nbsp;&nbsp;
                                <i v-show="!consultation.unchecked" class="fas fa-check text-green"></i>&nbsp;&nbsp;&nbsp;
                            </td>
                            <td>
                                <!--<a class="nav-link" href="{{ route('astrologische-psychologie') }}">printOrder</a>-->
                                <button type="button" class="btn btn-info btn-sm" @click="printConsultation(consultation.id)">printConsultation</button>
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
                    <pagination v-show="startmode" :data="consultations" @pagination-change-page="getResults"></pagination>
                    <!--Pagination for Search Input-->
                    <pagination v-show="searchmode" :data="consultations" @pagination-change-page="getResultsSearch"></pagination>
                    <!--Pagination for show UnCheced-->
                    <pagination v-show="uncheckhmode" :data="consultations" @pagination-change-page="getResultsUncheck"></pagination>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
    <!---      ___________END NORMAL MODE____________________          -->
    <!---      ___________PRINT MODE____________________          -->
    <div v-show="printmode" class="row">
        <div v-for="consultation in consultations.data" :key="consultation.id" class="col-12">
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
                            <strong>{{ consultation.customer.name }}</strong><br />
                            Birthdate: {{ consultation.customer.birthdate }}<br />
                            Birthtime: {{ consultation.customer.birthtime }}<br />
                            {{ consultation.customer.email }}<br />
                            <p v-if="consultation.customer.phone">phone: {{ consultation.customer.phone }}</p>
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-4">
                        {{ consultation.payment_id }}<br>
                        Payment Date {{ consultation.created_at | momDate }}
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
                                        <td>{{ consultation.amount }} €</td>
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
                                        <td>{{ consultation.amount }} €</td>
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
                        <button type="button" @click.prevent="loadOrders" class="btn float-right">Back to Consultations</button>
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
            consultations: {},
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
            axios.get('api/getConsultations?page=' + page)
                .then(response => {
                    this.consultations = response.data;
                });
        },

        // pagination Search Input
        getResultsSearch(page = 1) {
            let query = this.$parent.search;
            axios.get('api/findConsultation?page=' + page + '&q=' + query)
                .then(response => {
                    this.consultations = response.data;
                });
            this.searchmode = true;
            this.startmode = false;
            this.uncheckhmode = false;
        },

        // pagination show UnChecked()
        getResultsUncheck(page = 1) {
            axios.get('api/findUnCheckedConsultations?page=' + page)
                .then(response => {
                    this.consultations = response.data;
                });
            this.uncheckhmode = true;
            this.searchmode = false;
            this.startmode = false;
        },

        loadConsultations() {
            axios.get('api/getConsultations').then(({
                data
            }) => (this.consultations = data))
            this.printmode = false;
        },

        setChecked(id) {
            axios.put('api/setCheckedConsultation/' + id)
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
            axios.get('api/findUnCheckedConsultations').then(({
                data
            }) => (this.consultations = data))
            this.uncheckhmode = true;
            this.searchmode = false;
            this.startmode = false;
        },

        printConsultation(id) {
            axios.get('api/printConsultation/' + id).then(({
                data
            }) => (this.consultations.data = data))

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
            axios.get('api/findConsultation?q=' + query).then(({
                    data
                }) => (this.consultations = data))
                .catch(() => {

                })
            this.searchmode = true;
            this.startmode = false;
            this.uncheckhmode = false;
        })
        // load page
        this.loadConsultations();
        // execute Fire event to reload page, $on is for listening for events emitted by the same component.
        Fire.$on('AfterCreate', () => {
            this.loadConsultations();
        })

    }
}
</script>
