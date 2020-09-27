<template>
    <div>
        <Nav currentPage="0" />
        <div class="container mt-5">
            <section class="section">
                <div class="container">
                    <div class="columns">
                        <div class="column is-8 is-offset-2">
                            <horizontal-stepper :steps="demoSteps" @completed-step="completeStep" @active-step="isStepActive" @stepper-finished="alert">
                            </horizontal-stepper>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    import Nav from "@/components/NavComponent.vue";
    import HorizontalStepper from 'vue-stepper';
    import StepOne from '@/components/StepOne.vue';
    import StepTwo from "@/components/StepTwo.vue";
    import LastStep from "@/components/LastStep.vue";
    import axios from 'axios';
    axios.defaults.withCredentials = true;
    export default {
        components: {
            Nav,
            HorizontalStepper,
        },
        data() {
            return {
                service: {},
                idType: '',
                demoSteps: [{
                        icon: 'edit',
                        name: 'first',
                        title: 'Placa',
                        subtitle: 'Ingrese placa del vehículo',
                        component: StepOne,
                        completed: false
                    },
                    {
                        icon: 'person',
                        name: 'second',
                        title: 'Datos de usuario',
                        component: StepTwo,
                        completed: false
                    },
                    {
                        icon: 'local_parking',
                        name: 'three',
                        title: 'Ubicación',
                        subtitle: 'Puede escoger el sitio de parqueo, sino el sistema asignara uno',
                        component: LastStep,
                        completed: false
                    }
                ],
                activeStep: 0
            }
        },
        methods: {
            // Executed when @completed-step event is triggered
            completeStep(payload) {
                this.demoSteps.forEach((step) => {
                    if (step.name === payload.name) {
                        step.completed = true;
                    }
                })
            },
            // Executed when @active-step event is triggered
            isStepActive(payload) {
                this.demoSteps.forEach((step) => {
                    if (step.name === payload.name) {
                        if (step.completed === true) {
                            step.completed = false;
                        }
                    }
                })
            },
            // Executed when @stepper-finished event is triggered
            alert(payload) {
                console.log(payload);
                this.service.user = this.$store.state.customer;
                this.service.placa = this.$store.state.placa;
                this.service.idPlace = this.$store.state.idPlace;
                this.service.typeVehicle = this.getTypeVehicle(this.$route.params.type);
                axios.post(this.baseUrl + '/api/store-service', {
                    service: this.service
                }).then((res) => {
                    var data=`Se ha guardado el servicio con exito.`
                    if(res.data.name){
                     data=`Se ha guardado el servicio con exito, el sistema ha asignado ${res.data.name} como sitio de parqueo.`
                    }
                    this.$swal.fire({
                        icon: 'success',
                        title: 'Perfecto!',
                        text: data,
                        showConfirmButton: true,
                    });
                    setTimeout(() => {
                       location.reload();
                    }, 3000)
                }).catch(() => {
                    this.$swal.fire({
                        icon: 'error',
                        title: 'Algo ha sucedido, no se pudo guardar el servicio',
                    })
                })
            },
        }
    }
</script>