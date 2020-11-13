<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  mounted () {
    this.getData();
    this.renderChart(this.chartdata, this.options)
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
            data: [10,10,10]
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
              this.result =response.data;

              console.log(this.result );
              // console.log(this.result.residential);

            });
        },
     }
}
</script>