function validateForm() {
    const email = document.getElementById("email").value;
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;

    if (!email || !username || !password) {
        alert("All fields are required.");
        return false;
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        alert("Please enter a valid email.");
        return false;
    }

    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }

    return true;
}
