<template>
    <div>
        <Nav currentPage="4" />
        <div class="container">
            <h1>Sitio mas usado</h1>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-4">Seleccione el rango de fecha, obtendra la informacíon detallada del sitio con mayor tiempo de ocupación.</h5>
                    <form>
                        <Date ref="date" />
                        <div v-if="place">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" readonly v-model="place.name">
                            </div>
                            <div class="form-group">
                                <label>Identificador</label>
                                <input type="text" class="form-control" readonly v-model="place.place_id">
                            </div>
                            <div class="form-group">
                                <label>Cantidad de minutos</label>
                                <input type="text" class="form-control" readonly v-model="place.sm">
                            </div>
                        </div>
                    </form>
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
                place: null
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
                axios.post(this.baseUrl + '/api/get-place-report', {
                    from: this.$refs.date.startDate,
                    to: this.$refs.date.endDate
                }).then((res) => {
                    if(res.data.length < 1){
                        this.$swal.fire({
                        icon: 'error',
                        title: 'No se encontraron registros',
                    })
                    }
                    this.place = res.data[0];

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