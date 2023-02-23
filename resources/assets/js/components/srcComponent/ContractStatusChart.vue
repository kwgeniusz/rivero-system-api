<script>


import { Bar } from 'vue-chartjs'

export default {
  extends: Bar,
  mounted () {
    this.getData();
  },
  data: () => ({
    chartdata: {
        hoverBackgroundColor: "red",
        hoverBorderWidth: 10,
        labels: ["Vacantes", 
        "Iniciados",
        "Listo Pero Pendiente por Pago",
        "Procesamiento de Permiso",
        "Esperando por Cliente",
        "Descargando Archivos",
        "Enviado A Oficina de ventas",
        "En Cola de Produccion","Enviado al Ingeniero"
        ],
        datasets: [
          {
            label: "Cantidad",
            backgroundColor: ["#3c8ddc","#2ab25b","#cbb956","#f39c12","red","#666666","#5dc1b9","#7d2181","#804000"],
            data: []
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    },

  }),
   props: {
           prefUrl: { type: String,default:null},
           router: "",
           // title: "",
          },
    methods: {
        getData: function (){
         var url = this.prefUrl+this.router;
            axios.get(url).then(response => {
              this.result = response.data;
       

             this.chartdata.datasets[0].data.push(this.result.vacant)
             this.chartdata.datasets[0].data.push(this.result.started)
             // this.chartdata.datasets[0].data.push(this.result.finished)
             // this.chartdata.datasets[0].data.push(this.result.cancelled)
             this.chartdata.datasets[0].data.push(this.result.readyButPendingPayable)
             this.chartdata.datasets[0].data.push(this.result.processingPermit)
             this.chartdata.datasets[0].data.push(this.result.waitingClient)
             this.chartdata.datasets[0].data.push(this.result.downloadingFiles)
             this.chartdata.datasets[0].data.push(this.result.sentToOffice)
             this.chartdata.datasets[0].data.push(this.result.inProductionQueue)
             this.chartdata.datasets[0].data.push(this.result.sentToEngineer)
  
              // console.log(this.chartdata.datasets[0].data);
             this.renderChart(this.chartdata, this.options)

            });
        },
     }
}
</script>