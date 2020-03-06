<?php
//Ini untuk koneksi saja

$user_name = "root";
$password  = "ellekappang";
$database  = "barcode_park"; //Tulis sesuai dengan nama database yang digunakan
$host_name = "localhost";

$connect_db=mysql_connect($host_name, $user_name, $password);
$find_db=mysql_select_db($database);
//Akhir koneksi

//Pertama ambil data kiriman dari form
$kode = @$_POST['KodeBarcode'];
$jenis = @$_POST['jenis'];
$plat = @$_POST['plat'];
$warna = @$_POST['warna'];
$merek = @$_POST['merek'];

//Kemudian dapat langsung kita simpan dengan query INSERT
//$sql_simpan = mysql_query ("INSERT into parkir (KodeBarcode, Jenis, WaktuMasuk) VALUES ('$kode', '$jenis', now())");
$sql_simpan = mysql_query ("INSERT into parkir (KodeBarcode, Jenis, Plat, Warna, Merek, JamMasuk) VALUES ('$kode', '$jenis', '$plat', '$warna', '$merek', now())");
// if($sql_simpan) {
//  echo "Data berhasil disimpan";
// } else {
//  echo "Data gagal disimpan";
// }

include "phpqrcode/qrlib.php"; //<-- LOKASI FILE UTAMA PLUGINNYA

$tempdir = "temp/"; //<-- Nama Folder file QR Code kita nantinya akan disimpan
if (!file_exists($tempdir))#kalau folder belum ada, maka buat.
    mkdir($tempdir);

//lanjutan yang tadi

#parameter inputan
$isi_teks = "$kode";
$namafile = "$kode.png";
$quality = 'H'; //ada 4 pilihan, L (Low), M(Medium), Q(Good), H(High)
$ukuran = 10; //batasan 1 paling kecil, 10 paling besar
$padding = 2;

QRCode::png($isi_teks,$tempdir.$namafile,$quality,$ukuran,$padding);
?>

    <html lang="en">

    <head>
        <title>Contact V1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--===============================================================================================-->
        <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
        <!--===============================================================================================-->
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
        <!--===============================================================================================-->

        <style>
            .container-contact1 {
                width: auto;
                border: 5px dotted #7a7777;
                background: #fff;
                border-radius: 15px;
                overflow: hidden;
                display: -webkit-box;
                display: -webkit-flex;
                display: -moz-box;
                display: -ms-flexbox;
                display: grid;
                flex-wrap: wrap;
                justify-content: space-between;
                align-content: center;
                padding: 20px;
            }

            .titlenya{
                color:#333333;
                font-size: 24px;
            }
        </style>
    </head>

    <body>

        <div class="contact1">
            <div class="container-contact1">

                <span class="contact1-form-title titlenya" style="padding-bottom: 20px;font-size:35px">
					<?php echo $kode ?>
				</span>

                <?php echo"<img src='temp/$kode.png' style='width:450px'>"; ?>
					<a href="index.php" class="contact1-form-btn" style="text-decoration:none;border-radius: 15px;">Kembali</a>				

            </div>
        </div>

        <!--===============================================================================================-->
        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
        <!--===============================================================================================-->
        <script src="vendor/bootstrap/js/popper.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <!--===============================================================================================-->
        <script src="vendor/select2/select2.min.js"></script>
        <!--===============================================================================================-->
        <script src="vendor/tilt/tilt.jquery.min.js"></script>
        <script>
            $('.js-tilt').tilt({
                scale: 1.1
            })
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-23581568-13"></script>
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', 'UA-23581568-13');
        </script>

        <!--===============================================================================================-->
        <script src="js/main.js"></script>

    </body>

    </html>