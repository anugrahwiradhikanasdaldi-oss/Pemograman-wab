<?php
$page_title = "Tambah Buku";
include __DIR__ . '/../includes/header.php';

$flash = $_SESSION['flash'] ?? null;
unset($_SESSION['flash']);

// ===== DATA CONTOH (hapus blok ini setelah dipakai) =====
if (isset($_GET['isi_contoh']) && $sudahLogin) {
    require __DIR__ . '/../includes/koneksi.php';

    $data = [
        ['Laskar Pelangi', 'Andrea Hirata', 2005, '9789793062792', 5, 'fiksi'],
        ['Bumi Manusia', 'Pramoedya Ananta Toer', 1980, '9789799731234', 3, 'fiksi'],
        ['Atomic Habits', 'James Clear', 2018, '9780735211292', 4, 'non-fiksi'],
        ['Filosofi Teras', 'Henry Manampiring', 2018, '9786024246945', 6, 'non-fiksi'],
        ['Kamus Besar Bahasa Indonesia', 'Badan Bahasa', 2016, '9786020318639', 2, 'referensi'],
        ['Negeri 5 Menara', 'Ahmad Fuadi', 2009, '9789792248616', 4, 'fiksi'],
        ['Cantik Itu Luka', 'Eka Kurniawan', 2002, '9786020312583', 3, 'fiksi'],
        ['Sapiens', 'Yuval Noah Harari', 2011, '9786024246983', 5, 'non-fiksi'],
        ['Rich Dad Poor Dad', 'Robert T. Kiyosaki', 1997, '9786020338644', 7, 'non-fiksi'],
        ['Ensiklopedia Sains Populer', 'Tim Redaksi', 2015, '9786020289021', 2, 'referensi'],
    ];

    $cek = $pdo->prepare("SELECT COUNT(*) FROM buku WHERE isbn = ?");
    $ins = $pdo->prepare("INSERT INTO buku (judul, pengarang, tahun, isbn, stok, kategori) VALUES (?, ?, ?, ?, ?, ?)");

    $masuk = 0;
    foreach ($data as $row) {
        $cek->execute([$row[3]]);
        if ($cek->fetchColumn() == 0) {
            $ins->execute($row);
            $masuk++;
        }
    }
    $flash = ['type' => 'success', 'pesan' => "Data contoh masuk: $masuk buku baru."];
}
// ===== AKHIR DATA CONTOH =====
?>
        <section>
            <h2>Tambah Buku</h2>

            <?php if ($flash): ?>
                <p class="flash flash-<?php echo $flash['type']; ?>"><?php echo $flash['pesan']; ?></p>
            <?php endif; ?>

            <form id="form-tambah" method="post" action="proses_tambah.php">
                <?php echo csrf_field(); ?>
                <p>
                    <label for="judul">Judul</label><br>
                    <input type="text" id="judul" name="judul" required>
                </p>
                <p>
                    <label for="pengarang">Pengarang</label><br>
                    <input type="text" id="pengarang" name="pengarang" required>
                </p>
                <p>
                    <label for="tahun">Tahun Terbit</label><br>
                    <input type="number" id="tahun" name="tahun" min="1900" max="2026" required>
                </p>
                <p>
                    <label for="isbn">ISBN</label><br>
                    <input type="text" id="isbn" name="isbn">
                </p>
                <p>
                    <label for="stok">Stok</label><br>
                    <input type="number" id="stok" name="stok" min="0" required>
                </p>
                <p>
                    <label for="kategori">Kategori</label><br>
                    <select id="kategori" name="kategori">
                        <option value="fiksi">Fiksi</option>
                        <option value="non-fiksi">Non-Fiksi</option>
                        <option value="referensi">Referensi</option>
                    </select>
                </p>
                <p>
                    <button type="submit">Simpan</button>
                </p>
            </form>
        </section>
<?php include __DIR__ . '/../includes/footer.php'; ?>