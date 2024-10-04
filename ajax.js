document.getElementById("email").addEventListener("blur", function () {
    var email = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "checkemail.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (this.responseText === "exists") {
            document.getElementById("emailCheck").textContent = "Email already exists";
        } else {
            document.getElementById("emailCheck").textContent = "";
        }
    };
    xhr.send("email=" + email);
});

document.getElementById("old_password").addEventListener("blur", function () {
    var oldPassword = this.value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "checkoldpassword.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        if (this.responseText === "invalid") {
            document.getElementById("passwordCheck").textContent = "Old password is incorrect";
        } else {
            document.getElementById("passwordCheck").textContent = "";
        }
    };
    xhr.send("old_password=" + oldPassword);
});

document.getElementById("profileForm").addEventListener("submit", function (e) {
    e.preventDefault();
    var username = document.getElementById("username").value;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "profile.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function () {
        alert(this.responseText);
    };
    xhr.send("username=" + username);
});
