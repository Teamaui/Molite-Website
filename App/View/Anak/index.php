<!-- Main Content -->
<div class="main-content">
    <h1>Daftar Data Anak</h1>
    <div class="table-container">
        <div class="table-button">
            <a href="/anak/create"><i class="bi bi-plus-circle"></i> Tambah Data</a>
            <form action="" method="get">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Search here..." name="search">
                <button type="submit">Search</button>
            </form>
        </div>
        <table>
            <thead>
                <tr>
                    <!-- ID_anak	nama_anak	tanggal_lahir	tempat_lahir	jenis_kelamin	ID_orang_tua -->
                    <th>No</th>
                    <th>Nama</th>
                    <th>Tanggal Lahir</th>
                    <th>Tempat Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Ahmad Zaki</td>
                    <td>20 Agustus 2020</td>
                    <td>Jember</td>
                    <td>Laki-Laki</td>
                    <td>
                        <a class="edit" href=""><i class="bi bi-pencil-fill"></i></a>
                        <a class="hapus" href=""><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Dwi Yuliani</td>
                    <td>26 Juli 2021</td>
                    <td>Mangli</td>
                    <td>Perempuan</td>
                    <td>
                        <a class="edit" href=""><i class="bi bi-pencil-fill"></i></a>
                        <a class="hapus" href=""><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>