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

	if (!isset ($_SESSION['kullaniciAdi'])) { ?>

		<center>
			<hr>
			|<a href="index.php">Ana Sayfa</a> | <a href="admingiris.php">Öğretmen Girişi</a>|
			<hr>
			<h2>Öğrenci Girişi</h2>
			<form action="kullanicigiris.php" method="POST">
				<label for="kullaniciAdi">Öğrenci Adı: </label>
				<input type="text" name="kullaniciAdi" id="kullaniciAdi">
				<label for="kullaniciParola">Parola:</label>
				<input type="password" name="kullaniciParola" id="kullaniciParola">
				<input type="submit" name="kullaniciGiris" value="Giriş Yap">
			</form>
			<br>
			<hr>

			<?php 
			// İlk olarak form kontrolü yapıyoruz
			if (isset($_POST['kullaniciGiris'])) {

    			// formdan gelen verileri karşılaştırıyoruz. tanımladığımız giriş bilgileri doğrumu kontrol ediyoruz
				if (($_POST['kullaniciAdi']=="ogr1" || $_POST['kullaniciAdi']=="ogr2" || $_POST['kullaniciAdi']=="ogr3") && $_POST['kullaniciParola']=="123") {

        			//Giriş bilgileri doğruysa session atama işlemleri yapıyoruz
					$_SESSION['kullaniciAdi']=$_POST['kullaniciAdi'];
					$_SESSION['kullaniciParola']=$_POST['kullaniciParola'];

    				// Yönlendirme işlemi yapıyoruz. İşlem sonucunu takip için durum GET değişkenini tanımlıyoruz(index sayfası)
					header("Location:kullanicigiris.php?sonuc=#");
					exit;
				}
				else{
    				// İşlem başarısız olduğu zaman işlem sonucunu takip için durum GET değişkeni tanımlıyoruz(index de)
					header("Location:kullanicigiris.php?sonuc=no");
					exit;
				}
			}



			// İşlemlerden GET değeri döndürüyoruz. Bu sayede işlem durumunu takip edebiliyoruz
			if ($_GET['sonuc']=="no") {
				echo "<br>";

				echo "Kullanıcı adı veya parola yanlış girilmiştir!";
				?>
				<p>Tekrar denemek için <a href="kullanicigiris.php">tıklayınız</a></p> 

				<?php 
			}
			else if ($_GET['sonuc']=="cikis") {
				echo "<br>";

				echo "Çıkış işlemi başarıyla yapıldı!";

				header("Refresh: 3; url=http://localhost/PhpProje/kullanicigiris.php");
			}
		}
		else{
			?>
			<center>
				<hr>
				|<a href="index.php">Ana Sayfa</a> | <a href="admingiris.php">Öğretmen Girişi</a>|
				<hr>
				<h2>Öğrenci Paneli</h2>

				<p>Sayın <?php echo $_SESSION['kullaniciAdi'] ?>, hoşgeldiniz!</p>

				<p> Web programlamada kullanılan teknolojiler nelerdir?</p>

				<script type="text/javascript">
					function checkChar()
					{
						var allowedChar=60;
						var content= document.getElementById("content");
						var contLength=content.value.length;

						if(contLength > allowedChar){
							content.value=content.value.substring(0,allowedChar);
							document.getElementById("report").innerHTML= "<span style='color:red;'	>Uyarı: </span>" + "<span style='color:white;'>En fazla "+allowedChar+" karakter girebilirsiniz</span>";
						}	
					}
				</script>

				<form action="kullanicigiris.php" method="POST">

					<textarea id="content" name="content" onkeyup="checkChar()" onkeydown="checkChar()" rows="2" cols="60"></textarea>

					<div id="report"></div>


					<input type="submit" name="cevapgonder" value="Gönder">

				</form>
				
				<a href="kullanicicikis.php"><button>Çıkış Yap</button></a>
				<br>






				<?php 

				if (isset($_POST['cevapgonder'])) {

					$metin = $_POST['content'];   


					$vEkle = "INSERT INTO cevaplartablo (cevap) VALUES ('$metin')";

					$calistirEkle = mysqli_query($baglanti, $vEkle);

					if ($calistirEkle) {

						echo "<span style='color:rgb(0, 255, 0);'>Cevabınız kaydedilmiştir</span>";
						echo "<br>";

						header("Refresh: 1; url=http://localhost/PhpProje/kullanicigiris.php");
					}
					else{

						echo "Cevabınız kayıt edilemedi";
						header("Refresh: 1; url=http://localhost/PhpProje/kullanicigiris.php");

					}

					mysqli_close($baglanti);
				}
				?>



			</center>


			<?php 
		}
		?>

	</center>
</body>
</html>