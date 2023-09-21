// Fungsi untuk memformat nilai numerik menjadi format mata uang
function formatCurrency(input) {
    // Hapus semua karakter selain angka
    const numericValue = input.value.replace(/\D/g, '');

    // Format nilai sebagai mata uang
    const formattedValue = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0, // Hapus desimal jika ada
    }).format(numericValue);

    // Set nilai input dengan format mata uang
    input.value = formattedValue;
}

// Fungsi untuk menghapus format mata uang saat mengirimkan formulir
function removeCurrencyFormatting(input) {
    input.value = input.value.replace(/\D/g, '');
}

// Mendapatkan elemen input berdasarkan ID
const amountInput = document.getElementById('amountInput');

// Tambahkan event listener untuk memformat nilai saat mengetik
amountInput.addEventListener('input', function () {
    formatCurrency(this);
});

// Tambahkan event listener untuk menghapus format mata uang saat mengirimkan formulir
amountInput.form.addEventListener('submit', function () {
    removeCurrencyFormatting(amountInput);
});