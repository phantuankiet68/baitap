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



const menuNav = document.querySelector('.profile');
const clickMenu = document.getElementById("clickMenu");
if(menuNav){
	menuNav.addEventListener('click', function () {
		clickMenu.classList.toggle('open-menu');
	})
}
const menuSelectd = document.querySelector('.selected');
const SelectMenu = document.getElementById("clickSelected");
if(menuSelectd){
	menuSelectd.addEventListener('click', function () {
		SelectMenu.classList.toggle('open-menu');
	})
}


// TOGGLE SIDEBAR
const menuBar = document.querySelector('.menu_hamburger .bx-menu');
const sidebar = document.getElementById('sidebar');

if(menuBar){
	menuBar.addEventListener('click', function () {
		console.log(dd)
	})
}

const prev = document.getElementById('vc-svg-icon');

if(menuBar){
	menuBar.addEventListener('click', function () {
		sidebar.classList.toggle('hide');
	})
}


function fetch()
{
	var get = document.getElementById("get").value;
	document.getElementById("put").value = get;
}





const toggle = document.querySelector(".toggle");
const input = document.querySelector("input");

if(toggle){
    toggle.addEventListener("click", () =>{
		if(input.type ==="password"){
			input.type = "text";
			toggle.classList.replace("uil-eye-slash", "uil-eye");
		}else{
			input.type = "password";
		}
	})
}


