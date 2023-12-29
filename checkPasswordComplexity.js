function checkPasswordComplexity(password) {
    var strength = ['Strong', 'Weak'];

    if (isEnoughLength(password, 8) && containsMixedCase(password) && containsDigits(password)) {
        return strength[0];
    } else {
        return strength[1];
    }
}

// Length check
function isEnoughLength(password, minLength) {
    return password.length >= minLength;
}

// Check for mixed case
function containsMixedCase(password) {
    return /[a-z]/.test(password) || /[A-Z]/.test(password);
}

// Check for digits
function containsDigits(password) {
    return /\d/.test(password);
}

// Check for special characters
function containsSpecialChars(password) {
    return /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);
}