function hapusData(dataID) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'mx-6 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple',
            cancelButton: 'mx-6 px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-red-600 border border-transparent rounded-lg active:bg-red-800 hover:bg-red-700 focus:outline-none focus:shadow-outline-purple'
        },
        buttonsStyling: false
    });

    swalWithBootstrapButtons.fire({
        title: 'Apakah kamu yakin?',
        text: "Catatan keuangan tidak akan bisa dikembalikan lagi!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Aduh, gajadi!',
        confirmButtonText: 'Ya, hapus saja!',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            swalWithBootstrapButtons.fire(
                'Terhapus!',
                'User berhasil dihapus.. :(',
                'success'
            );
            // Ganti link dengan URL yang sesuai untuk menghapus user
            window.location.href = baseUrl + 'transaksi/deleteData?id=' + dataID;
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            swalWithBootstrapButtons.fire(
                'Dibatalkan',
                'User masih aman, selaww.. :)',
                'error'
            );
        }
    });
}