<template>
  <div class="modal" tabindex="-1" role="dialog" id="modal">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img alt="Vue logo" src="../assets/park.svg" width="50px" />
          <h5 class="modal-title">Recibo de salida</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <div class="modal-body" v-if="serviceProp && responseServiceProp">
          <div class="card">
            <div class="card-body">
              <div class="row d-flex justify-content-between">
                <p><strong>Recibo #:</strong>{{serviceProp.service_id}}</p>
                <p><strong>Sitio:</strong>{{serviceProp.sitio}}</p>
                <p><strong>Vehículo:</strong>{{serviceProp.tipo}}</p>
              </div>
              <div class="row d-flex justify-content-between">
                <p><strong>Nombre :</strong>{{serviceProp.username}}</p>
                <p><strong>Documento :</strong>{{serviceProp.document}}</p>
                <p><strong>Placa :</strong>{{serviceProp.placa}}</p>
              </div>
              <div class="row d-flex justify-content-between">
                <p><strong>Fecha ingreso:</strong>{{serviceProp.fecha}}</p>
                <p><strong>Hora ingreso :</strong>{{serviceProp.hora}}</p>
              </div>
              <div class="row d-flex justify-content-between">
                <p><strong>Fecha salida:</strong>{{responseServiceProp.fechaSalida}}</p>
                <p><strong>Hora salida :</strong>{{responseServiceProp.horaSalida}}</p>
              </div>
              <div class="row d-flex justify-content-between">
                <p><strong>Total minutos:</strong>{{responseServiceProp.minuts}}</p>
                <p><strong>Precio inicial :</strong>${{responseServiceProp.amount}}</p>
                <p><strong>Descuento de {{responseServiceProp.percent}}%: </strong>${{responseServiceProp.discount}}</p>
              </div>
              <div class="row d-flex justify-content-between">
                <p><strong>Total a pagar:</strong>${{responseServiceProp.final_amount}}</p>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" @click="endService()">Aceptar</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      responseServiceProp: Object,
      placaProp: String,
      serviceProp: Object
    },
    methods: {
      endService() {
        $('#modal').hide();
        this.$emit('finalizar');
      },
      showModal(){
       $('#modal').modal('show');
      }
    },
  }
</script>

