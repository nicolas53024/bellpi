<template>
    <div>
        <Nav currentPage="register" />
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
    export default {
        components: {
            Nav,
            HorizontalStepper
        },
        data() {
            return {
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

            }
        }
    }
</script>