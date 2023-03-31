<template>
    <div class="main-form">
            <div class="form_login">
                <h2>Register</h2>
                <ul v-if="Object.keys(errorList).length > 0" class="error-login">
                   <li class="classEoror" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
                </ul>
                <form >
                    <div class="form_login-sub">
                        <input type="text" class="text"  placeholder="Enter your name" v-model="form.name" maxlength="30"/>
                        <div class="form_login-icon">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    <div class="form_login-sub">
                        <input type="text" class="text"  placeholder="Enter your email" v-model="form.email" maxlength="30"/>
                        <div class="form_login-icon">
                           <i class="fa-solid fa-envelope"></i>
                        </div>
                    </div>
                    <div class="form_login-sub">
                        <input :type="passwordFieldType" class="password" name="Password" v-model="form.password" placeholder="Mật khẩu" required="" maxlength="30" />
                        <div class="form_login-icon">
                           <i class="fa fa-unlock-alt before" ></i>
                        </div>
                        <div class="form_login-news">
                           <i class="fa-solid fa-eye after" @click="showEyePass" v-if="showEye"></i>
                           <i class="fa-solid fa-eye-slash after" @click="hidenEyePass" v-if="hideEye"></i>
                        </div>
                    </div>
                    <div class="form_login-sub">
                        <input :type="passwordFieldCPass" class="password" name="Password" v-model="form.c_password" placeholder="Mật khẩu" required="" maxlength="30" />
                        <div class="form_login-icon">
                           <i class="fa fa-unlock-alt before" ></i>
                        </div>
                        <div class="form_login-news">
                           <i class="fa-solid fa-eye after" @click="showEyeCP" v-if="showEyeCPass"></i>
                           <i class="fa-solid fa-eye-slash after" @click="hidenEyeCPass" v-if="hideEyeCPass"></i>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="submit_login">
                        <input type="submit" value="Sign Up" @click.prevent="saveRegister">
                    </div>
                    <div class="submit_login">
                        <router-link to="/"><span>Sign In</span></router-link>
                    </div>
                </form>
                <Loading :active="isLoading" 
                :can-cancel="true" 
                :is-full-page="fullPage"></Loading>
            </div>
        </div>
</template>

<script >
    import Loading from 'vue3-loading-overlay';
    import 'vue3-loading-overlay/dist/vue3-loading-overlay.css';
    export default{
       name:'Register',
       components:{
           Loading
       },
       data(){
           return {
               errorList:'',
               form:{
                   name:'',
                   email:'',
                   password:'',
                   c_password:''
               },
               passwordFieldType: "password",
               showEye:false,
               hideEye:true,
               passwordFieldCPass:"password",
               showEyeCPass:false,
               hideEyeCPass:true,
               isLoading: false,
               fullPage:true,
           }
       }
       ,
       methods:{
            showEyePass() {
                this.showEye = false,
                this.hideEye = true,
                this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
            },
            hidenEyePass() {
                this.showEye = true,
                this.hideEye = false,
                this.passwordFieldType = this.passwordFieldType === "password" ? "text" : "password";
            },
            showEyeCP() {
                this.showEyeCPass = false,
                this.hideEyeCPass = true,
                this.passwordFieldCPass = this.passwordFieldCPass === "password" ? "text" : "password";
            },
            hidenEyeCPass() {
                this.showEyeCPass = true,
                this.hideEyeCPass = false,
                this.passwordFieldCPass = this.passwordFieldCPass === "password" ? "text" : "password";
            },
            /**
             * save data category
             * @author KietPT
             */
            saveRegister(){
                this.isLoading =true;
                var mythis = this;
                axios.post('/api/register', this.form)
                .then(response =>{
                    console.log(response.data)
                    alert(response.data.message);
                    this.form = {
                        name:'',
                        email:'',
                        password:'',
                        c_password:''
                    }
                    setTimeout(() => {this.isLoading = false},2000)
                    this.$router.push({ name: "Login" });
                })
                .catch(function (error){
                    if(error.response){
                        if (error.response.status == 422) {
                            mythis.errorList = error.response.data.errors;
                            mythis.isLoading = false;
                        }
                        else if (error.request) {
                            console.log(error.request);
                        } else {
                            console.log('Error', error.message);
                        }
                    }
                })
            },
          
           
       }

   }
</script>