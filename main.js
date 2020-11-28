function openNav() {
  document.getElementById("myNav").style.width = "100%";
}

function closeNav() {
  document.getElementById("myNav").style.width = "0%";
}

function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
}

function displayIt() {
  document.getElementsByID("myDropdown_Left").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (event) {
  if (!event.target.matches(".dropbtn")) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    var i;
    for (i = 0; i < dropdowns.length; i++) {
      var openDropdown = dropdowns[i];
      if (openDropdown.classList.contains("show")) {
        /// dodałem to
        $(document).on("click", ".allow-focus .dropdown-menu", function (e) {
          e.stopPropagation();
        });
      }
    }
  }
};

/* When the user clicks on the button, 
toggle between hiding and showing the dropdown content */
function displayIt() {
  document.getElementById("myDropdown_Left").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function (e) {
  if (!e.target.matches(".dropdownButton")) {
    var myDropdown = document.getElementById("myDropdown_Left");
    if (myDropdown.classList.contains("show")) {
      myDropdown.classList.remove("show");
    }
  }
};
