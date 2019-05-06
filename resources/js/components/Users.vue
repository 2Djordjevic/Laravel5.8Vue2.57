<template>
  <div class="container">
      <div class="row" v-if="!$gate.isAdminOrAuthor()">
        <not-found> </not-found>
      </div>
      <div class="row mt-3" v-if="$gate.isAdminOrAuthor()">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Users Table</h3>
              <div class="card-tools">
                <button class="btn btn-success" @click="createModal">Add New <i class="fas fa-user-plus fa-fw"></i></button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
              <table class="table table-hover">
                <tbody>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Registered At</th>
                    <th>Modify</th>
                  </tr>
                  <tr v-for="user in users.data" :key="user.id">
                    <td>{{ user.id }}</td>
                    <td>{{ user.name }}</td>
                    <td>{{ user.email }}</td>
                    <td>{{ user.type | upText }}</td>
                    <td>{{ user.created_at | myDate }}</td>
                    <td>
                      <a href="#" @click="editModal(user)"><i class="fas fa-edit"></i></a>
                      /
                      <a href="#" @click="deleteUser(user.id)"><i class="fas fa-trash"></i></a>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <pagination :data="users" @pagination-change-page="changePage"></pagination>
            </div>
          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- Modal -->
      <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add New</h5>
              <h5 v-show="editMode" class="modal-title" id="addNewLabel">Update {{ form.name }}'s Info</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form @submit.prevent="editMode ? updateUser() : createUser()">
              <div class="modal-body">
                <div class="form-group">
                  <label>Name</label>
                  <input v-model="form.name" type="text" name="name" id="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                  <has-error :form="form" field="name"></has-error>
                </div>
                <div class="form-group">
                  <label>Email Address</label>
                  <input v-model="form.email" type="email" name="email" id="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                  <has-error :form="form" field="email"></has-error>
                </div>
                <div class="form-group">
                  <label>Short bio for user (Optional)</label>
                  <textarea v-model="form.bio" id="bio" name="bio" class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                  <has-error :form="form" field="bio"></has-error>
                </div>
                <div class="form-group">
                  <label>Type</label>
                  <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                    <option value="">Select User Role</option>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                    <option value="author">Author</option>
                  </select>
                  <has-error :form="form" field="type"></has-error>
                </div>
                <div class="form-group">
                  <label>Password</label>
                  <input v-model="form.password" type="password" name="password" id="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                  <has-error :form="form" field="password"></has-error>
                </div>
                <div class="form-group">
                  <label>Confirm Password</label>
                  <input v-model="form.password_confirmation" type="password" name="password_confirmation" id="password_confirmation" class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                  <has-error :form="form" field="password_confirmation"></has-error>
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                <button v-show="!editMode" type="submit" class="btn btn-primary">Create</button>
              </div>
            </form>
          </div>
        </div>
      </div>
  </div>
</template>

<script>
    export default {
      data() {
        return {
          editMode: false,
          users: {},
          form: new Form({
            id: '',
            name: '',
            email: '',
            password: '',
            password_confirmation: '',
            type: '',
            bio: '',
            photo: ''
          })
        }
      },
      
      methods: {
        createModal() {
          this.editMode = false;
          this.form.reset();
          this.form.clear ();
          $('#addNew').modal('show');
        },
        editModal(user) {
          this.editMode = true;
          this.form.reset();
          this.form.clear ();
          $('#addNew').modal('show');
          this.form.fill(user);
        },
        loadUsers() {
          if(this.$gate.isAdminOrAuthor()) {
            axios.get('api/user').then(({ data }) => (this.users = data));
          }
        },
        changePage(page=1) {
          axios.get('api/user?page=' + page)
          .then(response => {
            this.users = response.data;
          });
        },
        createUser() {
          this.$Progress.start();
          this.form.post('api/user')
            .then(( data ) => {
              console.log(data);
              Fire.$emit('reloadTable');
              $('#addNew').modal('hide');
              Toast.fire({
                type: 'success',
                title: 'User Created in successfully'
              });
              this.$Progress.finish();
            }).catch((error) => {
              this.$Progress.fail();
              console.log(error);
            });
        },
        updateUser() {
          this.$Progress.start();
          this.form.put('api/user/' + this.form.id)
            .then((data)=> {
              $('#addNew').modal('hide');
              Swal.fire(
                'Updated!',
                'User data has been updated.',
                'success'
              );
              this.$Progress.finish();
              Fire.$emit('reloadTable');
            }).catch(()=>{
              //$('#addNew').modal('hide');
              this.$Progress.fail();
              Swal.fire("Update Failed!", "There was something wrong.", "warning");
            });
          //console.log("Updating User Data.");
        },
        deleteUser(user_id){
          Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            //send delete request to the server for deleting
            if(result.value) {
              this.form.delete('api/user/' + user_id)
                .then((data)=> {
                  Swal.fire(
                    'Deleted!',
                    'User has been deleted.',
                    'success'
                  )
                  Fire.$emit('reloadTable');

                }).catch(()=>{
                  Swal.fire("Delete Failed!", "There was something wrong.", "warning");
                });
            }
          });
        }
      },

      created() {
        Fire.$on('searching', () => {
          let query = this.$parent.search;
          if (query !== '') {
            axios.get('api/searchUser?q=' + query).then((data)=> {
              this.users = data.data;
            }).catch(()=>{
              
            });
          }
        });
        this.loadUsers();
        Fire.$on('reloadTable', () => {
          this.loadUsers();
        });
        // setInterval(() => this.loadUsers(), 3000);
      }
    }
</script>
