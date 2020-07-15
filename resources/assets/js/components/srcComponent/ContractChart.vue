<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  data: () => ({
    chartdata: {
        hoverBackgroundColor: "red",
        hoverBorderWidth: 10,
        labels: ["Residencial", "Comercial", "Otros"],
        datasets: [
          {
            label: "Project Types",
            backgroundColor: ["#0093b1", "#f79c49"],
            data: [10, 100, 20]
        }
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false
    }
  }),
  mounted () {
    this.renderChart(this.chartdata, this.options)
  }
}
</script>