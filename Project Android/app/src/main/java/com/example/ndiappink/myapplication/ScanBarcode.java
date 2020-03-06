package com.example.ndiappink.myapplication;


import android.content.Intent;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.media.AudioManager;
import android.media.ToneGenerator;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.support.annotation.RequiresApi;
import android.support.design.widget.Snackbar;
import android.support.v7.app.AppCompatActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.RelativeLayout;
import android.widget.TextView;
import android.widget.Toast;
import com.google.zxing.BarcodeFormat;
import com.google.zxing.MultiFormatWriter;
import com.google.zxing.WriterException;
import com.google.zxing.common.BitMatrix;
import com.google.zxing.integration.android.IntentIntegrator;
import com.google.zxing.integration.android.IntentResult;
import com.journeyapps.barcodescanner.BarcodeEncoder;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.Statement;
import java.text.SimpleDateFormat;
import java.util.Calendar;
import java.util.Date;

public class ScanBarcode extends AppCompatActivity{

    String jenisnya,masuknya,keluarnya,platnya,mereknya,warnanya, lamaparkir;
    int totalbayar;
    private static final String url = "jdbc:mysql://192.168.43.93:3306/Barcode_Park";
    private static final String user = "root";
    private static final String pass = "ellekappang";

    TextView kodeBarcode,jenis_kendara,masuk,keluar,plat,merek,warna,lama;
    ImageView qrcode1;
    Button simpan;
    RelativeLayout rl;



    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.qrcode);
        getSupportActionBar().setTitle("Scan QR Code");
        rl = findViewById(R.id.anue);
        kodeBarcode = findViewById(R.id.kodeBarcode);
        masuk = findViewById(R.id.masuk);
        jenis_kendara = findViewById(R.id.jenisKendara);
        keluar = findViewById(R.id.keluar);
        plat = findViewById(R.id.plat);
        merek = findViewById(R.id.merek);
        warna = findViewById(R.id.warna);
        lama = findViewById(R.id.lama);

        qrcode1 = findViewById(R.id.qrcode);
        simpan = findViewById(R.id.simpan);

        simpan.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

                    bersih();
            }
        });
    }

    void bersih(){
        kodeBarcode.setText("");
        jenis_kendara.setText("");
        masuk.setText("");
        keluar.setText("");
        plat.setText("");
        warna.setText("");
        merek.setText("");
        lama.setText("");
        qrcode1.setImageBitmap(null);
    }

    private class ConnectMySql extends AsyncTask<String, Void, String> {
        String res = "";

        @Override
        protected void onPreExecute() {
            super.onPreExecute();
//            Toast.makeText(ScanBarcode.this, "Please wait...", Toast.LENGTH_SHORT)
//                    .show();

        }

        @RequiresApi(api = Build.VERSION_CODES.M)
        @Override
        protected String doInBackground(String... params) {
            try {
                Calendar c1 = Calendar.getInstance();
                SimpleDateFormat sdf1 = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
                lamaparkir = sdf1.format(c1.getTime());
                Class.forName("com.mysql.jdbc.Driver");
                Connection con = DriverManager.getConnection(url, user, pass);
                //System.out.println("Databaseection success");
                Statement st = con.createStatement();

                st.executeUpdate("update parkir set JamKeluar = '"+ lamaparkir + "' where KodeBarcode = '" +kodeBarcode.getText().toString().trim()+ "'");
                ResultSet rs = st.executeQuery("select * from parkir where KodeBarcode ="+ "'"+kodeBarcode.getText().toString().trim()+"'");
                ResultSetMetaData rsmd = rs.getMetaData();

                if (rs.next()) {

                    jenisnya = rs.getString(3).toString();
                    mereknya = rs.getString(4).toString();
                    warnanya = rs.getString(5).toString();
                    platnya = rs.getString(6).toString();
                    masuknya = rs.getString(7).toString();
                    keluarnya = rs.getString(8).toString();
                    Snackbar snackbar = Snackbar
                            .make(getCurrentFocus(), "QR Code Terdeteksi", Snackbar.LENGTH_LONG);
                    View sbView = snackbar.getView();
                    sbView.setBackgroundColor(getColor(R.color.colorPrimaryDark));
                    TextView textView = sbView.findViewById(android.support.design.R.id.snackbar_text);
                    textView.setTextColor(Color.WHITE);
                    snackbar.show();
                    ToneGenerator toneGen1 = new ToneGenerator(AudioManager.STREAM_ALARM, 100);
                    toneGen1.startTone(ToneGenerator.TONE_PROP_BEEP,150);

                }
                else{
                    jenisnya= "";
                    mereknya="";
                    warnanya="";
                    platnya="";
                    masuknya="";
                    keluarnya="";
                    Snackbar snackbar = Snackbar
                            .make(getCurrentFocus(), "QR Code Tidak Terdeteksi", Snackbar.LENGTH_LONG);
                    View sbView = snackbar.getView();
                    sbView.setBackgroundColor(getColor(R.color.merah));
                    TextView textView = sbView.findViewById(android.support.design.R.id.snackbar_text);
                    textView.setTextColor(Color.WHITE);
                    snackbar.show();
                    ToneGenerator toneGen1 = new ToneGenerator(AudioManager.STREAM_ALARM, 100);
                    toneGen1.startTone(ToneGenerator.TONE_SUP_ERROR,150);

                }
            } catch (Exception e) {
                e.printStackTrace();
                res = e.toString();
            }
            return res;
        }

        @Override
        protected void onPostExecute(String result) {


            try {
//                NumberFormat formatter = new DecimalFormat("#,##0");
                Calendar c1 = Calendar.getInstance();
                SimpleDateFormat sdf1 = new SimpleDateFormat("yyyy-MM-dd HH:mm:ss");
               lamaparkir = sdf1.format(c1.getTime());

                SimpleDateFormat format = new SimpleDateFormat("MM/dd/yyyy HH:mm:ss");
                jenis_kendara.setText(jenisnya);
                merek.setText(mereknya);
                warna.setText(warnanya);
                plat.setText(platnya);
                masuk.setText(masuknya);
                keluar.setText(keluarnya);

                Date d1 = format.parse(masuknya.replace("-", "/"));
                Date d2 = format.parse(lamaparkir.replace("-", "/"));

                long diff = d2.getTime() - d1.getTime();

                long diffSeconds = diff / 1000 % 60;
                long diffMinutes = diff / (60 * 1000) % 60;
                long diffHours = diff / (60 * 60 * 1000) % 24;
                long diffDays = diff / (24 * 60 * 60 * 1000);
                lama.setText(String.valueOf(diffHours + " Jam " +diffMinutes+" Menit "+diffSeconds+" Detik"));

            } catch (Exception e) {
                e.printStackTrace();
            }

        }
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data){
        IntentResult result = IntentIntegrator.parseActivityResult(requestCode,resultCode,data);
        if (result != null){
            if (result.getContents() == null){
                Toast.makeText(this,"Barcode Tidak Ada", Toast.LENGTH_SHORT).show();
                qrcode1.setImageBitmap(null);
            }
            else{
               kodeBarcode.setText(result.getContents());
                MultiFormatWriter multiFormatWriter = new MultiFormatWriter();
                    try {
                        rl.requestLayout();
                        qrcode1.requestLayout();
                        rl.getLayoutParams().width = FrameLayout.LayoutParams.MATCH_PARENT;
                        rl.getLayoutParams().height = rl.getWidth();
                        qrcode1.getLayoutParams().width = rl.getWidth();
                        qrcode1.getLayoutParams().height = rl.getWidth();
                        BitMatrix bitMatrix = multiFormatWriter.encode(kodeBarcode.getText().toString(), BarcodeFormat.valueOf(result.getFormatName()), 1000,1000);
                        BarcodeEncoder barcodeEncoder = new BarcodeEncoder();
                        Bitmap bitmap = barcodeEncoder.createBitmap(bitMatrix);
                        qrcode1.setImageBitmap(bitmap);
                    } catch (WriterException e) {
                        Toast.makeText(ScanBarcode.this, e.toString(), Toast.LENGTH_SHORT).show();
                    }

                    try{
                        ConnectMySql connectMySql = new ConnectMySql();
                        connectMySql.execute("");


                    }catch (Exception e){
                        Toast.makeText(ScanBarcode.this, e.toString(), Toast.LENGTH_SHORT).show();
                    }

            }
        }
        else{
            super.onActivityResult(requestCode, resultCode, data);
        }
    }


    public void scanow(){
        IntentIntegrator integrator = new IntentIntegrator(this);
        integrator.setCaptureActivity(Portrait.class);
        integrator.setOrientationLocked(false);
        integrator.setDesiredBarcodeFormats(IntentIntegrator.ALL_CODE_TYPES);
        integrator.setBeepEnabled(false);
        integrator.setPrompt("Scan QR Code");
        integrator.initiateScan();
        bersih();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_scan, menu);
        return true;
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        int id = item.getItemId();
        if (id == R.id.scan){
            scanow();
        }
        return super.onOptionsItemSelected(item);
    }
}
