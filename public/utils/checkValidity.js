var fields = {
    "username": {
        "pattern": /^(?=.*[A-Za-z]{3,})[A-Za-z0-9!@#$%^&*]{3,16}$/,
        "errorMessage": "Username should be 3-16 characters and shouldn't include any special character!"
    },
    "email": {
        "pattern": /.+@gmail\.com|.+@email\.com|.+@yahoo\.com/,
        "errorMessage": "It should be a valid email address!"
    },
    "password": {
        "pattern": /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/,
        "errorMessage": "Password should be at least 8 characters and include at least one letter and one number!"
    },
    "phonenumber": {
        "pattern": /^\d{10}$/,
        "errorMessage": "Phone number should be 12 digits!"
    },
    "password-for-sign-up" :{
        "pattern": /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d!@#$%^&*]{8,}$/,
        "errorMessage": "Password should be at least 8 characters and include at least one letter and one number!"
    },
    "username-for-sign-up": {
        "pattern": /^(?=.*[A-Za-z]{3,})[A-Za-z0-9!@#$%^&*]{3,16}$/,
        "errorMessage": "Username should be 3-16 characters and shouldn't include any special character!"
    },
    // Adăugați aici restul câmpurilor...
};

for (var field in fields) {
    document.getElementById(field).addEventListener("input", function() {
        var value = this.value;
        var regex = fields[this.id].pattern;
        var errorElement = document.getElementById(this.id + "-error");

        if (!regex.test(value)) {
            errorElement.textContent = fields[this.id].errorMessage;
        } else {
            errorElement.textContent = "";
        }
    });
}
