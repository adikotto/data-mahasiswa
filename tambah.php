<?php
// ?----------------------------------Connection----------------------------------

include("connection.php");

if (isset($_POST["submit"])) {

   // ?----------------------------------Variable----------------------------------

   $nim = htmlentities(strip_tags(trim($_POST["nim"])));
   $nama = htmlentities(strip_tags(trim($_POST["nama"])));
   $tempat_lahir = htmlentities(strip_tags(trim($_POST["tempat_lahir"])));
   $tanggal = htmlentities(strip_tags(trim($_POST["tanggal"])));
   $bulan = htmlentities(strip_tags(trim($_POST["bulan"])));
   $tahun = htmlentities(strip_tags(trim($_POST["tahun"])));
   $jurusan = htmlentities(strip_tags(trim($_POST["jurusan"])));
   $ipk = htmlentities(strip_tags(trim($_POST["ipk"])));


   // ?----------------------------------Validation----------------------------------

   $nim = mysqli_real_escape_string($link, $nim);
   $nim_error = "";

   if (empty($nim)) {
      $nim_error = "Nim tidak boleh kosong";
   } elseif (!preg_match("/^[0-9]{8}$/", $nim)) {
      $nim_error = "Nim harus berjumlah 8 digit angka";
   }

   $query = "SELECT * FROM mahasiswa WHERE nim = '$nim'";
   $result = mysqli_query($link, $query);
   $jumlah_data = mysqli_num_rows($result);

   if ($jumlah_data >= 1) {
      $nim_error = "Nim sudah ada";
   }

   $nama = mysqli_real_escape_string($link, $nama);
   $nama_error = "";

   if (empty($nama)) {
      $nama_error = "Nama tidak boleh kosong";
   } elseif (!preg_match("/[A-Z,a-z]/", $nama)) {
      $nama_error = "Nama harus terdiri dari huruf";
   }

   $tempat_lahir = mysqli_real_escape_string($link, $tempat_lahir);
   $tempat_lahir_error = "";

   if (empty($tempat_lahir)) {
      $tempat_lahir_error = "Tempat lahir tidak boleh kosong";
   } elseif (!preg_match("/[A-Z,a-z]/", $tempat_lahir)) {
      $tempat_lahir_error = "Tempat lahir harus terdiri dari huruf";
   }

   $tanggal = (int) mysqli_real_escape_string($link, $tanggal);
   $bulan = (int) mysqli_real_escape_string($link, $bulan);
   $tahun = (int) mysqli_real_escape_string($link, $tahun);

   $jurusan = mysqli_real_escape_string($link, $jurusan);

   $ipk = mysqli_real_escape_string($link, $ipk);
   $ipk_error = "";

   if (empty($ipk)) {
      $ipk_error = "IPK tidak boleh kosong";
   } elseif (!is_numeric($ipk)) {
      $ipk_error = "IPK harus berupa angka";
   } elseif ($ipk < 0 or $ipk > 4) {
      $ipk_error = "IPK tidak valid";
   }

   // ?----------------------------------Jika Tidak Error----------------------------------

   if ($nim_error === "" and $nama_error === "" and $tempat_lahir_error === "" and $ipk_error === "") {
      $query = "INSERT INTO mahasiswa VALUES ";
      $query .= "('$nim','$nama','$tempat_lahir', ";
      $query .= "'$tahun" . "-" . "$bulan" . "-" . "$tanggal', ";
      $query .= "'$jurusan','$ipk')";

      $result = mysqli_query($link, $query);
      if ($result) {
         header("Location: data_mahasiswa.php");
      }
   }
} else {
   // ?----------------------------------Variable----------------------------------
   $nim = "";
   $nama = "";
   $tempat_lahir = "";
   $tanggal = "";
   $bulan = "";
   $tahun = "";
   $jurusan = "";
   $ipk = "";

   // ?----------------------------------Pesan Error----------------------------------
   $nim_error = "";
   $nama_error = "";
   $tempat_lahir_error = "";
   $ipk_error = "";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Tambah</title>
</head>

<body>
   <script src="script.js"></script>
   <div class="container">
      <?php include("header.php"); ?>
      <main>
         <header>
            <h1>TAMBAH MAHASISWA</h1>
         </header>
         <section class="body-form">
            <form action="tambah.php" method="post">
               <fieldset>
                  <div>
                     <div><label for="nim">NIM</label><input type="text" name="nim" id="nim" value="<?php echo $nim ?>"><span class="error"><?php echo $nim_error ?></span></div>
                     <div><label for="nama">Nama</label><input type="text" name="nama" id="nama" value="<?php echo $nama ?>"><span class="error"><?php echo $nama_error ?></span></div>
                     <div><label for="tempat_lahir">Tempat Lahir</label><input type="text" name="tempat_lahir" id="tempatLahir" value="<?php echo $tempat_lahir ?>"><span class="error"><?php echo $tempat_lahir_error ?></span></div>
                     <div>
                        <label for="">Tanggal Lahir</label>
                        <select name="tanggal" id="tanggal">
                           <?php
                           for ($i = 1; $i <= 31; $i++) {
                              if ($i === $tanggal) {
                                 echo "<option value='$i' selected>$i</option>";
                              } else {
                                 echo "<option value='$i'>$i</option>";
                              }
                           }
                           ?>
                        </select>
                        <select name="bulan" id="bulan">
                           <?php
                           $nama_bulan = [1 => "Januari", 2 => "Februari", 3 => "Maret", 4 => "April", 5 => "Mei", 6 => "Juni", 7 => "Juli", 8 => "Agustus", 9 => "September", 10 => "Oktober", 11 => "November", 12 => "Desember"];

                           for ($i = 1; $i < 12; $i++) {
                              if ($i === $bulan) {
                                 echo "<option value='$i' selected> $nama_bulan[$i] </option>";
                              } else {
                                 echo "<option value='$i'> $nama_bulan[$i] </option>";
                              }
                           }
                           ?>
                        </select>
                        <select name="tahun" id="tahun">
                           <?php
                           for ($i = 1980; $i <= date("Y", time()); $i++) {
                              if ($i === $tahun) {
                                 echo "<option value='$i' selected>$i</option>";
                              } else {
                                 echo "<option value='$i'>$i</option>";
                              }
                           }
                           ?>
                        </select>
                        <div>
                           <label for="jurusan">Jurusan</label>
                           <select name="jurusan" id="jurusan">
                              <option value="Teknik Informatika" <?php if ($jurusan === "Teknik Informatika") {
                                                                     echo "selected";
                                                                  } ?>>Teknik Informatika</option>
                              <option value="Sistem Informasi" <?php if ($jurusan === "Sistem Informasi") {
                                                                  echo "selected";
                                                               } ?>>Sistem Informasi</option>
                           </select>
                        </div>
                        <div><label for="ipk">IPK</label><input type="number" name="ipk" id="ipk" min="0.01" max="4.0" step="0.01" value="<?php echo $ipk; ?>"><span class="error"><?php echo $ipk_error; ?></span></div>
                     </div>
                  </div>

               </fieldset>
               <input type="submit" name="submit" value="Konfirmasi">
            </form>
         </section>
      </main>

   </div>
</body>

</html>