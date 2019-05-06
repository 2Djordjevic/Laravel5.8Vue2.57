<style>
  .widget-user-header {
    background-position: center center;
    background-size: cover;
    height: 180px !important;
  }
</style>
<template>
  <div class="container">
    <div class="row">
      <div class="col-md-12 mt-3">
        <div class="card card-widget widget-user">
          <!-- Add the bg color to the header using any of the bg-* classes -->
          <div class="widget-user-header text-white" style="background-image: url('/img/user-cover.png
          ');">
            <h3 class="widget-user-username">{{this.form.name}}</h3>
            <h5 class="widget-user-desc">{{this.form.type | upText}}</h5>
            <h5 class="widget-user-desc">{{this.form.email}}</h5>
          </div>
          <div class="widget-user-image">
            <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
          </div>
          <div class="card-footer">
            <div class="row">
              <div class="col-sm-4 border-right">
                <div class="description-block">
                  <h5 class="description-header">3,200</h5>
                  <span class="description-text">SALES</span>
                </div>
                <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <h5 class="description-header">13,000</h5>
                    <span class="description-text">FOLLOWERS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
                <div class="col-sm-4">
                  <div class="description-block">
                    <h5 class="description-header">35</h5>
                    <span class="description-text">PRODUCTS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>
        </div>
        <div class="col-md-12 mt-1">
          <div class="card">
            <div class="card-header p-2">
              <ul class="nav nav-pills">
                <li class="nav-item"><a class="nav-link" href="#activity" data-toggle="tab">Activity</a></li>
                <li class="nav-item"><a class="nav-link active show" href="#settings" data-toggle="tab">Settings</a></li>
              </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane" id="activity">
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane active show" id="settings">
                  <form class="form-horizontal">
                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Name</label>
                      <div class="col-sm-10">
                        <input v-model="form.name" type="text" name="name" id="name" class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="email" class="col-sm-2 control-label">Email</label>
                      <div class="col-sm-10">
                        <input v-model="form.email" type="email" name="email" id="email" class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="bio" class="col-sm-3 control-label">Short bio for user (Optional)</label>
                      <div class="col-sm-10">
                        <textarea v-model="form.bio" id="bio" name="bio" class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio"></has-error>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="photo" class="col-sm-4 control-label">Profile Photo</label>
                      <div class="col-sm-10">
                        <input type="file" @change="updatePhoto" name="photo" id="photo"  >
                        <!--<input v-model="form.photo" type="file" name="photo" id="photo" class="form-control" :class="{ 'is-invalid': form.errors.has('profile') }">
                        <has-error :form="form" field="photo"></has-error>-->
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="password" class="col-sm-2 control-label">Password</label>
                      <div class="col-sm-10">
                        <input v-model="form.password" type="password" name="password" id="password" class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                      </div>
                    </div>
                    <div class="form-group">
                      <label for="password" class="col-sm-3 control-label">Confirm Password</label>
                      <div class="col-sm-10">
                        <input v-model="form.password_confirmation" type="password" name="password_confirmation" id="password_confirmation" class="form-control" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                        <has-error :form="form" field="password_confirmation"></has-error>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-2 col-sm-10">
                        <button @click.prevent="updateProfile" type="submit" class="btn btn-danger">Update</button>
                      </div>
                    </div>
                  </form>
                </div>
                <!-- /.tab-pane -->
              </div>
              <!-- /.tab-content -->
            </div><!-- /.card-body -->
          </div>
          <!-- /.nav-tabs-custom -->
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        form: new Form({
          id: '',
          name: '',
          email: '',
          type: '',
          bio: '',
          photo: ''
        })
      }
    },
    methods: {
      loadProfile() {
        axios.get('api/profile').then(({ data }) => (this.form.fill(data)));
      },
      getProfilePhoto(){
        let photo = (this.form.photo.length > 200) ? this.form.photo : "img/profile/" + this.form.photo;
        return photo;
      },
      updateProfile() {
        this.$Progress.start();
        if(this.form.password == '') {
          this.form.password = undefined;
        }
        this.form.put('api/profile/')
          .then((data)=> {
            Swal.fire(
              'Updated!',
              'Profile has been updated.',
              'success'
            );
            Fire.$emit('reloadProfile');
            this.$Progress.finish();
          }).catch(()=>{
            this.$Progress.fail();
            //Swal.fire("Profile update Failed!", "There was something wrong.", "warning");
          });
      },
      updatePhoto(e){
        let file = e.target.files[0];
        let reader = new FileReader();
        if(file['size'] < 2111775) {
          reader.onloadend = (file) => {
            this.form.photo = reader.result;
          }
          reader.readAsDataURL(file);
        } else {
            Swal.fire({
              type: 'error',
              title: 'Oops...',
              text: 'You are uploading a large file.(Max size: 2M)'
            });
        }
      }
    },
    mounted() {
        console.log('Component mounted.')
    },
    created () {
      this.loadProfile();
      Fire.$on('reloadProfile', () => {
        this.loadProfile();
      })
    }
  }
</script>
