
<template> 

<div id="people">
  <v-client-table :data="tableData" :columns="columns" :options="options">
      

  </v-client-table>
</div>

 </template>

 <script>
   

export default {
    data:function () {
        return {
        columns: ['id', 'name', 'age'],
        tableData: [
            { id: 1, name: "John", age: "20" },
            { id: 2, name: "Jane", age: "24" },
            { id: 3, name: "Susan", age: "16" },
            { id: 4, name: "Chris", age: "55" },
            { id: 5, name: "Dan", age: "40" },
              { id: 1, name: "John", age: "20" },
            { id: 2, name: "Jane", age: "24" },
            { id: 3, name: "Susan", age: "16" },
            { id: 4, name: "Chris", age: "55" },
            { id: 5, name: "Dan", age: "40" },
              { id: 10, name: "John", age: "20" },
            { id: 2, name: "Jane", age: "24" },
            { id: 3, name: "Susan", age: "16" },
            { id: 4, name: "Chris", age: "55" },
            { id: 5, name: "Dan", age: "40" },
              { id: 1, name: "John", age: "20" },
            { id: 2, name: "Jane", age: "24" },
            { id: 3, name: "Susan", age: "16" },
            { id: 4, name: "Chris", age: "55" },
            { id: 5, name: "Dan", age: "40" }
        ],
       options: {
           headings: {
            id: 'CODIGO',
            name: 'NOMBRE',
            age: 'EDAD'
           },
            sortable: ['name', 'id'],
            filterable: ['name', 'id'],
            // EDITABLE TEXT OPTIONS:
            texts: {
                count: "Mostrar del {from} al {to} de {count} registros|{count} registros|One record",
                first: 'Primero',
                last: 'Ultimo',
                filter: "Filtrado:",
                filterPlaceholder: "Buscar",
                limit: "Records:",
                page: "Pagina:",
                noResults: "No Se encontraron Registros",
                filterBy: "Filter by {column}",
                loading: 'Cargando...',
                defaultOption: 'Select {column}',
                columns: 'Columns',
                  limit:"Limi:",
            },
        }
    }
}

}
 </script>
  