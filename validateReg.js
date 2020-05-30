// submit validation
const box_submit = document.getElementById("box_submit")
box_submit.addEventListener("click", event => {
  validateForm()
  validatePass()
  validateEmail()
})
// username validation
const box_username = document.getElementById("box_username")
box_username.addEventListener("change", event => {
  validateForm()
})

function validateForm() {
  const box_username = document.getElementById("box_username")

  if (box_username.value.trim() == null || box_username.value.trim() == "") {
    document.getElementById("noInput").innerHTML = "Please enter your username!"
    setTimeout(function() {
      document.getElementById("noInput").innerHTML = ""
    }, 3000)
    event.preventDefault()
    return false
  }
}
// password validation
const box_password = document.getElementById("box_password")
box_password.addEventListener("change", event => {
  validatePass()
})

function validatePass() {
  const box_password = document.getElementById("box_password")

  if (box_password.value.trim() == null || box_password.value.trim() == "") {
    document.getElementById("noPass").innerHTML = "Please enter your password."
    setTimeout(function() {
      document.getElementById("noPass").innerHTML = ""
    }, 3000)
    event.preventDefault()
    return false
  }
}

// email validation
const box_email = document.getElementById("box_email")
box_email.addEventListener("change", event => {
  validateEmail()
})

function validateEmail() {
  const box_email = document.getElementById("box_email")
  const mailForm = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/
  if (box_email.value.match(mailForm)) {
    document.getElementById("noMail").innerHTML = ""
    return true
  } else {
    document.getElementById("noMail").innerHTML =
      "You have entered an invalid email address!."

    return false
  }
}
