<template>
    <div>
        <Nav currentPage="0" />
        <div class="container mt-10">
            <h2 class="mb-5"> Seleccione un tipo de vehículo</h2>
            <div class="card-group  justify-content-center d-inline-flex">
                <router-link :to="{name:'Stored', params:{type: 'car' }}">
                    <div class="card ml-lg-4 margin-sm-2 custom-card-group">
                        <div class="card-body">
                            <h1><i class="fas fa-car fa-4x"></i></h1>
                            <h5 class="card-title">Automóvil</h5>
                        </div>
                    </div>
                </router-link>
                <router-link :to="{name:'Stored', params:{type: 'motor' }}">
                    <div class="card ml-lg-4 custom-card-group margin-sm-2 ">
                        <div class="card-body">
                            <h1><i class="fas fa-motorcycle fa-4x"></i></h1>
                            <h5 class="card-title">Moto</h5>
                        </div>
                    </div>
                </router-link>
                <router-link :to="{name:'Stored', params:{type: 'bicycle' }}">
                    <div class="card ml-lg-4 custom-card-group margin-sm-2 ">
                        <div class="card-body">
                            <h1><i class="fas fa-bicycle fa-4x"></i></h1>
                            <h5 class="card-title">Bicicleta</h5>
                        </div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import Nav from "@/components/NavComponent.vue";
    export default {
        components: {
            Nav
        }
    }
</script>

<style >
.custom-card-group{
    min-width: 250px;
}
</style>