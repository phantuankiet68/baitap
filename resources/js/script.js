const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});



const menuSibar = document.querySelector("#sidebar .create");
const subMenu = document.getElementById("subMenu");

menuSibar.addEventListener('click', function () {
	subMenu.classList.toggle('open-menu');
})
const menuNav = document.querySelector('.profile');
const clickMenu = document.getElementById("clickMenu");

menuNav.addEventListener('click', function () {
	clickMenu.classList.toggle('open-menu');
})
const menuSelectd = document.querySelector('.selected');
const SelectMenu = document.getElementById("clickSelected");

menuSelectd.addEventListener('click', function () {
	SelectMenu.classList.toggle('open-menu');
})



// TOGGLE SIDEBAR
const menuBar = document.querySelector('.menu_hamburger .bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})


function fetch()
{
	var get = document.getElementById("get").value;
	document.getElementById("put").value = get;
}





const toggle = document.querySelector(".toggle"),
input = document.querySelector("input");

toggle.addEventListener("click", () =>{
	if(input.type ==="password"){
	  input.type = "text";
	  toggle.classList.replace("uil-eye-slash", "uil-eye");
	}else{
	  input.type = "password";
	}
})