<template>
    <div>
      <color-picker
        v-model:pureColor="pureColor"
        v-model:gradientColor="gradientColor"
      />
    </div>
  </template>
  
  <script>
  import { ref } from "vue";
  import { ColorPicker } from "vue3-colorpicker";
  import "vue3-colorpicker/style.css";
  
  export default {
    components: { ColorPicker },
    setup() {
      const pureColor = ref("red");
      const gradientColor = ref(
        "linear-gradient(0deg, rgba(0, 0, 0, 1) 0%, rgba(0, 0, 0, 1) 100%)"
      );
  
      return { pureColor, gradientColor };
    },
  };
  </script>
  
  <style>
  .demo1 {
    width: 50px;
    height: 50px;
  }
  .demo2 {
    width: 100px;
    height: 100px;
  }
  .demo3 {
    width: 200px;
    height: 200px;
  }
  </style>