<template>
<div class="container">
    <div class="col-md-12 mt-5">
        <div class="card">
            <!-- card-header -->
            <div class="card-header">
                <h3 class="card-title text-center">Site Shop Maps</h3>

                <div class="card-tools">
                    <!-- Modal Button -->
                    <!-- To open different modals use  @click="newModal" instead of modal's id data-target="#addNew"  -->
                    <button class="btn btn-success" @click="newModal">Add New Map <i class="fas fa-globe-africa"></i></button>
                </div>

            </div>
            <!-- /.card-header -->
            <!-- card-body -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <th>title</th>
                            <th>description</th>
                            <th>description</th>
                            <th>Price</th>
                            <th>Modify</th>
                        </tr>
                        <tr v-for="map in maps.data" :key="map.id">
                            <td>{{ map.id }}</td>
                            <td>{{ map.title }}</td>
                            <td>{{ map.description }}</td>
                            <td>{{ map.imageName }}</td>
                            <td>{{ map.price }}</td>
                            <td>
                                <a href="#" @click="editModal(map)"><i class="fas fa-edit text-cyan"></i></a>
                                <a href="#" @click="deleteMap(map.id)"><i class="fas fa-trash text-red"></i></a>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <!-- card-footer -->
            <div class="card-footer">
                <div class="d-flex align-items-center justify-content-center">
                    <!--Pagination for ALL Maps-->
                    <pagination v-show="startmode" :data="maps" @pagination-change-page="getResults"></pagination>
                    <!--Pagination for Search Input-->
                    <pagination v-show="searchmode" :data="maps" @pagination-change-page="getResultsSearch"></pagination>

                </div>

            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 v-show="!editmode" class="modal-title" id="addNewLabel">Add New Map</h5>
                    <h5 v-show="editmode" class="modal-title" id="addNewLabel">Update Map's Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <!-- Form -->
                <form @submit.prevent="editmode ? updateMap() : createMap() ">
                    <div class="modal-body">

                        <div class="form-group">
                            <input v-model="form.title" name="title" id="title" placeholder="Title" class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                            <has-error :form="form" field="title"></has-error>
                        </div>

                        <div class="form-group">
                            <textarea v-model="form.description" name="description" id="description" placeholder="Description" class="form-control" :class="{ 'is-invalid': form.errors.has('description') }"></textarea>
                            <has-error :form="form" field="description"></has-error>
                        </div>

                        <div class="form-group">
                            <label v-show="!editmode" for="imageName" class="col-sm-4 control-label">Select Image</label>
                            <label v-show="editmode" for="imageName" class="col-sm-4 control-label">Change Image</label>
                            <div class="col-sm-10">
                                <input type="file" @change="encodeImageFileAsURL" class="form-input" name="imageName" id="imageName">
                            </div>
                        </div>

                        <div class="form-group">
                            <input v-model="form.price" name="price" id="price" placeholder="Preis. Example: 15.20" class="form-control" :class="{ 'is-invalid': form.errors.has('price') }">
                            <has-error :form="form" field="price"></has-error>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn-file-reset">Reset Image</button>
                        <button v-show="!editmode" type="submit" class="btn btn-success">Add</button>
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
            maps: {},

            startmode: true,
            searchmode: false,

            // Create a new form instance
            form: new Form({
                id: '',
                title: '',
                description: '',
                price: '',
                imageName: ''
            })
        }
    },
    // ------------  METHODS -------------------------
    methods: {

        getProfilePhoto() {
            let photo = (this.form.imageName.length > 100) ? this.form.imageName : "img/maps/" + this.form.imageName;
            return photo;
        },
        encodeImageFileAsURL(e) {
            // e.target Get the element that triggered the event:
            let file = e.target.files[0];
            // console.log(file['size');
            let reader = new FileReader();
            // Image size must be < 2Mb
            if (file['size'] < 2111775) {
                reader.onloadend = (file) => {
                    // console.log('RESULT', reader.result);
                    // push file into form.imageName
                    this.form.imageName = reader.result;
                }
                reader.readAsDataURL(file);
            } else {
                swal.fire({
                    type: 'error',
                    title: 'Oops...',
                    text: 'You are uploading a large file',
                })
            }
        },
        // pagination show ALL()
        getResults(page = 1) {
            axios.get('api/map?page=' + page)
                .then(response => {
                    this.maps = response.data;
                });
        },
        // pagination Search Input
        getResultsSearch(page = 1) {
            let query = this.$parent.search;
            axios.get('api/findMap?page=' + page + '&q=' + query)
                .then(response => {
                    this.maps = response.data;
                });
            this.searchmode = true;
            this.startmode = false;
        },
        // SHOW DIFFERENT MODALS
        // show edit map Modal, use all data from map (map in maps)
        editModal(map) {
            this.editmode = true;
            this.form.reset();
            $('#addNew').modal('show');
            this.form.fill(map);
        },
        newModal() {
            this.editmode = false;
            this.form.reset();
            $('#addNew').modal('show');
        },
        // EDIT MAP
        // execute Edit map
        updateMap() {
            this.form.put('api/map/' + this.form.id)
                .then(() => {
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Updated!',
                        'Map data  has been updated.',
                        'success'
                    )
                    Fire.$emit('AfterCreate');
                })
                .catch(() => {
                    swal.fire("Failed", "There was something wrong", "warning")
                })
        },
        // DELETE MAP
        deleteMap(id) {
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
                    this.form.delete('api/map/' + id).then(() => {
                        swal.fire(
                            'Deleted!',
                            'Map has been deleted.',
                            'success'
                        )
                        Fire.$emit('AfterCreate')
                    }).catch(() => {
                        swal.fire("Failed", "There was something wrong", "warning")
                    })
                }
            })
        },

        // SHOW MAPS axios request and put data into user data object
        loadMaps() {
            axios.get('api/map').then(({
                data
            }) => (this.maps = data))
        },

        // CREATE MAP
        createMap() {
            // vform performing axios: this.form.post('api/user'),  data from form: new Form({ id, name, email ...
            this.form.post('api/map')
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

        $(document).ready(function() {
            let imgName = $("#imageName");
            // Reset input="file" (imageName input) by modal show  image data + label.  form.reset don't do it
            $('#addNew').on('shown.bs.modal', function(event) {
                imgName.wrap('<form>').closest('form').get(0).reset();
                imgName.unwrap();
            });
            // Button reset in Modal
            $('#btn-file-reset').on('click', function(e) {
                imgName.wrap('<form>').closest('form').get(0).reset();
                imgName.unwrap();
            });
        });

        $('#addNew').on('hidden.bs.modal', function(event) {
            // Destroy modal
            $('#addNew').modal('dispose');
        });
        // search input event
        Fire.$on('searching', () => {
            // take from app.js the data search value
            let query = this.$parent.search;
            axios.get('api/findMap?q=' + query)
                .then((data) => {
                    this.maps = data.data;
                })
                .catch(() => {

                })
            this.searchmode = true;
            this.startmode = false;
        })
        // load page
        this.loadMaps();
        // execute Fire event to reload page, $on is for listening for events emitted by the same component.
        Fire.$on('AfterCreate', () => {
            this.loadMaps();
        })
        //alternative to Fire event
        // setInterval(() => this.loadUsers(), 3000)
    }
}
</script>
