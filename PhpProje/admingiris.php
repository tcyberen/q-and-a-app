<?php 
// session oturumunu başlattık, bu işemi her oturum açmak istediğimiz php dosyasnda yapıyoruz
session_start(); 
include("baglanti.php");
?> 

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Giriş Yap</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">

</head>

<body>
	<?php

	// session kontrolü yaparak eğer kullanıcı giriş yapmamışsa giriş formunu, giriş yapmışsa panel ekranını gösteriyoruz

	// isset() fonksiyonu değişken tanımlı mı diye bakar

	if (!isset ($_SESSION['adminAdi'])) { ?>

		<center>
			<hr>
			|<a href="index.php">Ana Sayfa</a> | <a href="kullanicigiris.php">Öğrenci Girişi</a>|
			<hr>

			<h2>Öğretmen Girişi</h2>
			<form action="admingiris.php" method="POST">
				<label for="adminAdi">Öğretmen Adı: </label>
				<input type="text" name="adminAdi" id="adminAdi">
				<label for="adminParola">Parola:</label>
				<input type="password" name="adminParola" id="adminParola">
				<input type="submit" name="adminGiris" value="Giriş Yap">
			</form>
			<br>
			<hr>

			<?php 
			// İlk olarak form kontrolü yapıyoruz
			if (isset($_POST['adminGiris'])) {

    			// formdan gelen verileri karşılaştırıyoruz. tanımladığımız giriş bilgileri doğrumu kontrol ediyoruz
				if ($_POST['adminAdi']=="admin" && $_POST['adminParola']=="123") {

        			//Giriş bilgileri doğruysa session atama işlemleri yapıyoruz
					$_SESSION['adminAdi']=$_POST['adminAdi'];
					$_SESSION['adminParola']=$_POST['adminParola'];

    				// Yönlendirme işlemi yapıyoruz. İşlem sonucunu takip için durum GET değişkenini tanımlıyoruz(index sayfası)
					header("Location:admingiris.php?sonuc=#");
					exit;
				}
				else{
    				// İşlem başarısız olduğu zaman işlem sonucunu takip için durum GET değişkeni tanımlıyoruz(index de)
					header("Location:admingiris.php?sonuc=no");
					exit;
				}
			}



			// İşlemlerden GET değeri döndürüyoruz. Bu sayede işlem durumunu takip edebiliyoruz
			if ($_GET['sonuc']=="no") {
				echo "<br>";

				echo "Giriş işlemi başarısız, lütfen tekrar deneyiniz.";

				?>
				<p>Tekrar denemek için <a href="admingiris.php">tıklayınız</a></p> 

				<?php 

				header("Refresh: 5; url=http://localhost/PhpProje/admingiris.php");
			}
			else if ($_GET['sonuc']=="cikis") {
				echo "<br>";

				echo "Çıkış işlemi başarıyla yapıldı.";

				header("Refresh: 3; url=http://localhost/PhpProje/admingiris.php");
			}
		}
		else{
			?>
			<center>

				<hr>	
				|<a href="index.php">Ana Sayfa</a> | <a href="kullanicigiris.php">Öğrenci Girişi</a>|
				<hr>

				<h2>Öğretmen Paneli</h2>

				<form action="admingiris.php" method="post">
					<label for="kSorgu">Cevapları görüntülemek için göser butonuna tıklayınız</label>

					<br>

					<input type="submit" value="Göster" name="goster" style="width:100px">


				</form>
				<a href="admincikis.php"><button>Çıkış Yap</button></a>
				<br>

				<?php 

				if (isset($_POST['goster'])) {
					

					$sec = "SELECT * FROM cevaplartablo";
					$sonuc = $baglanti->query($sec);

					if ($sonuc->num_rows>0) {
						while ($cek=$sonuc->fetch_assoc()) {

							?>
							<table border="2" cellspacing="0" cellpadding="5">
								<?php  

								echo "<tr><td>".$cek['cevap']."</td></tr>"."<br>";
								?>
							</table>	
							<?php 
						}
					}

					else{

						echo "<br>";

						echo "Veritabanında hiçbir veri bulunamadı";

					}

				}

				?>
			</center>

			<?php 
		}
		?>

	</center>
</body>
</html>

