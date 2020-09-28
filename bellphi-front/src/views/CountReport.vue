<template>
    <div>
        <Nav currentPage="4" />
        <div class="container">
            <h1>Cantidad de vehículos</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Seleccione el rango de fecha, obtendra el numero de vehículos ingresados especificando el tipo.</h5>
                    <Date ref="date" />
                    <div v-if="types">
                        <div class="form-row" v-for="(type,index) in types" :key="index">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Tipo de vehículo</label>
                                <input type="text" class="form-control" readonly :value="type.tipo">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Cantidad</label>
                                <input type="text" class="form-control" readonly :value="type.cantidad">
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
    import Nav from "@/components/NavComponent.vue";
    import Date from "@/components/DateFormComponent.vue";
    import moment from 'moment';
     import axios from 'axios';
    axios.defaults.withCredentials = true;
    export default {
        components: {
            Nav,
            Date
        },
        data() {
            return {
                types: null
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
                axios.post(this.baseUrl + '/api/count-vehicles-report', {
                    from: this.$refs.date.startDate,
                    to: this.$refs.date.endDate
                }).then((res) => {
                    this.types = res.data;
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