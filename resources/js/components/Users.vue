<template>
<div class="container">

    <div class="col-md-12 mt-5">
        <!-- card -->
        <div class="card">
            <!-- card-header -->
            <div class="card-header">
                <h3 class="card-title text-center">User List</h3>

                <div class="card-tools">
                    <!-- Modal Button -->
                    <!-- To open different modals use  @click="newModal" instead of modal's id data-target="#addNew"  -->
                    <button class="btn btn-success" @click="newModal">Add New User <i class="fas fa-user-plus"></i></button>
                </div>

            </div>
            <!-- /.card-header -->
            <!-- card-body -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Modify</th>
                        </tr>
                        <tr v-for="user in users.data" :key="user.id">
                            <td>{{ user.id }}</td>
                            <td>{{ user.name }}</td>
                            <td>{{ user.email }}</td>
                            <td><span class="tag tag-success">{{ user.type }}</span></td>
                            <td>
                                <a href="#" @click="editModal(user)"><i class="fas fa-edit text-cyan"></i></a>
                                <a href="#" @click="deleteUser(user.id)"><i class="fas fa-trash text-red"></i></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <!-- card-footer -->
            <div class="card-footer">
                <div class="d-flex align-items-center justify-content-center">
                    <!--Pagination for ALL Users-->
                    <pagination v-show="startmode" :data="users" @pagination-change-page="getResults"></pagination>
                    <!--Pagination for Search Input-->
                    <pagination v-show="searchmode" :data="users" @pagination-change-page="getResultsSearch"></pagination>
                </div>

            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Create New User</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update User's Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Form -->
                <form @submit.prevent="editmode ? updateUser() : createUser() ">
                    <div class="modal-body">

                        <div class="form-group">
                            <input v-model="form.name" type="text" name="name" id="name" placeholder="Name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                            <has-error :form="form" field="name"></has-error>
                        </div>

                        <div class="form-group">
                            <input v-model="form.email" type="email" name="email" id="email" placeholder="Email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                            <has-error :form="form" field="email"></has-error>
                        </div>

                        <div class="form-group">
                            <select v-model="form.type" name="type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                                <option value="" disabled>Select User Type</option>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                            <has-error :form="form" field="type"></has-error>
                        </div>

                        <div class="form-group">
                            <input v-model="form.password" type="password" name="password" id="password" placeholder="Password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                            <has-error :form="form" field="password"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button v-show="!editmode" type="submit" class="btn btn-success">Create</button>
                        <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
                <!-- /End Form -->

            </div>
        </div>
    </div>
    <!-- End Modal -->

</div>
</template>


// ------------  SCRIPT -------------------------

<script>
export default {
    // ------------  DATA -------------------------
    data() {
        return {
            // editmode for change create new User or edit user
            editmode: false,
            // Define  user data object
            users: {},

            startmode: true,
            searchmode: false,

            // Create a new form instance
            form: new Form({
                id: '',
                name: '',
                email: '',
                password: '',
                type: ''
            })
        }
    },
    // ------------  METHODS -------------------------
    methods: {
        // pagination show ALL()
        getResults(page = 1) {
            axios.get('api/user?page=' + page)
                .then(response => {
                    this.users = response.data;
                });
        },

        // pagination Search Input
        getResultsSearch(page = 1) {
            let query = this.$parent.search;
            axios.get('api/findUser?page=' + page + '&q=' + query)
                .then(response => {
                    this.users = response.data;
                });
            this.searchmode = true;
            this.startmode = false;
        },

        // SHOW DIFFERENT MODALS
        // show edit user Modal, use all data from user (user in users)
        editModal(user) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(user);
        },
        // show create user Modal
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        // EDIT USER
        // execute Edit user
        updateUser() {
            this.form.put('api/user/' + this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Updated!',
                        'User  has been updated.',
                        'success'
                    )
                    Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    swal.fire("Failed", "There was something wrong", "warning")
                })
        },
        // DELETE USER
        deleteUser(id) {
            swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                // Send request to server
                if (result.value) {
                    this.form.delete('api/user/' + id).then(() => {
                        swal.fire(
                            'Deleted!',
                            'User has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate')
                    }).catch(() => {
                        swal.fire("Failed", "There was something wrong", "warning")
                    })
                }
            })
        },

        // SHOW USERS axios request and put data into user data object
        loadUsers() {
            axios.get('api/user').then(({
                data
            }) => (this.users = data))
        },

        // CREATE USER
        createUser() {
            // vform performing axios: this.form.post('api/user'),  data from form: new Form({ id, name, email ...
            this.form.post('api/user')
                .then(() => {
                    // if success, emit Fire event to reload page, close modal and show sweetalert2 success popup
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide');
                    toast.fire({
                        type: 'success',
                        title: 'User created Successfully'
                    })

                })
                .catch(() => {})
        }
    },
    // ------------  CREATED -------------------------
    created() {
        // search input event
        Fire.$on('searching', () => {
            // take from app.js the data search value
            let query = this.$parent.search;
            axios.get('api/findUser?q=' + query)
                .then((data) => {
                    this.users = data.data;
                })
                .catch(() => {

                })
                this.searchmode = true;
                this.startmode = false;
        })
        // load page
        this.loadUsers();
        // execute Fire event to reload page, $on is for listening for events emitted by the same component.
        Fire.$on('AfterCreate', () => {
            this.loadUsers();
        })
        //alternative to Fire event
        // setInterval(() => this.loadUsers(), 3000)



    }
}
</script>
