<template>
<div class="modal__body__form">
   <form >
      <div class="form__create">
         <input class="border-input"  type="text" v-model="remind.title" placeholder="Thêm tiêu đề" maxlength="150"> 
      </div>
      <div class="form__create">
         <a class="form__create-remindar" @click.prevent="showEvents">Sự kiện</a>
         <a class="form__create-event">Lời nhắc</a>
      </div>
      <div class="form__create">
         <span class="item_icons-1"><i class="fa-sharp fa-solid fa-clock"></i></span>
         <flatPickr class="modelEvents" v-model="remind.start"  :config="configs.dateTimePicker"  placeholder="Date Time"/>
      </div>
      <div class="form__create">
         <button  class="create" @click.prevent="saveRemind()">Lưu</button>
      </div>
   </form>
</div>
 </template>

 <script>

   import flatPickr from 'vue-flatpickr-component';
   import 'flatpickr/dist/flatpickr.css';

   export default{
      name: "remindModel",
      props:{
         remind:{
            type: Object,
            default: () =>{}
         }
      },
      components:{
         flatPickr 
      },
      data() {
         return {
            errorList:'',
            configs: {
               dateTimePicker: {
                  enableTime: true,
                  dateFormat: 'Y-m-d H:i'
               },
            }
         }
      },
      methods:{  
         showEvents(){
            this.$emit('showEvents')
         },
         closeCR(){
            this.$emit('closeCR')
         },
         saveRemind(){
            this.$emit('saveRemind')
         },
   }
}
 </script>