
<template> 
  <form class="inputother boxes2">
    <hr>
    <label for="modelSubcontId">Lista de Subcontractistas:</label>
    <select v-model="modelSubcontId"  class="form-control" name="modelSubcontId" id="modelSubcontId">
        <option value="">N/A</option>
        <option v-for="(item,index) in subcontractors" :value="item.subcontId" > {{item.name}}</option>
    </select>
      <button class="submit" @click.prevent="addSubcontractor()"> 
        <span class="fa fa-plus" aria-hidden="true"></span> Agregar
      </button>
  </form>    
 </template>



 <script>

export default {

     mounted() {
            console.log('Component ProposalSubcontractor mounted.')
            this.getAllSubcontractors();
        },
    data: function() {
        return {
            errors: [],
            
            modelSubcontId: this.proposal.subcontId,
            subcontractors: {},
        }
    },
  props: {
           proposal: { type: Object},
    },
    methods: {
         getAllSubcontractors: function (){
            let url ='subcontractors';
            axios.get(url).then(response => {
             this.subcontractors = response.data.data
             // console.log(this.subcontractors)
            });
        },
        addSubcontractor: function() {
        //ejecuta la funciona que esta en el componente hijo Proposal Notes
          axios.put('proposal/'+this.proposal.proposalId+'/update-subcontractor',{
              subcontId:   this.modelSubcontId,
            }).then(response => {
                       if (response.data.alertType == 'success') {
                         toastr.success(response.data.message)
                       } else {
                          toastr.error(response.data.message)
                       }
            })

          },
    } //end vue methods
      
  }
 </script>
  