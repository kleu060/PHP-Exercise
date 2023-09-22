<template>
  <h1>Ask Nicely</h1>
  <ImportCSV @refresh-content="callRefreshContent"></ImportCSV>
  <EmployeeTable ref="employeeTable"></EmployeeTable>
  <AverageSalary  ref="averageSalary"></AverageSalary>
</template>

<script>
import ImportCSV from './components/ImportCSV.vue'
import EmployeeTable from './components/EmployeeTable.vue'
import AverageSalary from './components/AverageSalary.vue'

export default {
  name: 'App',
  components: {
    ImportCSV, EmployeeTable, AverageSalary
  },
  mount() {

  },
  methods:{
    callRefreshContent(){
      this.$refs.employeeTable.refreshContent();
      this.$refs.averageSalary.refreshContent();
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
