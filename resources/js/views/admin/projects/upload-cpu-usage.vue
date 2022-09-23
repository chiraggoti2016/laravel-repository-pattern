<template>
    <div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-md-6 d-flex justify-content-start align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Upload CPU Usage</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-3 d-flex justify-content-start align-items-center">
                        <form :action="'/admin/project/'+this.$route.params.slug+'/upload/cpu-usage/'" enctype="multipart/form-data" method="POST">
                            <input type="hidden" name="_token" :value="csrf">                    
                            <input type="file" name="file" class="mb-2 mr-sm-2 mb-sm-0" />
                            <input type="submit" name="submit" class="mb-2 mr-sm-2 mb-sm-0" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { reactive, toRefs } from "vue";
 
export default {
    name: "Project",
    data() {
        return {          
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),  
            busy: false,
        };
    },
    components: {
        
    },
    async mounted() {
        console.log(this.$route.params);
    },
    methods: {},
};
</script>