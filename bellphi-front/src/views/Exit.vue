<template>
    <div>
        <vue-confirm-dialog></vue-confirm-dialog>
        <Nav currentPage="3" />
        <Voucher :responseServiceProp="responseService" :placaProp="placa" :serviceProp="service" @finalizar="finish" ref="modal"/>
        <div class="container">
            <h1>Salida <i class="fas fa-share"></i></h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Finalizar servicio</h5>
                    <p>Al finalizar el formulario se imprimira el tiquete de pago.</p>
                    <form @submit.prevent="getData()">
                        <div class="form-group">
                            <input type="text" v-model.trim="placa" class="form-control" placeholder="Ingrese la placa del vehiculo">
                        </div>
                        <button type="submit" class="btn btn-primary" :disabled="formValid" v-if="!service">Enviar</button>
                    </form>
                    <div v-if="service">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Nombre</label>
                                <input class="form-control" v-model="service.username" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Documento</label>
                                <input class="form-control" v-model="service.document" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Tipo de vehículo</label>
                                <input class="form-control" v-model="service.tipo" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Sitio</label>
                                <input class="form-control" v-model="service.sitio" readonly>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Fecha entrada</label>
                                <input class="form-control" v-model="service.fecha" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Hora de entrada</label>
                                <input class="form-control" v-model="service.hora" readonly>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary" @click="onSubmit()">Finalizar Servicio</button></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        required,
        minLength
    } from 'vuelidate/lib/validators'
    import axios from 'axios';
    axios.defaults.withCredentials = true;
    import moment from 'moment';
    import Nav from "@/components/NavComponent.vue";
    import Voucher from "@/components/Voucher.vue";
    export default {
        components: {
            Nav,
            Voucher
        },
        data() {
            return {
                placa: '',
                service: null,
                responseService: null
            }
        },
        validations: {
            placa: {
                required,
                minLength: minLength(6)
            }
        },
        computed: {
            formValid() {
                return this.$v.placa.$invalid;
            }
        },
        methods: {
            getData() {
                axios.post(`${this.baseUrl}/api/get-service`, {
                    placa: this.placa
                }).then((res) => {
                    this.service = res.data;
                    this.service.fecha = moment(res.data.inicio).format("DD [de] MMMM,YYYY");
                    this.service.hora = moment(res.data.inicio).format('hh:mm A');
                }).catch((error) => {
                    console.log(error);
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Opppss!',
                        text: 'No se encontro ningun servicio asociado a esta placa',
                    })
                })
            },
            onSubmit() {
                this.$confirm({
                    message: `Esta seguro de finalizar el servicio?`,
                    button: {
                        no: 'No',
                        yes: 'Si'
                    },
                    callback: confirm => {
                        if (confirm) {
                            axios.post(this.baseUrl + '/api/end-service/' + this.service.service_id, {
                                idType: this.service.idType
                            }).then((res) => {
                                this.responseService = res.data
                                this.responseService.fechaSalida = moment(res.data.exit).format("DD [de] MMMM,YYYY");
                                this.responseService.horaSalida = moment(res.data.exit).format('hh:mm A');
                                this.$refs.modal.showModal(); 
                            }).catch(() => {
                                this.$swal.fire({
                                    icon: 'error',
                                    title: 'Algo ha sucedido, no se pudo finalizar el servicio',
                                })
                            })
                        }
                    }
                })
            },
            finish() {
                this.$swal.fire({
                    icon: 'success',
                    title: 'Perfecto!',
                    text: 'Informacion guardada con exito',
                    showConfirmButton: true,
                });
                setTimeout(() => {
                    location.reload();
                }, 3000)
            }
        },
        watch: {
            placa() {
                this.placa = this.placa.toUpperCase();
            }
        },
    }
</script>
