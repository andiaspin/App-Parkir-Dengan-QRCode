<!DOCTYPE html>
<?php
function autonumber($tabel ,$kolom, $lebar=0, $awalan=''){

    $host = "localhost";
    $usr = "root";
    $pwd = "ellekappang";
    $dbname = "barcode_park";
    $koneksi = mysqli_connect($host, $usr, $pwd, $dbname);
    if(mysqli_connect_error()){
        echo 'database gagal dikoneksikan!'.mysqli_connect_error();
    }

    //proses auto number

    $auto = mysqli_query($koneksi, "select $kolom from $tabel order by $kolom desc limit 1") or die(mysqli_error());
    $jumlah_record = mysqli_num_rows($auto);
    if($jumlah_record == 0)
    $nomor = 1;

    else{
        $row = mysqli_fetch_array($auto);
        $nomor = intval(substr($row[0], strlen($awalan)))+1;
    }
    if($lebar>0)
        $angka = $awalan.str_pad ($nomor, $lebar, "0", STR_PAD_LEFT);
    else
        $angka=$awalan.$nomor;
    return $angka;
}
?>
    <html lang="en">

    <head>
        <title>Aplikasi Parkir</title>
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
            .page1 {
                width: 100%;
                height: 100%;
            }
            
            .page2 {
                width: 100%;
                height: 100%;
                position: relative;
                margin: 0;
                background: crimson;  /* fallback for old browsers */
background: -webkit-linear-gradient(to right, #3498db, #2c3e50);  /* Chrome 10-25, Safari 5.1-6 */
background: linear-gradient(to right, #3498db, #2c3e50); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

                font-family: sans-serif;
                font-weight: 100;
            }
            
            .container-contact1 {
                width: 800px;
                padding: 32px;
            }
            
            .form-control {
                display: block;
                width: 100%;
                padding: 0 30px;
                font-size: 15px;
                line-height: 1.25;
                color: #495057;
                background-color: #fff;
                background-image: none;
                background-clip: padding-box;
                border: 1px solid rgba(0, 0, 0, .15);
                border-radius: 25px;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                margin-bottom: 25px;
                font-family: Montserrat-Bold;
                height: 50px;
            }
            
            .page2.containerr {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            
            .fixed_header {
                width: 85%;
                height: auto;
            }
            
            .fixed_header tbody {
                display: block;
                width: 100%;
                overflow: auto;
                height: 400px;
            }
            
            .fixed_header thead tr {
                display: block;
            }
            
            .fixed_header thead {
                background: black;
                color: #fff;
            }
            
            .fixed_header th,
            .fixed_header td {
                padding: 10x;
                text-align: left;
                width: 200px;
            }
            
            table {
                width: 75%;
                border-collapse: collapse;
                overflow: auto;
                table-layout: fixed;
                border-collapse: collapse;
                position: absolute;
                box-shadow: 0 0 20px rgba(0, 0, 0, 0.32);
                top: 55%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
            
            th,
            td {
                padding: 15px;
                background-color: rgba(255, 255, 255, 0);
                color: #fff;
            }
            
            th {
                text-align: left;
            }
            
            thead {
                th {
                    background-color: #55608f;
                }
            }
            
            tbody {
                tr {
                    &:hover {
                        background-color: rgba(255, 255, 255, 0.3);
                    }
                }
                td {
                    position: relative;
                    &:hover {
                        &:before {
                            content: "";
                            position: absolute;
                            left: 0;
                            right: 0;
                            top: -9999px;
                            bottom: -9999px;
                            background-color: rgba(255, 255, 255, 0.2);
                            z-index: -1;
                        }
                    }
                }
            }
            
            .contact1-form-titlee {
                display: block;
                position: absolute;
                font-family: Montserrat-ExtraBold;
                font-size: 47px;
                color: #f5f5f5;
                line-height: 1.2;
                text-align: center;
                text-shadow: 2px 2px #000000b3;
                padding-bottom: 44px;
                top: 20%;
                left: 50%;
                transform: translate(-50%, -50%)
            }

            .contact1-form-titleee {
                display: block;
  font-family: Montserrat-ExtraBold;
  font-size: 30px;
  color: #f5f5f5;
  line-height: 1.2;
  text-shadow: 2px 2px #000000b3;
  text-align: center;
  padding-bottom: 44px;
            }
        </style>
    </head>

    <body>
        <div class="page1">
            <div class="contact1">
                <div class="container-contact1">
                    <div class="contact1-pic js-tilt" data-tilt>
                        <img src="images/com.png" alt="IMG">
                    </div>

                    <form class="contact1-form validate-form" method="POST" action="aksi.php">
                        <span class="contact1-form-titleee">
					Data Kendaraan
				</span>

                        <div class="wrap-input1 validate-input">
                            <input class="input1" type="text" name="KodeBarcode" placeholder="Kode Barcode" value="<?= autonumber(" parkir ", "KodeBarcode ", "4 ", "PARK-") ?> " readonly>
                            <span class="shadow-input1"></span>
                        </div>

                        <div class="wrap-input1 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input onkeyup="this.value = this.value.toUpperCase()"; class="input1" type="text" name="plat" placeholder="Nomor Polisi" required oninvalid="this.setCustomValidity('Plat Belum Diisi')" oninput="this.setCustomValidity('')">
                            <span class="shadow-input1"></span>
                        </div>

                        <div class="wrap-input1 validate-input" data-validate="Subject is required">
                            <input onkeyup="this.value = this.value.toUpperCase()"; class="input1" type="text" name="merek" placeholder="Merek" required oninvalid="this.setCustomValidity('Merek Belum Diisi')" oninput="this.setCustomValidity('')">
                            <span class="shadow-input1"></span>
                        </div>

                        <div class="wrap-input1 validate-input" data-validate="Subject is required">
                            <input onkeyup="this.value = this.value.toUpperCase()"; class="input1" type="text" name="warna" placeholder="Warna" required oninvalid="this.setCustomValidity('Warna Belum Diisi')" oninput="this.setCustomValidity('')">
                            <span class="shadow-input1"></span>
                        </div>

                        <select class="form-control" name="jenis">
                            <option value="MOBIL">MOBIL</option>
                            <option value="MOTOR">MOTOR</option>
                        </select>
                        <!-- <div class="wrap-input1 validate-input" data-validate = "Message is required">
					<textarea class="input1" name="message" placeholder="Message"></textarea>
					<span class="shadow-input1"></span>
				</div> -->

                        <div class="container-contact1-form-btn">
                            <input type="submit" class="contact1-form-btn" value="Simpan">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="page2" id="dataParkir">
            <?php
                $koneksinya = mysqli_connect("localhost","root","ellekappang","Barcode_Park") or die(mysqli_error());
                $sqlnya = "SELECT * FROM parkir";
	            $querynya = mysqli_query($koneksinya, $sqlnya);
            ?>
                <div class="containerr">
                    <span class="contact1-form-titlee" class="spannya">
					Data Parkir
				</span>
                    <table class="fixed_header">
                        <thead>
                            <tr>
                                <th>Kode Barcode</th>
                                <th>Jenis</th>
                                <th>Merek</th>
                                <th>Warna</th>
                                <th>Plat</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                       while($data = mysqli_fetch_array($querynya)){
                        ?>
                                <tr>

                                    <td>
                                        <?php echo $data['KodeBarcode']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['Jenis']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['Merek']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['Warna']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['Plat']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['JamMasuk']; ?>
                                    </td>
                                    <td>
                                        <?php echo $data['JamKeluar']; ?>
                                    </td>

                                </tr>
                                <?php
                    }
                    ?>
                        </tbody>
                    </table>
                </div>
        </div>

        <!--===============================================================================================-->
        <script type="text/javascript" async="" src="https://www.google-analytics.com/analytics.js"></script>
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

        <!-- <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript">
var myVar = setInterval(myTimer, 1000);

function myTimer() {
  var d = new Date();
  document.getElementById("dataParkir").innerHTML = d.toLocaleTimeString();
} 
</script> -->

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