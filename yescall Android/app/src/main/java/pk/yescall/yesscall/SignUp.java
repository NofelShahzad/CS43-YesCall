package pk.yescall.yesscall; 


import android.Manifest;
import android.app.ProgressDialog;
import android.content.ContentUris;
import android.content.Context;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.net.Uri;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.provider.DocumentsContract;
import android.provider.MediaStore;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.RequiresApi;
import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import com.android.volley.RequestQueue;
import com.android.volley.toolbox.Volley;
import com.koushikdutta.async.future.FutureCallback;
import com.koushikdutta.ion.Ion;
import com.koushikdutta.ion.ProgressCallback;

import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.security.cert.CertificateException;
import java.security.cert.X509Certificate;

import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

import butterknife.ButterKnife;
import butterknife.InjectView;
import de.hdodenhof.circleimageview.CircleImageView;

public class SignUp extends AppCompatActivity {
    private static final String TAG = "SignupActivity";
    private ImageView imageView;
    private CircleImageView btnChoose;
    static final int PICK_IMAGE_REQUEST = 1;
    public static String BASE_URL = "https://yescall.meetlay.com/api/creatuser";
    public static final int MY_PERMISSIONS_REQUEST_READ_Storage=1;
    public SessionManager sessionManager;
    String filePath;
    RequestQueue queue;
    RequestQueue q;
    @InjectView(R.id.input_name) EditText _nameText;
    @InjectView(R.id.input_email) EditText _emailText;
    @InjectView(R.id.input_password) EditText _passwordText;
    @InjectView(R.id.btn_signup) Button _signupButton;
    @InjectView(R.id.link_login) TextView _loginLink;
    @InjectView(R.id.input_password_confirm) EditText confirmPass;
    @InjectView(R.id.phone) EditText phone;

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.signup_activity);
        ButterKnife.inject(this);
        System.setProperty("http.keepAlive", "false");
        _signupButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
//                if (filePath==null || filePath==""){
//                    Toast.makeText(getApplicationContext(),"Please Chose An image",Toast.LENGTH_LONG).show();
//                    return;
//                }
                signup();
            }
        });
        sessionManager=new SessionManager(this);
        queue= Volley.newRequestQueue(this);
        _loginLink.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                // Finish the registration screen and return to the Login activity
                Intent i=new Intent(SignUp.this,LoginActivity.class);
                startActivity(i);
                finish();
            }
        });

        if (ActivityCompat.shouldShowRequestPermissionRationale(this, Manifest.permission.READ_EXTERNAL_STORAGE)) {
            Toast.makeText(this.getApplicationContext(),
                    "Read External Storage permission Needed..",
                    Toast.LENGTH_LONG).show();
        } else {
            ActivityCompat.requestPermissions(
                    this,
                    new String[]{Manifest.permission.READ_EXTERNAL_STORAGE},
                    MY_PERMISSIONS_REQUEST_READ_Storage);
        }

        imageView = (ImageView) findViewById(R.id.imageView);
//        btnChoose = (CircleImageView) findViewById(R.id.button_choose);
//        btnUpload = (Button) findViewById(R.id.button_upload);
     /*   btnChoose.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                imageBrowse();
            }
        }); */
    }
    private void imageBrowse() {
        Intent intent = new Intent();
        intent.setType("image/*");
        intent.setAction(Intent.ACTION_GET_CONTENT);
        startActivityForResult(Intent.createChooser(intent, "Select Picture"),PICK_IMAGE_REQUEST );
    }

    public void signup() {
        Log.d(TAG, "Signup");

        if (!validate()) {
            onSignupFailed();
            return;
        }

        _signupButton.setEnabled(false);

//        final ProgressDialog progressDialog = new ProgressDialog(SignUp.this,
//                R.style.Widget_AppCompat_ProgressBar);
//        progressDialog.setIndeterminate(true);
//        progressDialog.setMessage("Creating Account...");
//        progressDialog.show();

        String name = _nameText.getText().toString();
        String email = _emailText.getText().toString();
        String password = _passwordText.getText().toString();

        // TODO: Implement your own signup logic here.

        new android.os.Handler().postDelayed(
                new Runnable() {
                    public void run() {
                        // On complete call either onSignupSuccess or onSignupFailed
                        // depending on success
                        imageUpload();
//                        onSignupSuccess();
                        // onSignupFailed();
//                        progressDialog.dismiss();
                    }
                }, 3000);
    }


    public void onSignupSuccess() {
        _signupButton.setEnabled(true);
        setResult(RESULT_OK, null);
        finish();
    }

    public void onSignupFailed() {
        Toast.makeText(getBaseContext(), "Fail", Toast.LENGTH_LONG).show();

        _signupButton.setEnabled(true);
    }

    public boolean validate() {
        boolean valid = true;

        String name = _nameText.getText().toString();
        String email = _emailText.getText().toString();
        String password = _passwordText.getText().toString();
        String passc=confirmPass.getText().toString();

        if (name.isEmpty() || name.length() < 3) {
            _nameText.setError("at least 3 characters");
            valid = false;
        } else {
            _nameText.setError(null);
        }

        if (email.isEmpty() || !android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
            _emailText.setError("enter a valid email address");
            valid = false;
        } else {
            _emailText.setError(null);
        }

        if (password.isEmpty() || password.length() < 4 || password.length() > 10) {
            _passwordText.setError("between 4 and 10 alphanumeric characters");
            valid = false;
        } else {
            _passwordText.setError(null);
        }
        if (passc.isEmpty() || passc.length() < 4 || passc.length() > 10) {
            _passwordText.setError("between 4 and 10 alphanumeric characters");

            valid = false;
        if (!passc.equals(password)){
            confirmPass.setError("Password Does not Match");
        valid=false;
        }
        } else {
            _passwordText.setError(null);
        }

        return valid;
    }
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data)
    {
        if (requestCode ==PICK_IMAGE_REQUEST ) {
            //TODO: action
        Toast.makeText(getApplicationContext(),"Image Picked",Toast.LENGTH_LONG).show();
            if(data !=null){
            Uri selectedImage = data.getData();
//            String[] filePathColumn = { MediaStore.Images.Media.DATA };
//
//            Cursor cursor = getContentResolver().query(selectedImage,
//                    filePathColumn, null, null, null);
//            cursor.moveToFirst();
//
//            int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
//            String picturePath = cursor.getString(columnIndex);
//            Toast.makeText(getApplicationContext(),selectedImage.toString(),Toast.LENGTH_LONG).show();
//            cursor.close();
//            ImageView image=(ImageView)findViewById(R.id.myimage);

            Uri uri = data.getData();
            String[] filePathColumn = {MediaStore.Images.Media.DATA};
//            Cursor cursor = getContentResolver().query(uri, filePathColumn, null, null, null);
//            if(cursor.moveToFirst()){
//                int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
//                String yourRealPath = cursor.getString(columnIndex);
//                filePath=yourRealPath;
//            } else {
//                //boooo, cursor doesn't have rows ...
//            }
//            cursor.close();

                filePath=getPathFromUri(getApplicationContext(),uri);

            Toast.makeText(getApplicationContext(),filePath,Toast.LENGTH_LONG).show();
            try {
                Bitmap bitmap = MediaStore.Images.Media.getBitmap(getContentResolver(), selectedImage);
                // Log.d(TAG, String.valueOf(bitmap));


                btnChoose.setImageBitmap(bitmap);
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        }
    }
    private void imageUpload() {
        final ProgressDialog progressDialog = new ProgressDialog(SignUp.this,
                R.style.Theme_AppCompat_Light_Dialog);
//            Toast.makeText(getApplicationContext(),imagePath,Toast.LENGTH_LONG).show();
        progressDialog.setIndeterminate(true);
        progressDialog.setMessage("Creating Account...");
        progressDialog.show();
//        final File fileToUpload = new File(imagePath);
//        Ion.getDefault(SignUp.this).getHttpClient().getSSLSocketMiddleware().setSpdyEnabled(false);
        Ion.getDefault(this).getHttpClient().getSSLSocketMiddleware().setTrustManagers(new TrustManager[] {new X509TrustManager() {
            @Override
            public void checkClientTrusted(final X509Certificate[] chain, final String authType) throws CertificateException {}

            @Override
            public void checkServerTrusted(final X509Certificate[] chain, final String authType) throws CertificateException {}

            @Override
            public X509Certificate[] getAcceptedIssuers() {
                return new X509Certificate[0];
            }
        }});
        Ion.with(SignUp.this)
                .load("POST",BASE_URL)
                .uploadProgressHandler(new ProgressCallback() {
                    @Override
                    public void onProgress(long uploaded, long total) {

                       progressDialog.setProgress(Integer.parseInt(Long.toString(uploaded)));

                    }
                })

                .setBodyParameter("name",_nameText.getText().toString())
                .setBodyParameter("email",_emailText.getText().toString())
                .setBodyParameter("password",_passwordText.getText().toString())
                .setBodyParameter("contact",phone.getText().toString())
                .asString()
                .setCallback(new FutureCallback<String>() {
                    @Override
                    public void onCompleted(Exception e, String result) {
                        //Toast.makeText(getApplicationContext(),"Successs",Toast.LENGTH_LONG).show();
                        if (result != null) {
                            JSONObject response = null;
                            try {
                                response = new JSONObject(result);
                            } catch (JSONException e1) {
                                e1.printStackTrace();
                            }

                            progressDialog.dismiss();
                            boolean b = false;
                            try {
                                b = response.getJSONObject("data").getBoolean("is_login");
                            } catch (JSONException e1) {
                                e1.printStackTrace();
                            }
                            if (b) {
                                Intent intent = new Intent(SignUp.this, MainActivity.class);
                                Bundle bundle = new Bundle();
                                try {
                                    intent.putExtra("api_token", response.getJSONObject("data").getString("api_token"));
                                } catch (JSONException e1) {
                                    e1.printStackTrace();
                                }
                                try {
                                    intent.putExtra("name", response.getJSONObject("data").getString("name"));
                                } catch (JSONException e1) {
                                    e1.printStackTrace();
                                }
                                try {
                                    intent.putExtra("user_id", response.getJSONObject("data").getInt("user_id"));
                                } catch (JSONException e1) {
                                    e1.printStackTrace();
                                }
                                try {
                                    intent.putExtra("is_login", response.getJSONObject("data").getBoolean("is_login"));
                                } catch (JSONException e1) {
                                    e1.printStackTrace();
                                }
                                try {
                                    SingletonClass.getInstance().setValues(response.getJSONObject("data").getString("api_token"),
                                            response.getJSONObject("data").getString("name"), response.getJSONObject("data"),
                                            response.getJSONObject("data").getBoolean("is_login"));
                                } catch (JSONException e1) {
                                    e1.printStackTrace();
                                }
                                try {
                                    Toast.makeText(getApplicationContext(), response.getString("capability_token"), Toast.LENGTH_LONG).show();
                                } catch (JSONException e1) {
                                    e1.printStackTrace();
                                }


                                try {
                                    sessionManager.createLoginSession(response.getJSONObject("data").getString("name"), "waqarulzafar@gmail.com", response.getJSONObject("data").getString("api_token"), response.getString("capability_token"), "0");
                                if(sessionManager.isLoggedIn()){
                                    progressDialog.dismiss();
                                 Toast.makeText(getApplicationContext(),"You are Logged In Successfully.registered Successully...",Toast.LENGTH_LONG).show();
                                    startActivity(intent);
                                }else {
                                    Toast.makeText(getApplicationContext(),"Login Error",Toast.LENGTH_LONG).show();
                                }
                                } catch (JSONException e1) {
                                    e1.printStackTrace();
                                }
                                startActivity(intent);
                                Toast.makeText(getApplicationContext(), result, Toast.LENGTH_LONG).show();
                            } else {
                                //Upload
                                progressDialog.dismiss();
                                Toast.makeText(getApplicationContext(), "Register Successfully Now You Can Login...", Toast.LENGTH_LONG).show();
                            }
                            if (e != null) {
                                Toast.makeText(getApplicationContext(), e.getMessage(), Toast.LENGTH_LONG).show();
                                e.printStackTrace();
                            }
                        }


                    }});

    }
    public static String getPath(Context context, Uri uri ) {
        String result = null;
        String[] proj = { MediaStore.Images.Media.DATA };
        Cursor cursor = context.getContentResolver( ).query( uri, proj, null, null, null );
        if(cursor != null){
            if ( cursor.moveToFirst( ) ) {
                int column_index = cursor.getColumnIndexOrThrow( proj[0] );
                result = cursor.getString( column_index );
            }
            cursor.close( );
        }
        if(result == null) {
            result = "Not found";
        }
        return result;
    }
    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    public static String getPathFromUri(final Context context, final Uri uri) {

        final boolean isKitKat = Build.VERSION.SDK_INT >= Build.VERSION_CODES.KITKAT;

        // DocumentProvider
        if (isKitKat && DocumentsContract.isDocumentUri(context, uri)) {
            // ExternalStorageProvider
            if (isExternalStorageDocument(uri)) {
                final String docId = DocumentsContract.getDocumentId(uri);
                final String[] split = docId.split(":");
                final String type = split[0];

                if ("primary".equalsIgnoreCase(type)) {
                    return Environment.getExternalStorageDirectory() + "/" + split[1];
                }

                // TODO handle non-primary volumes
            }
            // DownloadsProvider
            else if (isDownloadsDocument(uri)) {

                final String id = DocumentsContract.getDocumentId(uri);
                final Uri contentUri = ContentUris.withAppendedId(
                        Uri.parse("content://downloads/public_downloads"), Long.valueOf(id));

                return getDataColumn(context, contentUri, null, null);
            }
            // MediaProvider
            else if (isMediaDocument(uri)) {
                final String docId = DocumentsContract.getDocumentId(uri);
                final String[] split = docId.split(":");
                final String type = split[0];

                Uri contentUri = null;
                if ("image".equals(type)) {
                    contentUri = MediaStore.Images.Media.EXTERNAL_CONTENT_URI;
                } else if ("video".equals(type)) {
                    contentUri = MediaStore.Video.Media.EXTERNAL_CONTENT_URI;
                } else if ("audio".equals(type)) {
                    contentUri = MediaStore.Audio.Media.EXTERNAL_CONTENT_URI;
                }

                final String selection = "_id=?";
                final String[] selectionArgs = new String[] {
                        split[1]
                };

                return getDataColumn(context, contentUri, selection, selectionArgs);
            }
        }
        // MediaStore (and general)
        else if ("content".equalsIgnoreCase(uri.getScheme())) {

            // Return the remote address
            if (isGooglePhotosUri(uri))
                return uri.getLastPathSegment();

            return getDataColumn(context, uri, null, null);
        }
        // File
        else if ("file".equalsIgnoreCase(uri.getScheme())) {
            return uri.getPath();
        }

        return null;
    }

    public static String getDataColumn(Context context, Uri uri, String selection,
                                       String[] selectionArgs) {

        Cursor cursor = null;
        final String column = "_data";
        final String[] projection = {
                column
        };

        try {
            cursor = context.getContentResolver().query(uri, projection, selection, selectionArgs,
                    null);
            if (cursor != null && cursor.moveToFirst()) {
                final int index = cursor.getColumnIndexOrThrow(column);
                return cursor.getString(index);
            }
        } finally {
            if (cursor != null)
                cursor.close();
        }
        return null;
    }


    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is ExternalStorageProvider.
     */
    public static boolean isExternalStorageDocument(Uri uri) {
        return "com.android.externalstorage.documents".equals(uri.getAuthority());
    }

    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is DownloadsProvider.
     */
    public static boolean isDownloadsDocument(Uri uri) {
        return "com.android.providers.downloads.documents".equals(uri.getAuthority());
    }

    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is MediaProvider.
     */
    public static boolean isMediaDocument(Uri uri) {
        return "com.android.providers.media.documents".equals(uri.getAuthority());
    }

    /**
     * @param uri The Uri to check.
     * @return Whether the Uri authority is Google Photos.
     */
    public static boolean isGooglePhotosUri(Uri uri) {
        return "com.google.android.apps.photos.content".equals(uri.getAuthority());
    }

}