<?php
include "../sambung.inc.php";
include "converttanggal.php";
session_start();
$initid=$_SESSION['nipdos'];
  if (!isset($initid))
  {
	header("Location: index.php");
  }
  
 include "cekonline.php";  
   
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
<title>..::[SPOTA Prodi TEKNIK INFORMATIKA]::..</title>
<meta name="keywords" content="SPOTA, Sistem Pendukung Outline Tugas Akhir" />
<meta name="copyright" content="nikolaidiez - Teknik Informatika - UNTAN" />
<link href="default.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="chrome.js"></script>
<script type="text/javascript" src="aj.js"></script>
<script type="text/javascript" src="ed.js"></script>
</head>
<body class="admin">
<div id="header"></div>
<?php include "menu.php"; ?>
<?php
$rev_text = $_POST['review_text'];
$rev_text = trim($rev_text);
$rev_text = ereg_replace("(\r\n|\n|\r)", "",$rev_text);
$jbr = substr_count($rev_text,"<br>");
$cek=explode("<br>",$rev_text);
for ($i=0;$i<=$jbr;$i++)
{
	$revi=$revi.trim($cek[$i]);		
}
$max_file = 3072000;
$tipe_file = $_FILES['suara']['type'];
$lokasi_file = $_FILES['suara']['tmp_name'];
$nama_file = $_FILES['suara']['name'];
$ukuran_file = $_FILES['suara']['size'];
$jenis_rev = $_POST['jenis_rev'];
$hasil = $_POST['hasil'];
$mode=$_POST['mode'];
$id_jud = $_POST['id_ju'];
$id_rev = $_POST['id_rev'];
$urutan_rep = $_POST['urutan_rep'];
$acak = rand(0000,9999);
$nama_ubah = $acak.'-'.$initid.'-'.$nama_file;
$direktori = "../dosen-spota/upload/$nama_ubah";
$waktu=date("H:i:s");

if (($revi == NULL or $revi == '%') and (empty($lokasi_file)))
{
	echo "
		<div id='warning'>
		<center><h1>Review bernilai kosong</h1><br>";
		echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
		echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
}

else if (($revi != NULL or $revi != '%') and (empty($lokasi_file)))
{
	/*if ($jenis_rev=="")
	{
		echo "
		<div id='warning'>
		<center><h1>Jenis Review Tidak terpilih</h1><br>";
		echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
		echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
	}
	else*/ 
	if ($jenis_rev=="1")
	{
		if ($hasil=="")
		{
			echo "
			<div id='warning'>
			<center><h1>Anda tidak memilih putusan</h1><br>";
			echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
			echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
		}
		else 
		{
			$cek = mysql_query("SELECT id_review FROM review_praoutline WHERE reviewer='$initid' and jenis_rev='1' and id_upload='$id_jud'");
			$docek=mysql_fetch_array($cek);
			$jum= mysql_num_rows($cek);
			if ($jum==1)
			{
				$sql = mysql_query("UPDATE review_praoutline set jenis_rev='0', hasil='' WHERE id_review='$docek[id_review]'");
				$input = mysql_query
						("INSERT INTO review_praoutline (id_upload, reviewer, review_text, review_sound, jenis_rev, hasil, tanggal, waktu)
				 		values ('$id_jud', '$initid', '$rev_text', '', '$jenis_rev', '$hasil', NOW(), '$waktu')");
				echo "
				<div id='warning'>
				<center><h1>New POST berhasil dikirim</h1><br>";
				echo "Klik <a href='recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'>ini</a> untuk kembali ke menu Review Praoutline<br><br>";
				echo "<meta http-equiv='refresh' content='3;URL=recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'></center></div>";	
	
			}
			else
			{
				$input = mysql_query
						("INSERT INTO review_praoutline (id_upload, reviewer, review_text, review_sound, jenis_rev, hasil, tanggal, waktu)
				 		values ('$id_jud', '$initid', '$rev_text', '', '$jenis_rev', '$hasil', NOW(), '$waktu')");
				echo "
				<div id='warning'>
				<center><h1>New POST berhasil dikirim</h1><br>";
				echo "Klik <a href='recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'>ini</a> untuk kembali ke menu Review Praoutline<br><br>";
				echo "<meta http-equiv='refresh' content='3;URL=recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'></center></div>";		
			}
			
		}	
	}	
	else
	{
		$no = mysql_query
				("INSERT INTO review_praoutline (id_upload, reviewer, review_text, review_sound, jenis_rev, hasil, tanggal, waktu)
				 values ('$id_jud', '$initid', '$rev_text', '', '0', '', NOW(), '$waktu')");
				
				echo "
				<div id='warning'>
				<center><h1>New POST berhasil dikirim</h1><br>";
				echo "Klik <a href='recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'>ini</a> untuk kembali ke menu Review Praoutline<br><br>";
				echo "<meta http-equiv='refresh' content='3;URL=recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'></center></div>";	
	
	}
}

else if (($revi == NULL or $revi == '%') and (!empty($lokasi_file)))
{
if ($tipe_file == "audio/mpeg")
	{
		if ($ukuran_file > $max_file or $ukuran_file == 0)	
			{
			echo "
			<div id='warning'>
			<center><h1>MP3 yang diupload terlalu besar</h1><br>";
			echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
			echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
			}		
		else
			{
				/*if ($jenis_rev=="")
				{
					echo "
					<div id='warning'>
					<center><h1>Jenis Review Tidak terpilih</h1><br>";
					echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
					echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
				}
				else*/ 
				if ($jenis_rev=="1")
				{
					if ($hasil=="")
					{
						echo "
						<div id='warning'>
						<center><h1>Anda tidak memilih putusan</h1><br>";
						echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
						echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
					}
					else 
					{
						$cek = mysql_query("SELECT id_review FROM review_praoutline WHERE reviewer='$initid' and jenis_rev='1' and id_upload='$id_jud'");
						$docek=mysql_fetch_array($cek);
						$jum= mysql_num_rows($cek);
						if ($jum==1)
						{
							if (move_uploaded_file($lokasi_file,$direktori))
							{
							$sql = mysql_query("UPDATE review_praoutline set jenis_rev='0', hasil='' WHERE id_review='$docek[id_review]'");
							$input = mysql_query
									("INSERT INTO review_praoutline (id_upload, reviewer, review_text, review_sound, jenis_rev, hasil, tanggal, waktu)
									values ('$id_jud', '$initid', '$rev_text', '$nama_ubah', '$jenis_rev', '$hasil', NOW(), '$waktu')");
							echo "
							<div id='warning'>
							<center><h1>New POST berhasil dikirim</h1><br>";
							echo "Klik <a href='recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'>ini</a> untuk kembali ke menu Review Praoutline<br><br>";
							echo "<meta http-equiv='refresh' content='3;URL=recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'></center></div>";	
							}				
						}
						else
						{
							if (move_uploaded_file($lokasi_file,$direktori))
							{
							$input = mysql_query
									("INSERT INTO review_praoutline (id_upload, reviewer, review_text, review_sound, jenis_rev, hasil, tanggal, waktu)
									values ('$id_jud', '$initid', '$rev_text', '$nama_ubah', '$jenis_rev', '$hasil', NOW(), '$waktu')");
							echo "
							<div id='warning'>
							<center><h1>New POST berhasil dikirim</h1><br>";
							echo "Klik <a href='recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'>ini</a> untuk kembali ke menu Review Praoutline<br><br>";
							echo "<meta http-equiv='refresh' content='3;URL=recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'></center></div>";		
							}
						}
						
					}						
				}	
				else
				{
					if (move_uploaded_file($lokasi_file,$direktori))
					{
					$no = mysql_query
							("INSERT INTO review_praoutline (id_upload, reviewer, review_text, review_sound, jenis_rev, hasil, tanggal, waktu)
							 values ('$id_jud', '$initid', '$rev_text', '$nama_ubah', '0', '', NOW(), '$waktu')");
							
							echo "
							<div id='warning'>
							<center><h1>New POST berhasil dikirim</h1><br>";
							echo "Klik <a href='recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'>ini</a> untuk kembali ke menu Review Praoutline<br><br>";
							echo "<meta http-equiv='refresh' content='3;URL=recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'></center></div>";	
					}
				}
			}
	}
	else	
	{
	echo "
	<div id='warning'>
	<center><h1>Tipe file bukan MP3</h1><br>";
	echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
	echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
	}
}

else
{
if ($tipe_file == "audio/mpeg")
	{
		if ($ukuran_file > $max_file or $ukuran_file == 0)	
			{
			echo "
			<div id='warning'>
			<center><h1>MP3 yang diupload terlalu besar</h1><br>";
			echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
			echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
			}		
		else
			{
				/*if ($jenis_rev=="")
				{
					echo "
					<div id='warning'>
					<center><h1>Jenis Review Tidak terpilih</h1><br>";
					echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
					echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
				}
				else*/ 
				
				if ($jenis_rev=="1")
				{
					if ($hasil=="")
					{
						echo "
						<div id='warning'>
						<center><h1>Anda tidak memilih putusan</h1><br>";
						echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
						echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
					}
					else 
					{
						$cek = mysql_query("SELECT id_review FROM review_praoutline WHERE reviewer='$initid' and jenis_rev='1' and id_upload='$id_jud'");
						$docek=mysql_fetch_array($cek);
						$jum= mysql_num_rows($cek);
						if ($jum==1)
						{
							if (move_uploaded_file($lokasi_file,$direktori))
							{
							$sql = mysql_query("UPDATE review_praoutline set jenis_rev='0', hasil='' WHERE id_review='$docek[id_review]'");
							$input = mysql_query
									("INSERT INTO review_praoutline (id_upload, reviewer, review_text, review_sound, jenis_rev, hasil, tanggal, waktu)
									values ('$id_jud', '$initid', '$rev_text', '$nama_ubah', '$jenis_rev', '$hasil', NOW(), '$waktu')");
							echo "
							<div id='warning'>
							<center><h1>New POST berhasil dikirim</h1><br>";
							echo "Klik <a href='recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'>ini</a> untuk kembali ke menu Review Praoutline<br><br>";
							echo "<meta http-equiv='refresh' content='3;URL=recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'></center></div>";	
							}				
						}
						else
						{
							if (move_uploaded_file($lokasi_file,$direktori))
							{
							$input = mysql_query
									("INSERT INTO review_praoutline (id_upload, reviewer, review_text, review_sound, jenis_rev, hasil, tanggal, waktu)
									values ('$id_jud', '$initid', '$rev_text', '$nama_ubah', '$jenis_rev', '$hasil', NOW(), '$waktu')");
							echo "
							<div id='warning'>
							<center><h1>New POST berhasil dikirim</h1><br>";
							echo "Klik <a href='recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'>ini</a> untuk kembali ke menu Review Praoutline<br><br>";
							echo "<meta http-equiv='refresh' content='3;URL=recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'></center></div>";		
							}
						}
						
					}	
				}
				else
				{
					if (move_uploaded_file($lokasi_file,$direktori))
					{
					$no = mysql_query
							("INSERT INTO review_praoutline (id_upload, reviewer, review_text, review_sound, jenis_rev, hasil, tanggal, waktu)
							 values ('$id_jud', '$initid', '$rev_text', '$nama_ubah', '0', '', NOW(), '$waktu')");
							
							echo "
							<div id='warning'>
							<center><h1>New POST berhasil dikirim</h1><br>";
							echo "Klik <a href='recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'>ini</a> untuk kembali ke menu Review Praoutline<br><br>";
							echo "<meta http-equiv='refresh' content='3;URL=recent1.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev#bottom'></center></div>";	
					}
				}	
			}
	}
	else	
	{
	echo "
	<div id='warning'>
	<center><h1>Tipe file bukan MP3</h1><br>";
	echo "Klik <a href='nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'>ini</a> untuk kembali ke menu Edit Post<br><br>";
	echo "<meta http-equiv='refresh' content='3;URL=nrep.php?mode=$mode&id_jud=$id_jud&id_rev=$id_rev&urutan_rep=$urutan_rep'></center></div>";
	}
}
?>

</body>
</html>

