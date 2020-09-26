<template>
    <div class="container mt-5">
        <div class="card bg-light ">
            <form>
                <div class="row justify-content-center mt-1">
                    <form>
                        <div class="row mb-4 mt-4">
                            <div class="col">
                                <input type="text" class="form-control" id="document" placeholder="Numero de documento" v-model="form.documento" :class="{
                                                    'is-valid':!$v.form.documento.$invalid ,
                                                    'is-invalid':$v.form.documento.$invalid && $v.form.documento.$model,
                                                  }">
                                <p v-if="!$v.form.documento.numeric && $v.form.documento.$model || $v.form.documento.minLegth && $v.form.documento.$model" class="text-danger"><small>El documento debe ser numerico y mayor a 6 caracteres.</small></p>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control " placeholder="Nombre" v-model="form.nombre" :class="{
                                                    'is-valid':!$v.form.nombre.$invalid ,
                                                    'is-invalid':$v.form.nombre.$invalid && $v.form.nombre.$model,
                                                  }">
                                <p v-if="!$v.form.nombre.minLength && $v.form.nombre.$model" class="text-danger"><small>El nombre es obligatorio.</small></p>
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
                    documento: '',
                    nombre: '',
                },
                idType: '',
                currentUser:null
            }
        },
        validations: {
            form: {
                documento: {
                    required,
                    numeric,
                    minLength: minLength(6),
                },
                nombre: {
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
                        this.form.documento = res.data.user.document;
                        this.form.nombre = res.data.user.name;
                        this.currentUser=res.data.user;
                        $(".form-control").prop('disabled', true);
                        this.$store.commit('SET_CUSTOMER', this.currentUser)
                    }
                }).catch(() => {});
            },
        },
    }
</script>