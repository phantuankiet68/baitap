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
            <VueDatePicker mode="date"  v-model="form.start"  max-range="7" min-range="3"  :multiple= "true" vertical />
            <VueDatePicker  mode="date" v-model="form.end"   max-range="7" min-range="3" vertical/>
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

      import VueDatePicker from '@vuepic/vue-datepicker';
      import '@vuepic/vue-datepicker/dist/main.css'
      
      export default {
      name: "EventModel",
      props:{
         form:{
            type: Object,
            default: () =>{}
         },
      },
      components:{
         VueDatePicker,
      },
      data() {
         return {
             datepicker : null
         }
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