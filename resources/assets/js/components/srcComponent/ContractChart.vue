<script>



import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  mounted () {
    this.getData();
  },
  data: () => ({
    chartdata: {
        hoverBackgroundColor: "red",
        hoverBorderWidth: 10,
        labels: ["Residencial", "Comercial", "Otros"],
        datasets: [
          {
            label: "Project Types",
            backgroundColor: ["#0093b1", "#f79c49"],
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

             this.chartdata.datasets[0].data.push(this.result.residential)
             this.chartdata.datasets[0].data.push(this.result.commercial)
             this.chartdata.datasets[0].data.push(this.result.others)
  
              // console.log(this.chartdata.datasets[0].data);
                  this.renderChart(this.chartdata, this.options)

            });
        },
     }
}
</script>