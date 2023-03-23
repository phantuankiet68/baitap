<template>

    <div class="modal">
         <div class="modal__body">
            <div class="form__center">
               <span @click.prevent="closeCR"><i class="fa-solid fa-xmark"></i></span>
               <strong><i class="fa-solid fa-bars"></i></strong>
             </div>
             <ul class="alert alert-warning"  v-if="Object.keys(errorList).length > 0">
                  <li  style="color: red;" v-for="(error, index) in errorList" :key="index">{{ error[0] }}</li>
             </ul>
             <div class="modal__body__form">
                 <form >
                     <div class="form__create">
                        <input class="border-input"  type="text" v-model="remind.title" placeholder="Thêm tiêu đề" maxlength="150"> 
                     </div>
                      <div class="form__create">
                        <a class="form__create-remindar ">Sự kiện</a>
                        <a class="form__create-event">Lời nhắc</a>
                     </div>
                     <div class="form__create">
                        <span class="item_icons-1"><i class="fa-sharp fa-solid fa-clock"></i></span>
                        <VueDatePicker class="form-control" mode="dateTime" v-model="remind.start" auto-apply/>
                     </div>
                     <div class="form__create">
                        <button  class="create" @click.prevent="saveRemind()">Lưu</button>
                     </div>
                 </form>
             </div>
         </div>
    </div>
 </template>

 <script>

   import VueDatePicker from '@vuepic/vue-datepicker';
   import '@vuepic/vue-datepicker/dist/main.css'

   export default{
      name: "Model",
      props:{
         remind:{
            type: Object,
            default: () =>{}
         }
      },
      components:{
         VueDatePicker
      },
      data() {
         return {
             errorList:'',
         }
      },
      methods:{  

         closeCR(){
            this.$emit('closeCR')
         },
         saveRemind(){
            this.$emit('saveRemind')
         },
   }
}
 </script>