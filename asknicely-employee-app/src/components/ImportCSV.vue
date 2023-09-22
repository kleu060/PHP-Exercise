<template>
  <div class="import-csv">
    <h3>Import CSV</h3>
    <input type="file" id="file" ref="file" />
    <button type="button" @click='uploadFile()' id="btn-upload" name="btn-upload">Submit</button>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ImportCSV',
  props: {
  },
  data() {
    return{
      file: "",
    }
  },
  methods: {
    uploadFile: function(){
      console.log(process.env.VUE_APP_BACKEND_HOST)

      this.file = this.$refs.file.files[0];
      console.log(this.file);

      let formData = new FormData();
      formData.append('file', this.file);
      formData.append('action', "importcsv");
      
      console.log("url: " + process.env.VUE_APP_BACKEND_HOST+ 'app/post.php');
      axios.post(process.env.VUE_APP_BACKEND_HOST+ 'app/post.php', formData,
      {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      })
      .then( (response) => {

        if(response.data){
            alert(response.data.employee_added + " employees were added");
            this.$emit('refresh-content');
        }else{
            alert('Error import CSV!');
        }

      })
      .catch((error) => {
          alert(error.response.data.message);
      });

    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h3 {
  margin: 40px 0 0;
}

</style>
