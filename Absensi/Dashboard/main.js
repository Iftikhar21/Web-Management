// Document operation functions
const sideMenu = document.querySelector("aside");
const themeToggler = document.querySelector(".theme-toggler");

// Change Theme
themeToggler.addEventListener("click", () => {
  document.body.classList.toggle("dark-theme-variables");
  document.body.classList.toggle("table-dark-theme");


  themeToggler.querySelector("span:nth-child(1)").classList.toggle("active");
  themeToggler.querySelector("span:nth-child(2)").classList.toggle("active");
});

function refreshPage() {
    location.reload(); // Memuat ulang halaman saat ini
}

document.addEventListener("DOMContentLoaded", function () {
  // Pastikan variabel `table` tersedia di seluruh skrip
  window.table = $('#absensiTable').DataTable({
      searching: true,
      ordering: false,
      paging: true,
      lengthMenu: [25, 50, 100, 200],
      order: [[4, 'desc']],
      language: {
          lengthMenu: "Tampilkan _MENU_ data per halaman",
          zeroRecords: "Data tidak ditemukan",
          info: "Menampilkan halaman _PAGE_ dari _PAGES_",
          infoEmpty: "Tidak ada data tersedia",
          infoFiltered: "(difilter dari _MAX_ total data)",
          search: "Pencarian umum:",
          paginate: {
              first: "Pertama",
              last: "Terakhir",
              next: "Berikutnya",
              previous: "Sebelumnya",
          },
      },
      columnDefs: [
          {
              targets: 5, // Kolom Kehadiran
              render: function (data, type, row) {
                  if (data === null || data.trim() === '') {
                      return 'Tidak diketahui';
                  }
                  var status = data.toLowerCase();
                  return `<span class="status-badge status-${status}">${data}</span>`;
              },
          },
      ],
  });

  // Filter Nama
    $('#filterNama').on('keyup', function () {
      table.column(1).search(this.value).draw();
  });


  // Filter NISN
  $('#filterNISN').on('keyup', function () {
      table.column(2).search(this.value).draw();
  });
  
  // Filter Android ID
    $('#filterAndroidID').on('keyup', function () {
      table.column(3).search(this.value).draw();
  });


  // Filter Kelas
  $('#filterKelas').on('change', function () {
    var selected = this.value;
    if (selected) {
        table.column(4).search('^' + selected + '$', true, false).draw();
    } else {
        table.column(4).search('').draw(); // Tampilkan semua jika tidak ada filter
    }
  });

  // Filter Jurusan
  $('#filterJurusan').on('change', function () {
    console.log("Filter Jurusan:", this.value); // Debugging
    table.column(5).search(this.value, true, false).draw();
  });

  // Filter Tanggal
  $('#filterTanggal').on('change', function () {
      table.column(6).search(this.value).draw();
  });

  $('#filterKehadiran').on('change', function () {
    var selected = this.value;
    table.column(7).search(selected, true, false).draw();
  });

  // Filter Kehadiran
  // $('#filterKehadiran').on('change', function () {
  //     table.column(6).search(this.value, true, false).draw();
  // });

  // Filter Catatan
  $('#filterCatatan').on('keyup', function () {
      table.column(8).search(this.value).draw();
  });

  // Filter Mood
  $('#filterMood').on('change', function () {
      table.column(9).search(this.value, true, false).draw();
  });
});

window.onerror = function(message, source, lineno, colno, error) {
    console.log("Error ditemukan: ", message, " di ", source, " baris ", lineno);
};

console.log("main.js berhasil dimuat");
