document.addEventListener("DOMContentLoaded", function () {
    const gearIcon = document.querySelector(".setting svg");
    const settings = document.querySelector(".settingsdispl");

    gearIcon.addEventListener("click", function () {
        gearIcon.classList.add("rotate");
        settings.classList.toggle("active");
    });
    setInterval(() => {
        gearIcon.classList.remove("rotate")
        // console.log("gear")
    }, 7000);
    const stayButton = document.querySelector(".stay");
    const logoutOverlay = document.querySelector(".logout");

    stayButton.addEventListener("click", function () {
        logoutOverlay.style.visibility = "hidden";
    });
});

function toggleLastSeen() {
    const isActive = document.querySelector('#last-seen-checkbox').checked;

    axios.post('lastse.php', {

    })
        .then(function (response) {
            console.log("Last seen status updated successfully");
        })
        .catch(function (error) {
            console.error("Error updating last seen status:", error);
            alert("Failed to update last seen status");
        });
}

function toggleDarkMode() {
    document.body.classList.toggle("darkmode");
    const wrapper = document.querySelector(".wrapper");
    wrapper.classList.toggle("darkmode");
}

const cro = document.querySelector(".del svg")

document.querySelector(".deleteoption button").addEventListener('click', () => {
    // document.body.style.backgroundColor="green"
    document.querySelector(".del").classList.add("display")

    const settings = document.querySelector(".settingsdispl")
    settings.classList.toggle("active")


})
cro.addEventListener("click", () => {
    document.querySelector(".del").classList.toggle("display")
    // })
})
document.querySelector(".profile").addEventListener("click", () => {
    document.querySelector(".profiledetails").classList.toggle("active")
})
document.querySelector(".profiledetails .cross").addEventListener('click', () => {
    document.querySelector(".profiledetails").classList.toggle("active")
})
document.querySelector(".updateinfo .cross div").addEventListener("click",()=>{
    document.querySelector(".updateinfo").classList.toggle("active")
})
document.querySelector(".editinfo button").addEventListener("click",()=>{document.querySelector(".updateinfo").classList.toggle("active")})