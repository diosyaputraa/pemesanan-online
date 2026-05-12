<form action="proses_pemesanan.php" method="POST">

<input type="text" name="nama" required>

<select name="barang" required>
    <option value="T-shirt">T-shirt</option>
    <option value="Celana Joger">Celana Joger</option>
    <option value="Celana Chinos">Celana Chinos</option>
    <option value="Blues">Blues</option>
    <option value="Dress">Dress</option>
    <option value="Kemeja">Kemeja</option>
</select>

<input type="number" name="jumlah" required>

<select name="kecamatan" required>
    <option value="Muara Bangkahulu">Muara Bangkahulu</option>
    <option value="Ratu Agung">Ratu Agung</option>
    <option value="Ratu Samban">Ratu Samban</option>
    <option value="Selebar">Selebar</option>
    <option value="Pagar Dewa">Pagar Dewa</option>
    <option value="Singaran Pati">Singaran Pati</option>
</select>

<button type="submit" name="submit">Pesan</button>

</form>