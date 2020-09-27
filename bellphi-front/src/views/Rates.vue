<template>
    <div>
        <vue-confirm-dialog></vue-confirm-dialog>
        <Nav currentPage="1" />
        <div class="container">
            <h1>Tarifas</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Seleccione el tipo de vehículo par ajustar la tarifa</h5>
                    <form @submit.prevent="onSubmit()">
                        <div class="form-group">
                            <label>La tarifa aplicada es por minuto</label>
                            <select class="form-control" v-model="selected">
                                                        <option v-for="(rate,index) in rates" :key="index" :value="rate" >{{rate.name}}</option>
                                                        </select>
                        </div>
                        <div class="form-group">
                            <input type="text" v-model="selected.rate_per_minute" class="form-control" :class="{
                                                                        'is-valid':!$v.selected.rate_per_minute.$invalid ,
                                                                        'is-invalid':$v.selected.rate_per_minute.$invalid && $v.selected.rate_per_minute.$model,
                                                                      }">
                        </div>
                        <p v-if="$v.selected.rate_per_minute.$invalid && $v.selected.rate_per_minute.$model" class="text-danger"><small>El rango debe ir entre $50 y $1000.</small></p>
                        <button type="submit" class="btn btn-primary" :disabled="formValid">Ajustar tarifa</button></form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        required,
        numeric,
        between
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
                rates: '',
                selected: ''
            }
        },
        validations: {
            selected: {
                rate_per_minute: {
                    required,
                    between: between(50, 1000),
                    numeric
                },
            }
        },
        created() {
            axios.get(this.baseUrl + '/api/get-rates').then((res) => {
                this.rates = res.data;
            });
        },
        computed: {
            formValid() {
                return this.$v.selected.rate_per_minute.$invalid;
            }
        },
        methods: {
            onSubmit() {
                this.$confirm({
                    message: `Esta seguro de ajustar la tarifa para ${this.selected.name}?`,
                    button: {
                        no: 'No',
                        yes: 'Si'
                    },
                    callback: confirm => {
                        if (confirm) {
                            axios.post(this.baseUrl + '/api/update-rate/' + this.selected.id, {
                                rate: this.selected.rate_per_minute
                            }).then(() => {
                                this.$swal.fire({
                                    icon: 'success',
                                    title: 'Perfecto!',
                                    text: 'Precio actualizado con exito',
                                    showConfirmButton: true,
                                });
                                setTimeout(() => {
                                    location.reload();
                                }, 3000)
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

<style lang="scss" scoped>

</style>