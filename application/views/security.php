<main class="h-full pb-16 overflow-y-auto">
          <!-- Remove everything INSIDE this div to a really blank page -->
          <div class="container px-6 mx-auto grid">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
            <?= $title; ?>
            </h2>
              <div class="grid gap-6 mb-8 md:grid-cols-2">
              <div
                class="min-w-0 p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Update your Password
                </h4>
                <form action="<?=base_url('account/updatePassword');?>" method="post">
                  <label class="block text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                      Type your current password
                    </span>
                    <input
                      id="current-password"
                      name="password"
                      class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                      type="password" />
                  </label>

                  <!-- Type your new password -->
                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                      Type your new password
                    </span>
                    <input
                      id="new-password"
                      name="password1"
                      class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                      type="password" />
                    <span id="new-password-message" class="text-xs text-gray-600 dark:text-gray-400"></span>
                  </label>

                  <!-- Type your new password again -->
                  <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">
                      Type your new password again
                    </span>
                    <input
                      id="confirm-password"
                      name="password2"
                      class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray form-input"
                      type="password" />
                    <span id="confirm-password-message" class="text-xs text-gray-600 dark:text-gray-400"></span>
                  </label>
                  <div class="mb-4 mt-6">
                    <button
                      type="submit"
                      class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    >
                      Save Changes
                    </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <script>
              const newPasswordInput = document.getElementById("new-password");
              const confirmPasswordInput = document.getElementById("confirm-password");
              const newPasswordMessage = document.getElementById("new-password-message");
              const confirmPasswordMessage = document.getElementById("confirm-password-message");

              newPasswordInput.addEventListener("input", () => {
                  const newPassword = newPasswordInput.value;
                  if (newPassword.length <= 3) {
                      newPasswordMessage.textContent = "Your password must be at least 3 characters long.";
                      newPasswordMessage.style.color = "#dc2626";
                  } else if (newPassword.length > 3 && newPassword.length < 6) {
                      newPasswordMessage.textContent = "Your password is too short.";
                      newPasswordMessage.style.color = "orange";
                  } else if (newPassword.length >= 6) {
                      newPasswordMessage.textContent = "Your password is strong.";
                      newPasswordMessage.style.color = "#16a34a";
                  }
              });

              confirmPasswordInput.addEventListener("input", () => {
                  const newPassword = newPasswordInput.value;
                  const confirmPassword = confirmPasswordInput.value;

                  if (confirmPassword !== newPassword) {
                      confirmPasswordMessage.textContent = "Passwords do not match.";
                      confirmPasswordMessage.style.color = "#dc2626";
                  } else {
                      confirmPasswordMessage.textContent = "Password match";
                      confirmPasswordMessage.style.color = "#16a34a";
                  }
              });
          </script>
        </main>
      </div>
    </div>
  </body>
</html>