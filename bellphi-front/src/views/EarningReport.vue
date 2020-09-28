<template>
    <div>
        <Nav currentPage="4" />
        <div class="container">
            <h1>Ganacias</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Seleccione el rango de fecha, obtendra el valor recaudado por día.</h5>
                    <Date ref="date" />
                    <div v-if="earnings">
                        <div class="form-row" v-for="(earning,index) in earnings" :key="index">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Fecha</label>
                                <input type="text" class="form-control" readonly :value="earning.fecha">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Ganancias</label>
                                <input type="text" class="form-control" readonly :value="'$'+earning.amount">
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
                earnings: null
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
                axios.post(this.baseUrl + '/api/earning-report', {
                    from: this.$refs.date.startDate,
                    to: this.$refs.date.endDate
                }).then((res) => {
                    this.earnings = res.data;
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