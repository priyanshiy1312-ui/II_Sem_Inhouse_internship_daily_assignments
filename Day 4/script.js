const toggleBtn = document.getElementById("theme-toggle");

toggleBtn.addEventListener("click", () => {

    document.body.classList.toggle("dark-mode");

    if(document.body.classList.contains("dark-mode")){
        toggleBtn.innerHTML = "☀️ Light Mode";
    }else{
        toggleBtn.innerHTML = "🌙 Dark Mode";
    }

});
const registerBtn = document.getElementById("mybtn");

registerBtn.addEventListener("click", function(e){

    e.preventDefault();

    const errors = document.querySelectorAll(".error");

    // Clear previous errors
    errors.forEach(error => error.textContent = "");

    const name = document.querySelector('input[type="text"]');
    const email = document.querySelector('input[type="email"]');

    const passwords = document.querySelectorAll('input[type="password"]');
    const password = passwords[0];
    const confirmPassword = passwords[1];

    const mobile = document.querySelector('input[type="tel"]');
    const dob = document.querySelector('input[type="date"]');

    const gender = document.querySelector('input[name="gender"]:checked');
    const skills = document.querySelectorAll('input[name="skill"]:checked');

    const resume = document.querySelector('input[type="file"]');
    const about = document.querySelector(".about");

    let valid = true;

    // Name
    if(name.value.trim() === ""){
        errors[0].textContent = "Name is required";
        valid = false;
    }

    // Email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if(!emailPattern.test(email.value)){
        errors[1].textContent = "Enter a valid email";
        valid = false;
    }

    // Password
    if(password.value.length < 8){
        errors[2].textContent = "Password must be at least 8 characters";
        valid = false;
    }

    // Confirm Password
    if(password.value !== confirmPassword.value){
        errors[3].textContent = "Passwords do not match";
        valid = false;
    }

    // Mobile
    const mobilePattern = /^[6-9]\d{9}$/;

    if(!mobilePattern.test(mobile.value)){
        errors[4].textContent = "Enter a valid mobile number";
        valid = false;
    }

    // DOB
    if(dob.value === ""){
        errors[5].textContent = "Select your Date of Birth";
        valid = false;
    }

    // Gender
    if(!gender){
        errors[6].textContent = "Please select your gender";
        valid = false;
    }

    // Skills
    if(skills.length === 0){
        errors[7].textContent = "Select at least one skill";
        valid = false;
    }

    // Resume
    if(resume.files.length === 0){
        errors[8].textContent = "Upload your resume";
        valid = false;
    }

    // About Yourself
    if(about.value.trim() === ""){
        errors[9].textContent = "Please write about yourself";
        valid = false;
    }

    if(valid){
        alert("Registration Successful!");
    }

});