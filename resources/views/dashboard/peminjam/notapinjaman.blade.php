
<center>
    <div style="width: 30%;">
        <div id="area-cetak">
            <center>
                <div class="header">
                    <h1>NOTA PINJAMAN</h1>
                </div>
            </center>
            
            <div align="left">
                <br>
                <div style="margin:10px;">
                    <table border="1" width="100%">
                        <tr>
                            <td colspan="3"><center>Data Pinjaman Yang Diajukan</center></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Jumlah Pinjaman</strong></p></td>
                            <td colspan="2"<p>: Rp {{ number_format($pinjaman?->jumlah ?? 0) }},-</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Jangka Waktu</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->jangka_waktu ?? 0 }} bulan</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Untuk Keperluan</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->tujuan_pinjaman ?? '-' }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="3"><center>Data Pemohon Kredit</center></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Nama Pemohon</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->nama ?? '-' }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>NIK</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->nik ?? '-' }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Tempat, Tanggal Lahir</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->tempat_lahir }}, {{ $pinjaman?->tgl_lahir }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Jenis Kelamin</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->jenis_kelamin ?? '-' }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Pekerjaan</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->pekerjaan ?? '-' }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Nomor Telpon</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->no_telp ?? '-' }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Alamat</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->alamat ?? '-' }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Status Perkawinan</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->status_kawin ?? '-' }}</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Kewarganegaraan</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->kewarganegaraan ?? '-' }}</p></td>
                        </tr>
                    </table>
                    <table border="1" width="100%">
                        <tr>
                            <td colspan="2" style="padding: 10px;">
                                <p><strong>Catatan: </strong></p>
                                <p>{{ $pinjaman?->tanggapan ?? '-' }}</p>
                            </td>
                            <td colspan="1" align="right" style="padding: 10px;">
                                <p><strong>Disetujui Oleh: </strong></p>
                                <p>{{ $pinjaman?->pegawai?->nama ?? '-' }}</p>
                            </td>
                        </tr>
                    </table>
                    <br>

                    <table border="1" width="100%">
                        <tr>
                            <td colspan="3"><center>Lembar Persetujuan</center></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Nominal Pinjaman</strong></p></td>
                            <td colspan="2"<p>: Rp {{ number_format($pinjaman?->jumlah ?? 0) }},-</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Jangka Waktu</strong></p></td>
                            <td colspan="2"<p>: {{ $pinjaman?->jangka_waktu ?? 0 }} bulan</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Bunga Perbulan ({{ $pinjaman?->bunga_perbulan ?? 0 }}%)</strong></p></td>
                            <td colspan="2"<p>: Rp {{ number_format(($pinjaman?->jumlah*($pinjaman?->bunga_perbulan/100))*$pinjaman?->jangka_waktu) }},-</p></td>
                        </tr>
                        <tr>
                            <td colspan="1"><p><strong>Realisasi Total Pinjaman</strong></p></td>
                            <td colspan="2"<p>: Rp {{ number_format($pinjaman?->jumlah+($pinjaman?->jumlah*($pinjaman?->bunga_perbulan/100))*$pinjaman?->jangka_waktu) }},-</p></td>
                        </tr>
                    </table>

                    <table border="1" width="100%">
                        <tr>
                            <td colspan="3"><center>Tanda Tangan</center></td>
                        </tr>
                        <tr>
                            <td colspan="1">
                                <center>
                                    <p>Penerima Pinjaman</p>
                                    <br>
                                    <br>
                                    <p>{{ $pinjaman?->nama ?? 0 }}</p>
                                </center>
                            </td>
                            <td colspan="1">
                                <center>
                                    <p>Bendahara Koperasi</p>
                                    <br>
                                    <br>
                                    <p>Wildan Suyono</p>
                                </center>
                            </td>
                            <td colspan="1">
                                <center>
                                    <p>Ketua Koperasi</p>
                                    <br>
                                    <br>
                                    <p>Andik Adi Suryanto</p>
                                </center>
                            </td>
                        </tr>
                    </table>
                </div>
                <br>
            </div>
        </div>
        
        <div>
            Silahkan diprint dan di tanda tangani, 
            <br>
            lalu kirimkan ke koperasi untuk pencairan uang. 
            <br>
            Terima Kasih
        </div>
        <br>

        <div class="no-print">
            <button onclick="printDiv('area-cetak')" style="padding:5px 10px">
                Cetak Nota Pinjaman
            </button>
        </div>
    </div>
</center>

<script>
    function printDiv(divId) {
        // Ambil konten HTML dari div yang diinginkan
        var printContents = document.getElementById(divId).innerHTML;
    
        // Simpan konten asli dari seluruh halaman
        var originalContents = document.body.innerHTML;
    
        // Buat style khusus untuk memastikan lebar 100% saat dicetak
        // @page { size: auto; margin: 0mm; } akan mencoba menghilangkan margin default browser
        var styles = `
            <style type="text/css">
                @page { 
                    size: auto; 
                    margin: 20mm; /* Atur margin kertas sesuai kebutuhan */
                }
                body {
                    width: 100%;
                }
                table {
                    width: 100% !important; /* Paksa tabel agar 100% */
                }
            </style>
        `;
    
        // Ganti konten body dengan style baru DAN konten div yang akan dicetak
        document.body.innerHTML = styles + printContents;
    
        // Panggil fungsi print bawaan browser
        window.print();
    
        // Kembalikan konten asli halaman
        // Menggunakan location.reload() seringkali lebih aman untuk memastikan semua script
        // dan event listener kembali normal setelah proses cetak.
        document.body.innerHTML = originalContents;
        location.reload(); 
    }
</script>


