$(document).ready(function(){
  // Sembunyikan tombol pencarian saat halaman dimuat
  $('#tombol-cari').hide();

  // Event saat kata kunci diketik
  $('#keyword').on('keyup', function() {
    // Tampilkan ikon loading
    $('.loader').show();

    // Ajax menggunakan $.get()
    $.get('ajax/mahasiswa.php?keyword=' + $('#keyword').val(), function(data){
      // Masukkan data ke dalam kontainer
      $('#container').html(data);
      // Sembunyikan ikon loading setelah data dimuat
      $('.loader').hide();
    });
  });
});