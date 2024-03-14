<?php
// ?----------------------------------Connection----------------------------------
include("connection.php");

if (isset($_GET["submit"])) {
   $nama = htmlentities(strip_tags(trim($_GET["nama"])));
   $nama = mysqli_real_escape_string($link, $nama);

   $query = "SELECT * FROM mahasiswa WHERE nama LIKE '$nama%' ORDER BY nama ASC";
   $result = mysqli_query($link, $query);
   $data = mysqli_fetch_assoc($result);
} else {
   $query = "SELECT * FROM mahasiswa";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Document</title>
</head>

<body>
   <div class="container">
      <?php include("header.php"); ?>
      <main>
         <article>
            <header>
               <h1>DATA MAHASISWA</h1>
            </header>
            <section>
               <table>
                  <thead>
                     <tr>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Tempat Lahir</th>
                        <th>Tanggal Lahir</th>
                        <th>Jurusan</th>
                        <th>IPK</th>
                        <th></th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php

                     $result = mysqli_query($link, $query);
                     while ($data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td> $data[nim] </td>";
                        echo "<td> $data[nama] </td>";
                        echo "<td> $data[tempat_lahir] </td>";
                        echo "<td>" . substr($data['tanggal_lahir'], 8, 2) . " - " . substr($data['tanggal_lahir'], 5, 2) . " - " . substr($data['tanggal_lahir'], 0, 4) .  "</td>";
                        echo "<td> $data[jurusan] </td>";
                        echo "<td> $data[ipk] </td>";
                     ?>
                        <td>
                           <form action="edit.php" method="post">
                              <input type="hidden" name="nim" value="<?php echo $data['nim'] ?>">
                              <input type="submit" value="edit">
                           </form>
                        </td>
                        <td>
                           <form action="hapus.php" method="post">
                              <input type="hidden" name="nim" value="<?php echo $data['nim'] ?>">
                              <input type="submit" value="hapus">
                           </form>
                        </td>

                     <?php
                        echo "</tr>";
                     }
                     mysqli_free_result($result);
                     ?>
                  </tbody>

               </table>
            </section>
            <footer>
            </footer>
         </article>
      </main>

   </div>

</body>

</html>
<?php
mysqli_close($link);
?>