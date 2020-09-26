<template>
    <div class="container mt-5">
        <div class="card bg-light custom-card ">
            <div class="entrace position-absolute">
                <h6 class="my-arrow"><i class="fas fa-arrow-up"></i><strong>ENTRADA</strong><i class="fas fa-arrow-up"></i></h6>
            </div>
            <div class="d-flex justify-content-between  p-0 mb-3">
                <div class="btn  col-2" v-for="(auto,index) in automoviles[0]" :key="index" :class="{'full btn-danger':auto.vehicle_id,'btn-success':!auto.vehicle_id,'full':auto.type_vehicle_id !=idType}
                            " @click="selectPlace(auto)">
                    <small v-if="auto.vehicle_id">{{auto.vehicle_id}}</small>
                    <small v-else>{{auto.name}}</small>
                </div>
            </div>
            <div class="d-flex justify-content-between  mb-1" v-for="(chunk,index) in motos" :key="index">
                <div class="btn  col-1" v-for="(moto,indexChunk) in chunk" :key="indexChunk" :class="{'full btn-danger':moto.vehicle_id,'btn-success':!moto.vehicle_id,'full':moto.type_vehicle_id !=idType}
                            " @click="selectPlace(moto)">
                    <small v-if="moto.vehicle_id">{{moto.vehicle_id}}</small>
                    <small v-else>{{moto.name}}</small>
                </div>
            </div>
            <div class="d-flex justify-content-between mb-2 mt-2 ml-5">
                <img alt="Vue logo" src="../assets/arrow.svg" width="50px" />
            </div>
            <div class="d-flex justify-content-between mb-3">
                <div class="btn  col-1" v-for="(bicicleta,index) in bicicletas" :key="index" :class="{'full btn-danger':bicicleta.vehicle_id,'btn-success':!bicicleta.vehicle_id,'full':bicicleta.type_vehicle_id !=idType}
                            " @click="selectPlace(bicicleta)">
                    <small v-if="bicicleta.vehicle_id">{{bicicleta.vehicle_id}}</small>
                    <small v-else>{{bicicleta.name}}</small>
                </div>
            </div>
            <div class="d-flex justify-content-between ">
                <div class="btn  col-2" v-for="(auto,index) in automoviles[1]" :key="index" :class="{'full btn-danger':auto.vehicle_id,'btn-success':!auto.vehicle_id,'full':auto.type_vehicle_id !=idType}
                            " @click="selectPlace(auto)">
                    <small v-if="auto.vehicle_id">{{auto.vehicle_id}}</small>
                    <small v-else>{{auto.name}}</small>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';
    axios.defaults.withCredentials = true;
    export default {
        props: ['clickedNext', 'currentStep'],
        data() {
            return {
                placeName: '',
                idType: '',
                automoviles: [],
                motos: [],
                bicicletas: []
            }
        },
        mounted() {
            this.$emit('can-continue', {
                value: true
            });
        },
        created() {
            this.idType = this.getTypeVehicle(this.$route.params.type);
            this.getPlaces();
        },
        methods: {
            getPlaces() {
                axios.get(this.baseUrl + '/api/get-places').then((res) => {
                    this.automoviles = _.map(res.data, function(o) {
                        if (o.type_vehicle_id == 1) return o;
                    });
                    this.motos = _.map(res.data, function(o) {
                        if (o.type_vehicle_id == 2) return o;
                    });
                    this.bicicletas = _.map(res.data, function(o) {
                        if (o.type_vehicle_id == 3) return o;
                    });
                    this.automoviles = _.chunk(_.without(this.automoviles, undefined), 5)
                    this.motos = _.chunk(_.without(this.motos, undefined), 10)
                    this.bicicletas = _.without(this.bicicletas, undefined)
                })
            },
            selectPlace(val) {
                if (val.type_vehicle_id == this.idType) {
                    this.$store.commit('SET_PLACE', val.id);
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Perfecto!',
                        text: "Has escogido el "+val.name+" como sitio de parqueo,ahora da click en finalizar",
                        showConfirmButton: true,
                    })
                }
            }
        },
    }
</script>

<style lang="scss">
    .full {
        cursor: not-allowed !important;
    }
    .empty {
        cursor: pointer !important;
    }
    div.entrace {
        -ms-transform: rotate(90deg);
        transform: rotate(90deg);
        top: 35%;
        left: -30px;
    }
    .custom-card {
        padding-left: 50px;
        padding-right: 15px;
        padding-top: 15px;
        padding-bottom: 15px;
    }
    .arrow-custom {
        left: 15px;
        top: -5px;
    }
</style>