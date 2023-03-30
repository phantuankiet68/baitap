<template>
		<a href="#" class="brand">
            <i class="fa fa-solid fa-bars bx-menu"></i>
			<img src="../../image/logo.png">
			<span class=".text-title">Lịch</span>
		</a>
		<div class="create">
			<div href="" class="create_choose" >
				<svg width="36" height="36" viewBox="0 0 36 36"><path fill="#34A853" d="M16 16v14h4V20z"></path><path fill="#4285F4" d="M30 16H20l-4 4h14z"></path><path fill="#FBBC05" d="M6 16v4h10l4-4z"></path><path fill="#EA4335" d="M20 16V6h-4v14z"></path><path fill="none" d="M0 0h36v36H0z"></path></svg>
			    <span class="create_text" @click="createPopup" >Create</span>
			</div>
		</div>
</template>
<script>
   export default{
        name: 'Sidebar',
        props:{
            type: Object, 
            default: () =>{},
        },
        data(){
              return{
                
              }
        },
        methods:{
            createPopup(){
                this.$emit('createPopup')
            },
        }
   }
</script>