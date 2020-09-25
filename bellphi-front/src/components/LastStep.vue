<template>
    <div class="container mt-5">
        <div class="card bg-light">
            <div class="entrace">
                    <h6 ><i class="fas fa-arrow-up"></i><b>ENTRADA</b><i class="fas fa-arrow-up"></i></h6>
                </div>
            <div class="d-flex justify-content-around mt-4">
                <div class="btn btn-success col-2 empty">A</div>
                <div class="btn btn-success col-2">A</div>
                <div class="btn btn-success col-2">A</div>
                <div class="btn btn-success col-2">A</div>
                <div class="btn btn-success col-2">A</div>
            </div>
            <div class="d-flex justify-content-around mt-3">
                <div class="btn btn-danger col-1 full" >MJH666</div>
                <div class="btn btn-danger col-1">M</div>
                <div class="btn btn-danger col-1">M</div>
                <div class="btn btn-danger col-1">M</div>
                <div class="btn btn-danger col-1">M</div>
                <div class="btn btn-danger col-1">M</div>
                <div class="btn btn-danger col-1">M</div>
                <div class="btn btn-danger col-1">M</div>
                <div class="btn btn-danger col-1">M</div>
                <div class="btn btn-danger col-1">M</div>
            </div>
            <div class="d-flex justify-content-around mt-1">
                <div class="btn btn-success col-1">M</div>
                <div class="btn btn-success col-1">M</div>
                <div class="btn btn-success col-1">M</div>
                <div class="btn btn-success col-1">M</div>
                <div class="btn btn-success col-1">M</div>
                <div class="btn btn-success col-1">M</div>
                <div class="btn btn-success col-1">M</div>
                <div class="btn btn-success col-1">M</div>
                <div class="btn btn-success col-1">M</div>
                <div class="btn btn-success col-1">M</div>
            </div>
            <div class="d-flex justify-content-around mt-3">
                <div class="btn btn-primary col-1">B</div>
                <div class="btn btn-primary col-1">B</div>
                <div class="btn btn-primary col-1">B</div>
                <div class="btn btn-primary col-1">B</div>
                <div class="btn btn-primary col-1">B</div>
                <div class="btn btn-primary col-1">B</div>
                <div class="btn btn-primary col-1">B</div>
                <div class="btn btn-primary col-1">B</div>
                <div class="btn btn-primary col-1">B</div>
                <div class="btn btn-primary col-1">B</div>
            </div>
            <div class="d-flex justify-content-around mt-3 mb-3">
                <div class="btn btn-success col-2">A</div>
                <div class="btn btn-success col-2">A</div>
                <div class="btn btn-success col-2">A</div>
                <div class="btn btn-success col-2">A</div>
                <div class="btn btn-success col-2">A</div>
            </div>

            
        </div>
    </div>
</template>

<script>
    export default {
        props: ['clickedNext', 'currentStep'],
        data() {
            return {
                site: '',
                idType:'',
                idPlace:'23'
            }
        },
        watch: {
            clickedNext() {
                // end form submit, pte capturar valores de los demas steps
            }
        },
        mounted() {
            this.$emit('can-continue', {
                    value: true
                });

        },
        created() {
            switch (this.$route.params.type) {
                case "car":
                    this.idType = 1;
                    break;
                case "motor":
                    this.idType = 2;
                    break;
                case "bicycle":
                    this.idType = 3;
                    break;
            }
        },
    }
</script>

<style >
.full{
    cursor: not-allowed !important;
}
.empty{
    cursor: pointer !important;
}
div.entrace {
  -ms-transform: rotate(90deg);
  transform: rotate(90deg);
}

</style>