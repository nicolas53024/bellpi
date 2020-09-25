<template>
    <div class="container mt-5">
        <div class="card bg-light ">
            <form>
                <div class="row justify-content-center mt-1">
                    <form>
                        <div class="row mb-4 mt-4">
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Numero de documento" v-model="form.documento"
                                :class="{
                            'is-valid':!$v.form.documento.$invalid ,
                            'is-invalid':$v.form.documento.$invalid && $v.form.documento.$model,
                          }">
                          <p v-if="!$v.form.documento.numeric && $v.form.documento.$model || $v.form.documento.minLegth && $v.form.documento.$model" class="text-danger"><small>El documento debe ser numerico y mayor a 6 caracteres.</small></p>
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" placeholder="Nombre" v-model="form.nombre"
                                :class="{
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
                }
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
            if (!this.$v.$invalid) {
                this.$emit('can-continue', {
                    value: true
                });
            } else {
                this.$emit('can-continue', {
                    value: false
                });
            }
        }
    }
</script>