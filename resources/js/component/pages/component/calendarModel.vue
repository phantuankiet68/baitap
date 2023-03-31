<template>
   <div class="modal__body__form">
      <form @submit.prevent="saveData()">
         <div class="form__create">
            <input class="border-input" type="text" v-model="form.title"  placeholder="Thêm tiêu đề và thời gian" maxlength="150" /> 
         </div>
         <div class="form__create">
            <a class="form__create-event" >Sự kiện</a>
            <a class="form__create-remindar" @click.prevent="showRemind">Lời nhắc </a>
         </div>
         <div class="form__create">
            <span class="item_icons-2"><i class="fa-sharp fa-solid fa-clock"></i></span>
            <flatPickr class="modelEvents" v-model="form.start"  :config="configs.dateTimePicker"  placeholder="Date Time"/>
            <flatPickr class="modelEvents" v-model="form.end"  :config="configs.dateTimePicker" placeholder="Date Time"/>
         </div>
         <div class="form__create">
            <span class="item_icons-2"><i class="fa-sharp fa-solid fa-bars-staggered"></i></span>
            <input type="text" class="text-input" v-model="form.desc"  placeholder="Thêm mô tả và các tệp đính kèm"  maxlength="250"> 
         </div>
         <hr />
         <div class="form__create">
            <span class="item_icons-2"><i class="fa-solid fa-calendar-days"></i></span>
            <input  type="color" v-model="form.color" class="form__create-color" id="get" />
            <input type="text" id="put" v-model="form.color" class="hiden"/><br />
         </div>
         <div class="form__create">
            <button  class="create" @click.prevent="saveCalendar()">Lưu</button>
         </div>
      </form>
   </div>
 </template>
 <script>
      import flatPickr from 'vue-flatpickr-component';
      import 'flatpickr/dist/flatpickr.css';
      export default {
      name: "EventModel",
      props:{
         form:{
            type: Object,
            default: () =>{}
         },
      },
      components:{
         flatPickr
      },
      data() {
         return {
            datepicker : null,
            configs: {
               dateTimePicker: {
                  enableTime: true,
                  dateFormat: 'Y-m-d H:i'
               },
            }
         }
      },
    
      mounted(){

      },
      methods:{
         closeModal(){
            this.$emit('closeModal')
            this.$emit('closeEdit')
         },
         showRemind(){
            this.$emit('showCR')
         },
         saveCalendar(){
            this.$emit('saveCalendar')
         },
         
         
        
      }
   }
 </script>