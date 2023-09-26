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
                style="justify-content: center; align-items: center;"
              >
                <h4 class="mb-4 font-semibold text-gray-800 dark:text-gray-300">
                  Your Profile
                </h4>
                <div class="relative">
                  <form action="" method="post">
                    <img
                      class="profile-image"
                      style="width: 150px; height: 150px;"
                      src="<?= base_url('src/user/image/') . $user['image']; ?>"
                      alt="Profile Picture"
                      aria-hidden="true"
                    />
                    <label
                      for="profile-image"
                      class="profile-label"
                    >
                    <i class="fas fa-camera text-white"></i>
                    </label>
                    <input id="profile-image" type="file" class="profile-input" accept="image/*">
                    <button
                      type="submit"
                      class="mx-auto px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                    >
                      Save Changes
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>