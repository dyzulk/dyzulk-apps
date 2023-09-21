        <main class="h-full pb-16 overflow-y-auto">
          <div class="container grid px-6 mx-auto">
            <h2
              class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
            >
              Tables
            </h2>
            <!-- CTA -->
            <a
              class="flex items-center justify-between p-4 mb-8 text-sm font-semibold text-purple-100 bg-purple-600 rounded-lg shadow-md focus:outline-none focus:shadow-outline-purple"
              href="<?=base_url('transaksi/admin');?>"
            >
              <div class="flex items-center">
                <svg
                  class="w-5 h-5 mr-2"
                  fill="currentColor"
                  viewBox="0 0 20 20"
                >
                  <path
                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"
                  ></path>
                </svg>
                <span>Star this project on GitHub</span>
              </div>
              <span>View more &RightArrow;</span>
            </a>

            <!-- With avatar -->
            <h4
              class="mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300"
            >
              Table with avatars
            </h4>
            <div class="w-full mb-8 overflow-hidden rounded-lg shadow-xs">
              <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                  <thead>
                    <tr
                      class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                      <th class="px-4 py-3">Whos</th>
                      <th class="px-4 py-2">Amount</th>
                      <th class="px-4 py-2">Remainder</th>
                      <th class="px-4 py-2">Status</th>
                      <th class="px-4 py-3">Date</th>
                    </tr>
                  </thead>
                  <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                  >
                  <?php
                    $session = $this->session->userdata('email');
                    $queryTransaksi = "SELECT *
                                      FROM `users_account`
                                      JOIN `user_transaction` ON `users_account`.`email` = `user_transaction`.`user_email`
                                      WHERE `users_account`.`email` = '$session'
                                      ORDER BY `user_transaction`.`time_transaction` DESC";

                    $transaksiData = $this->db->query($queryTransaksi)->result_array();

                    function rupiah($angka){
                        $hasil_rupiah = "Rp. " . number_format($angka, 0, ',', '.');
                        return $hasil_rupiah;
                    }

                    $sisaSebelumnya = 1000000; // Inisialisasi sisa yang harus dibayar

                    foreach ($transaksiData as $transaksi) {
                        // Mengurangkan sisa yang harus dibayar dengan nilai amount pada transaksi
                        $sisa = $sisaSebelumnya - $transaksi['amount'];
                        
                        // Menampilkan data transaksi
                        echo '<tr class="text-gray-700 dark:text-gray-400">';
                        echo '<td class="px-4 py-3">';
                        echo '<div class="flex items-center text-sm">';
                        
                        // Avatar
                        echo '<div class="relative hidden w-8 h-8 mr-3 rounded-full md:block">';
                        echo '<img class="object-cover w-full h-full rounded-full" src="' . base_url('src/user/image/' . $transaksi['image']) . '" alt="" loading="lazy" />';
                        echo '<div class="absolute inset-0 rounded-full shadow-inner" aria-hidden="true"></div>';
                        echo '</div>';
                        
                        // Nama dan Email
                        echo '<div>';
                        echo '<p class="font-semibold">' . $transaksi['nama'] . '</p>';
                        echo '<p class="text-xs text-gray-600 dark:text-gray-400">' . $transaksi['email'] . '</p>';
                        echo '</div>';
                        
                        echo '</div>';
                        echo '</td>';
                        
                        // Amount
                        echo '<td class="px-4 py-3 text-sm">' . rupiah($transaksi['amount']) . '</td>';
                        
                        // Sisa yang harus dibayar
                        echo '<td class="px-4 py-3 text-sm">' . rupiah($sisa) . '</td>';
                        
                        // Status Pembayaran
                        echo '<td class="px-4 py-3 text-xs">';
                        if ($sisa <= 0) {
                            echo '<span class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100">Lunas</span>';
                        } else {
                            echo '<span class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:text-red-100 dark:bg-red-700">Belum Lunas</span>';
                        }
                        echo '</td>';
                        
                        // Tanggal Transaksi
                        echo '<td class="px-4 py-3 text-sm">' . date('d F Y', $transaksi['time_transaction']) . '</td>';
                        
                        echo '</tr>';
                        
                        // Mengupdate nilai sisa yang harus dibayar untuk transaksi berikutnya
                        $sisaSebelumnya = $sisa;
                    }
                    ?>
                  </tbody>
                </table>
              </div>
              <div
                class="grid px-4 py-3 text-xs font-semibold tracking-wide text-gray-500 uppercase border-t dark:border-gray-700 bg-gray-50 sm:grid-cols-9 dark:text-gray-400 dark:bg-gray-800"
              >
                <span class="flex items-center col-span-3">
                  Showing 21-30 of 100
                </span>
                <span class="col-span-2"></span>
                <!-- Pagination -->
                <span class="flex col-span-4 mt-2 sm:mt-auto sm:justify-end">
                  <nav aria-label="Table navigation">
                    <ul class="inline-flex items-center">
                      <li>
                        <button
                          class="px-3 py-1 rounded-md rounded-l-lg focus:outline-none focus:shadow-outline-purple"
                          aria-label="Previous"
                        >
                          <svg
                            aria-hidden="true"
                            class="w-4 h-4 fill-current"
                            viewBox="0 0 20 20"
                          >
                            <path
                              d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                              clip-rule="evenodd"
                              fill-rule="evenodd"
                            ></path>
                          </svg>
                        </button>
                      </li>
                      <li>
                        <button
                          class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                        >
                          1
                        </button>
                      </li>
                      <li>
                        <button
                          class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                        >
                          2
                        </button>
                      </li>
                      <li>
                        <button
                          class="px-3 py-1 text-white transition-colors duration-150 bg-purple-600 border border-r-0 border-purple-600 rounded-md focus:outline-none focus:shadow-outline-purple"
                        >
                          3
                        </button>
                      </li>
                      <li>
                        <button
                          class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                        >
                          4
                        </button>
                      </li>
                      <li>
                        <span class="px-3 py-1">...</span>
                      </li>
                      <li>
                        <button
                          class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                        >
                          8
                        </button>
                      </li>
                      <li>
                        <button
                          class="px-3 py-1 rounded-md focus:outline-none focus:shadow-outline-purple"
                        >
                          9
                        </button>
                      </li>
                      <li>
                        <button
                          class="px-3 py-1 rounded-md rounded-r-lg focus:outline-none focus:shadow-outline-purple"
                          aria-label="Next"
                        >
                          <svg
                            class="w-4 h-4 fill-current"
                            aria-hidden="true"
                            viewBox="0 0 20 20"
                          >
                            <path
                              d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                              clip-rule="evenodd"
                              fill-rule="evenodd"
                            ></path>
                          </svg>
                        </button>
                      </li>
                    </ul>
                  </nav>
                </span>
              </div>
            </div>
          </div>
        </main>
      </div>
    </div>
  </body>
</html>
