const searchBar = document.querySelector(".search input"),
  searchBtn = document.querySelector(".search button"),
  usersList = document.querySelector(".users-list");


searchBtn.onclick = () => {
  searchBar.classList.toggle("active");
  searchBar.focus();
  searchBtn.classList.toggle("active");
  // document.body.style.backgroundColor = "red"
}



setInterval(() => {
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "usersback.php", true);
  xhr.onload = () => {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        let data = xhr.response;
        if (!searchBar.classList.contains("active")) {
          usersList.innerHTML = data;
          console.log("done")
        }
      }
    }
  }
  xhr.send();
}, 2000);
document.getElementsByClassName("logout-button")[0].addEventListener("click", () => {
  document.getElementsByClassName("logout")[0].style.visibility = "visible"
})
document.getElementsByClassName("stay")[0].addEventListener("click", () => {
  document.getElementsByClassName("logout")[0].style.visibility = "hidden"
})

document.addEventListener("DOMContentLoaded", function () {
  const gearIcon = document.querySelector(".setting svg");

  gearIcon.addEventListener("click", function () {
    gearIcon.classList.toggle("rotate");
    // Change to any color you want
  });

  const stayButton = document.querySelector(".stay");
  const logoutOverlay = document.querySelector(".logout");

  stayButton.addEventListener("click", function () {
    logoutOverlay.style.visibility = "hidden";
  });

  function lastse() {
    axios.post("features.php", {

    })
      .then(function (response) {
        alert("Last seen done");
      })
      .catch(function (error) {
        alert("Not saved man");
      })
  }
});



