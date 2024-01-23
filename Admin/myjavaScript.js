let close_menu_btn = document.querySelector(".close-menu-btn");
let sidebar = document.querySelector(".Sidebar-menu");
let open_menu_btn = document.querySelector(".open-menu-btn");
let convertContainerDiv = document.querySelector(".container");
close_menu_btn.addEventListener('click',function(){
    sidebar.style.marginLeft = "-250px";
    open_menu_btn.style.display="inline-block";
})
open_menu_btn.addEventListener('click',function(){
    sidebar.style.marginLeft = "0px";
    open_menu_btn.style.display="none";
})
