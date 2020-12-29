<template>
    <div class="container">
        <label>Select File</label>
		<input type="file" name="fileToUpload1" id="fileToUpload1"> <br> <br>
		<progress :value="percent" max="100"> </progress> % {{percent}}
		<br><br>
		{{message}}
		<br><br>
		<button type="button" @click="upload" class="btn btn-secondary">Upload Now</button>
    </div>
</template>

<script>
    export default {

        data(){
            return{
                message: '',
                percent: 0
            }
        },
        mounted() {
            console.log('Component mounted.')
        },

        methods:{

            upload(){

                var vm = this;

                var elmnt = document.getElementById("fileToUpload1");
                console.log(elmnt.files[0]);

                var fd = new FormData();


                fd.append("file1", elmnt.files[0], elmnt.files[0].name)


                axios.post("/upload", fd, {
                onUploadProgress: function(uploadEvent){

                        vm.percent = Math.round((uploadEvent.loaded / uploadEvent.total)*100);
                    }
                })
                .then(function(res){
                    console.log(res);
                    vm.message = res.data.message;
                })
                .catch(function(e){
                    console.log(e);
                });

                console.log( 'upload...' );
            }
        }
    }
</script>
