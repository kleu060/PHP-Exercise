<template>
  <div class="import-csv">
    <h3>Company Average Salary</h3>
    <table id="employee-table">
      <thead>
        <tr>
          <th>Company</th>
          <th>Average Salary</th>

        </tr>
        <tr v-for="average in salary" :key="average.company_name">
          <td>{{ average.company_name }}</td>
          <td>${{ average.average }}</td>
        </tr>
      </thead>
      
    </table>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ImportCSV',

  data() {
    return{
      salary: [],
    }
  },
  mounted() {
    this.getCompanySalary();
  },
  methods: {

    getCompanySalary(){
      axios.get(process.env.VUE_APP_BACKEND_HOST+ 'app/get.php?action=getCompanySalaryAverage',
      {
        
      })
      .then(( response ) => {
        console.log(response.data);
        this.salary = response.data
      })
      .catch( (error) => {
        console.log(error);
      });
    },
    refreshContent() {
      console.log('Refresh Content');
      this.getCompanySalary();
    },
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

#employee-table{
  border:1px solid #000;
  border-collapse: collapse;
}

#employee-table tr th, #employee-table tr td{
  border:1px solid #000;
  
  padding:10px;
} 
</style>