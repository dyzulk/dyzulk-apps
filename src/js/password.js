const newPasswordInput = document.getElementById('new-password');
const confirmPasswordInput = document.getElementById('confirm-password');
const newPasswordMessage = document.getElementById('new-password-message');
const confirmMessage = document.getElementById('confirm-password-message');

// Event listener untuk memeriksa perubahan pada input password baru
newPasswordInput.addEventListener('input', function () {
  const newPassword = newPasswordInput.value;

  if (newPassword.length < 6) {
    newPasswordMessage.textContent = 'Your password is too short.';
  } else {
    newPasswordMessage.textContent = 'Your password is strong.';
  }
});

// Event listener untuk memeriksa perubahan pada input password konfirmasi
confirmPasswordInput.addEventListener('input', function () {
  const confirmPassword = confirmPasswordInput.value;
  
  if (confirmPassword.length < 3) {
    confirmMessage.textContent = 'Your password must be at least 3 characters long.';
  } else {
    confirmMessage.textContent = '';
  }
});