<template>
    <div class="container mt-5">
        <div class="card bg-light ">
            <form>
                <div class="row justify-content-center mt-1">
                    <div class="form-group col-4 ">
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" v-model.trim="form.placa" :class="{
                            'is-valid':!$v.form.placa.$invalid ,
                            'is-invalid':$v.form.placa.$invalid && $v.form.placa.$model,
                          }">
                        <p v-if="!$v.form.placa.minLength && $v.form.placa.$model" class="text-danger"><small> Debe ingresar 6 caracteres.</small></p>
                        <small id="emailHelp" class="form-text text-muted">Si el vehículo es biclicleta ingrese el serial.</small>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import {
        required,
        minLength,
        alphaNum
    } from 'vuelidate/lib/validators'
    export default {
        props: ['clickedNext', 'currentStep'],
        data() {
            return {
                form: {
                    placa: '',
                }
            }
        },
        validations: {
            form: {
                placa: {
                    required,
                    minLength: minLength(6),
                    alphaNum
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
                        this.form.placa = this.form.placa.toUpperCase();
                        this.$store.commit('SET_PLACA', this.form.placa)
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
        },
        
    }
</script>