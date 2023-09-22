<template>
  <div class="import-csv">
    <h3>Employees</h3>
    <table id="employee-table">
      <thead>
        <tr>
          <th>Company</th>
          <th>Name</th>
          <th>Email</th>
          <th>Salary</th>
        </tr>
        <tr v-for="employee in employees" :key="employee.id">
          <td>{{ employee.company.company_name }}</td>
          <td>{{ employee.employee_name }}</td>
          <td><input type="text" v-model="employee.email_address"/><button  @click="updateEmail(employee.id, employee.email_address)">Update Email</button></td>
          <td>${{ employee.salary }}</td>
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
      employees: [],
    }
  },
  mounted() {
    this.getAllEmployees();
  },
  methods: {
    getAllEmployees(){
      console.log("Employee Table Mount");
      axios.get(process.env.VUE_APP_BACKEND_HOST+ 'app/get.php?action=getemployee',
      {
      
      })
      .then(( response ) => {
        this.employees = response.data;
        console.log(this.employees);
        // console.log(this.employees);
      })
      .catch( (error) => {
        console.log(error);
      });
    },
    updateEmail(employee_id, email){
      axios.post(process.env.VUE_APP_BACKEND_HOST+ 'app/post.php',
      {
        action: 'updateEmployeeEmail',
        employee_id : employee_id,
        email_address: email,
      },{
        headers: {
          'Content-Type': 'multipart/form-data'
        },
      })
      .then(( response ) => {
        if(response.data.status == true){
            alert('Employee Email updated!');
        }else{
            alert('Employee Email failed to update!');
        }
      })
      .catch( (error) => {
        console.log(error);
      });
    },
    refreshContent() {
      console.log('Refresh Content');
      this.getAllEmployees();
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
