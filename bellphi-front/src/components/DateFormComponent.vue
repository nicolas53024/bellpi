<template>
    <div>
        <div class="form-row">
            <div class="form-group col-md-3">
                <label for="inputCity">Fecha inicial</label>
                <input type="date" class="form-control" v-model="startDate">
            </div>
            <div class="form-group col-md-3">
                <label for="inputState">Fecha final</label>
                <input type="date" class="form-control" v-model="endDate">
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';
    export default {
        data() {
            return {
                startDate: '',
                endDate: '',
            }
        },
        created () {
            this.startDate = moment().format('YYYY-MM-DD');
            this.endDate = moment().format('YYYY-MM-DD');
        },
    }
</script>

<style lang="scss" scoped>

</style>