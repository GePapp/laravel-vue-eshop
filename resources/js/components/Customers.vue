<template>
<div class="container">
    <!---      ___________NORMAL MODE____________________          -->
    <div class="col-md-12 mt-5">
        <!-- card -->
        <div class="card">
            <!-- card-header -->
            <div class="card-header">
                <h3 class="card-title text-center">Customers</h3>
            </div>
            <!-- /.card-header -->
            <!-- card-body -->
            <div class="card-body table-responsive p-0">

                <table class="table table-hover table-sm table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="customer in customers.data" :key="customer.id" style="white-space: nowrap;">
                            <td>
                                {{ customer.name }}
                            </td>
                            <td>
                              {{ customer.email }}
                            </td>
                            <td>
                                <p v-if="customer.phone">{{ customer.phone }}</p>
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
                    <pagination v-show="startmode" :data="customers" @pagination-change-page="getResults"></pagination>
                    <!--Pagination for Search Input-->
                    <pagination v-show="searchmode" :data="customers" @pagination-change-page="getResultsSearch"></pagination>
                </div>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>
</template>

<script>
export default {

    data() {
        return {
            customers: {},
            /*Variables-Mode to use for Pagination*/
            startmode: true,
            searchmode: false
        }
    },
    methods: {

        // pagination show ALL()
        getResults(page = 1) {
            axios.get('api/getCustomers?page=' + page)
                .then(response => {
                    this.customers = response.data;
                });
        },

        // pagination Search Input
        getResultsSearch(page = 1) {
            let query = this.$parent.search;
            axios.get('api/findCustomer?page=' + page + '&q=' + query)
                .then(response => {
                    this.customers = response.data;
                });
            this.searchmode = true;
            this.startmode = false;
        },

        loadCustomers() {
            axios.get('api/getCustomers').then(({
                data
            }) => (this.customers = data))
        }
    },
    created() {

        // search input event
        Fire.$on('searching', () => {
            // take from app.js the data search value
            let query = this.$parent.search;
            axios.get('api/findCustomer?q=' + query).then(({
                    data
                }) => (this.customers = data))
                .catch(() => {

                })
            this.searchmode = true;
            this.startmode = false;
        })
        // load page
        this.loadCustomers();
        // execute Fire event to reload page, $on is for listening for events emitted by the same component.
        Fire.$on('AfterCreate', () => {
            this.loadCustomers();
        })

    }
}
</script>
