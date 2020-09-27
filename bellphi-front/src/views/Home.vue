<template>
  <div class="container ">
    <img alt="Vue logo" src="../assets/park.svg" width="200px" />
    <h1>Sistema de parqueadero</h1>
    <div class="card">
      <div class="card-body">
        <form @submit.prevent="submit">
          <div class="form-group row ">
            <label for="exampleInputEmail1" class="col-3 ">Email:</label>
            <input type="email" class="form-control col-5" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingresa tu @email " v-model="form.email" :class="{
                        'is-valid':$v.form.email.email && $v.form.email.$model ,
                        'is-invalid':!$v.form.email.email && $v.form.email.$model,
                      }">
          </div>
          <div class="form-group row ">
            <label for="exampleInputPassword1" class="col-3">Password:</label>
            <input type="password" class="form-control col-5" id="exampleInputPassword1" v-model="form.password" :class="{
                        'is-valid':!$v.form.password.email && $v.form.password.$model,
                        'is-invalid':$v.form.password.$error,
                      }">
          </div>
          <button type="submit" class="btn btn-primary" :disabled="$v.form.$invalid">Ingresar</button>
          <div class="btn btn-danger ml-4" @click="clean"><i class="far fa-trash-alt"></i> Borrar</div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  import {
    mapActions
  } from 'vuex'
  import {
    required,
    email
  } from 'vuelidate/lib/validators';
  export default {
    name: "Home",
    data() {
      return {
        form: {
          email: '',
          password: ''
        },
      }
    },
    validations: {
      form: {
        email: {
          required,
          email
        },
        password: {
          required
        },
      }
    },
    methods: {
      ...mapActions({
        login: 'login'
      }),
      clean() {
        this.form.email = ''
        this.form.password = ''
      },
      async submit() {
        await this.login(this.form).then(()=>{
          this.$router.replace({ name: 'Register' });
        })
        .catch(() => {
          this.$swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Credenciales Invalidas!',
          })
        });
      },
    },
  };
</script>
