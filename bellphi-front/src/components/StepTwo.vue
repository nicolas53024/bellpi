<template>
    <div class="container mt-5">
        <div class="card bg-light ">
            <form>
                <div class="row justify-content-center mt-1">
                    <form>
                        <div class="row mb-4 mt-4">
                            <div class="col">
                                <input type="text" class="form-control" id="document" placeholder="Numero de documento" v-model="form.document" :class="{
                                                    'is-valid':!$v.form.document.$invalid ,
                                                    'is-invalid':$v.form.document.$invalid && $v.form.document.$model,
                                                  }">
                                <p v-if="!$v.form.document.numeric && $v.form.document.$model || $v.form.document.minLegth && $v.form.document.$model" class="text-danger"><small>El document debe ser numerico y mayor a 6 caracteres.</small></p>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control " placeholder="nombre" v-model="form.name" :class="{
                                                    'is-valid':!$v.form.name.$invalid ,
                                                    'is-invalid':$v.form.name.$invalid && $v.form.name.$model,
                                                  }">
                                <p v-if="!$v.form.name.minLength && $v.form.name.$model" class="text-danger"><small>El name es obligatorio.</small></p>
                            </div>
                        </div>
                    </form>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    axios.defaults.withCredentials = true;
    import $ from 'jquery'
    import {
        required,
        minLength,
        numeric
    } from 'vuelidate/lib/validators'
    export default {
        props: ['clickedNext', 'currentStep'],
        data() {
            return {
                form: {
                    document: '',
                    name: '',
                },
                idType: '',
                currentUser:null
            }
        },
        validations: {
            form: {
                document: {
                    required,
                    numeric,
                    minLength: minLength(6),
                },
                name: {
                    required,
                    minLength: minLength(6),
                },
            }
        },
        watch: {
            $v: {
                handler: function(val) {
                    if (!val.$invalid) {
                        this.$emit('can-continue', {
                            value: true
                        });
                        this.$store.commit('SET_CUSTOMER', this.currentUser?this.currentUser: this.form)
                    } else {
                        this.$emit('can-continue', {
                            value: false
                        });
                        setTimeout(() => {
                            this.$emit('change-next', {
                                nextBtnValue: false
                            });
                        }, 3000)
                    }
                },
                deep: true
            },
            clickedNext(val) {
                if (val === true) {
                    this.$v.form.$touch();
                }
            }
        },
        mounted() {
            this.idType = this.getTypeVehicle(this.$route.params.type);
            this.getUserBySerial();
            if (!this.$v.$invalid) {
                this.$emit('can-continue', {
                    value: true
                });
            } else {
                this.$emit('can-continue', {
                    value: false
                });
            }
        },
        methods: {
            getUserBySerial() {
                axios.post(this.baseUrl + '/api/get-user', {
                    placa: this.$store.state.placa
                }).then((res) => {
                    if (res.data.type_vehicle_id != this.idType) {
                        this.$swal.fire({
                            icon: 'error',
                            title: 'La placa del vehículo no coindice con el tipo de servicio seleccionado',
                        })
                        $( ".previous" ).trigger( "click" );
                    } else {
                        this.form.document = res.data.user.document;
                        this.form.name = res.data.user.name;
                        this.currentUser=res.data.user;
                        $(".form-control").prop('disabled', true);
                        this.$store.commit('SET_CUSTOMER', this.currentUser)
                    }
                }).catch((error) => {
                    if(error.response.status == 422){
                        this.$swal.fire({
                            icon: 'error',
                            title: 'Este vehículo ya esta parqueado',
                        })
                        $( ".previous" ).trigger( "click" );
                    }
                });
            },
        },
    }
</script>