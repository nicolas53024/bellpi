<template>
    <div>
        <Nav currentPage="4" />
        <div class="container">
            <h1>Entrada y salida de vehículos</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Seleccione el rango de fecha, obtendra la informacíon detallada de ingreso y salida por vehículo.</h5>
                    <Date ref="date" />
                     <div v-if="vehicles">
                        <div v-for="(vehicle,index) in vehicles" :key="index" mb-3>
                            <p>
                                <a class="btn btn-primary" data-toggle="collapse" :href="'#multiCollapseExample'+index" role="button" aria-expanded="false">{{vehicle.placa}}</a>
                            </p>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="collapse multi-collapse" :id="'multiCollapseExample'+index">
                                        <div class="card card-body">
                                            <p v-for="(date,index) in vehicle.services_complete" :key="index">
                                                Entrada:{{date.inicio}} -Salida:{{date.final}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success" @click="checkDate()">Consultar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import Nav from "@/components/NavComponent.vue";
    import Date from "@/components/DateFormComponent.vue";
    import axios from 'axios';
    axios.defaults.withCredentials = true;
    export default {
        components: {
            Nav,
            Date
        },
        data() {
            return {
                vehicles: null
            }
        },
        methods: {
            checkDate() {
                let a = moment(this.$refs.date.startDate);
                let b = moment(this.$refs.date.endDate);
                let differenceTime = b.diff(a, 'days');
                if (differenceTime < 0) {
                    this.$swal({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'La fecha final no puede ser menor a la inicial!',
                    })
                } else {
                    this.getReport();
                }
            },
            getReport() {
                axios.post(this.baseUrl + '/api/get-vehicles-services-report', {
                    from: this.$refs.date.startDate,
                    to: this.$refs.date.endDate
                }).then((res) => {
                    this.vehicles = res.data;
                    if (res.data.length < 1) {
                        this.$swal.fire({
                            icon: 'error',
                            title: 'No se encontraron registros',
                        })
                    }
                }).catch(() => {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Algo ha sucedido, no se pudo actualizar la tarifa',
                    })
                })
            }
        },
    }
</script>

<style lang="scss" scoped>

</style>