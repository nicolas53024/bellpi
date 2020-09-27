<template>
    <div>
        <vue-confirm-dialog></vue-confirm-dialog>
        <Nav currentPage="2" />
        <div class="container">
            <h1>Descuentos</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Puede escoger una tarifa de descuento</h5>
                    <p>Ingrese el numero de minutos y el porcentaje que se aplicara cuando se supere este valor,si no quiere que existan descuentos puede dejar la cantidad de minutos en cero.</p>
                    <form @submit.prevent="onSubmit()">
                        <div class="form-group">
                            <input type="text" v-model="discount.minutes" class="form-control" :class="{
                                                                            'is-valid':!$v.discount.minutes.$invalid ,
                                                                            'is-invalid':$v.discount.minutes.$invalid && $v.discount.minutes.$model,
                                                                          }">
                        </div>
                        <p v-if="$v.discount.minutes.$invalid && $v.discount.minutes.$model" class="text-danger"><small>El campo debe ser formato numerico.</small></p>
                        <div class="form-group">
                            <label for="formControlRange">Porcentaje {{discount.percent}} %</label>
                            <input type="range" class="form-control-range" id="formControlRange" min="1" max="99" v-model="discount.percent">
                        </div>
                        <button type="submit" class="btn btn-primary " :disabled="formValid">Ajustar descuento</button></form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        required,
        numeric
    } from 'vuelidate/lib/validators'
    import axios from 'axios';
    axios.defaults.withCredentials = true;
    import Nav from "@/components/NavComponent.vue";
    export default {
        components: {
            Nav,
        },
        data() {
            return {
                discount: ''
            }
        },
        validations: {
            discount: {
                minutes: {
                    required,
                    numeric
                },
            }
        },
        created() {
            axios.get(this.baseUrl + '/api/get-current-discount').then((res) => {
                this.discount = res.data
            });
        },
        computed: {
            formValid() {
                return this.$v.discount.$invalid;
            }
        },
        methods: {
            onSubmit() {
                this.$confirm({
                    message: `Esta seguro de ajustar la tarifa de descuento?`,
                    button: {
                        no: 'No',
                        yes: 'Si'
                    },
                    callback: confirm => {
                        if (confirm) {
                            axios.post(this.baseUrl + '/api/update-discount/' + this.discount.id, {
                                minutes: this.discount.minutes,
                                percent:this.discount.percent
                            }).then(() => {
                                this.$swal.fire({
                                    icon: 'success',
                                    title: 'Perfecto!',
                                    text: 'Descuento actualizado con exito',
                                    showConfirmButton: true,
                                });
                            }).catch(() => {
                                this.$swal.fire({
                                    icon: 'error',
                                    title: 'Algo ha sucedido, no se pudo actualizar la tarifa',
                                })
                            })
                        }
                    }
                })
            },
        }
    }
</script>
