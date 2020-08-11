package com.yescall.yescall;

import android.Manifest;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;
import androidx.core.content.ContextCompat;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.security.ProviderInstaller;

import org.jetbrains.annotations.Nullable;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

//import java.net.HttpURLConnection;

/**
 * Created by superior on 4/16/2018.
 */

public class LoginActivity extends AppCompatActivity implements ProviderInstaller.ProviderInstallListener {
    private static final String TAG = "Tag";
    private static final int MY_PERMISSIONS_REQUEST_READ_CONTACTS = 1;
    private static final int MY_PERMISSIONS_REQUEST_READ_Storage = 2;
    private static final int Microphone = 3;
    private static final int MIC_PERMISSION_REQUEST_CODE =4 ;
    private static final String PUBLIC_KEY ="helloothisispublickey" ;
    private static final int ERROR_DIALOG_REQUEST_CODE = 1;

    private boolean mRetryProviderInstall;
    private static final char[] KEYSTORE_PASSWORD = null ;
    SessionManager sessionManager;
    ProgressDialog progressDialog;
    Button loginButton;
    EditText email,password;
    RequestQueue queue;
    TextView textView;

    @Override
    protected void onCreate(@Nullable Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.login_activity);
        if (!checkPermissions()) {
            requestPermissionAll();
        }


//        ProviderInstaller.installIfNeededAsync(this, this);
        updateAndroidSecurityProvider();

        email=(EditText) findViewById(R.id.input_email);
        password=(EditText) findViewById(R.id.input_password);
        loginButton=(Button)findViewById(R.id.btn_login);
        System.setProperty("http.keepAlive", "false");


        queue= Volley.newRequestQueue(getApplicationContext());

        textView=(TextView)findViewById(R.id.link_signup);

        textView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent i=new Intent(LoginActivity.this,SignUp.class);
                startActivity(i);
                finish();
            }
        });


        sessionManager=new SessionManager(getApplicationContext());
        if(sessionManager.isLoggedIn()){
            Intent i=new Intent(LoginActivity.this,MainActivity.class);
            startActivity(i);
            finish();
        }
//        Toast.makeText(getApplicationContext(),Boolean.toString(sessionManager.isLoggedIn()),Toast.LENGTH_LONG).show();
        new ProgressDialog(LoginActivity.this,
                R.style.Theme_AppCompat_Light_Dialog);

        loginButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                login();
            }
        });
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, String[] permissions,  int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);

    }

    public void onLoginSuccess() {
        loginButton.setEnabled(true);
        finish();

    }
    public void onLoginFailed() {
        Toast.makeText(getBaseContext(), "Login failed", Toast.LENGTH_LONG).show();

        loginButton.setEnabled(true);
    }
    public boolean validate() {
        boolean valid = true;

        String email = this.email.getText().toString();
        String password = this.password.getText().toString();

        if (email.isEmpty() || !android.util.Patterns.EMAIL_ADDRESS.matcher(email).matches()) {
            this.email.setError("enter a valid email address");
            valid = false;
        } else {
            this.email.setError(null);
        }

        if (password.isEmpty() || password.length() < 4 || password.length() > 10) {
            this.password.setError("between 4 and 10 alphanumeric characters");
            valid = false;
        } else {
            this.password.setError(null);
        }

        return valid;
    }

    private void updateAndroidSecurityProvider() { try { ProviderInstaller.installIfNeeded(this); } catch (Exception e) { e.getMessage(); } }
    public void login() {
        Log.d(TAG, "Login");

        if (!validate()) {
            onLoginFailed();
            return;
        }

        loginButton.setEnabled(false);

        final ProgressDialog progressDialog = new ProgressDialog(LoginActivity.this,
                R.style.Theme_AppCompat_Light_Dialog);
        progressDialog.setIndeterminate(true);
        progressDialog.setMessage("Authenticating...");
        progressDialog.show();

        final String email = this.email.getText().toString();
        final String password = this.password.getText().toString();

        // TODO: Implement your own authentication logic here.

        new android.os.Handler().postDelayed(
                new Runnable() {
                    public void run() {
                        final String url = Config.HOST_URL+"login";

                        Map<String, String> paramss = new HashMap<String, String>();
                        paramss.put("email",email);
                        paramss.put("password",password);
// prepare the Request

                        JsonObjectRequest getRequest = new JsonObjectRequest(Request.Method.POST,url, new JSONObject(paramss),
                                new Response.Listener<JSONObject>()
                                {
                                    @Override
                                    public void onResponse(JSONObject response) {
                                        // display response
                                        progressDialog.dismiss();

                                        Log.d("Response", response.toString());
                                        try {
                                            boolean b=response.getJSONObject("data").getBoolean("is_login");
                                            if (b){
                                                Intent intent=new Intent(LoginActivity.this,MainActivity.class);
                                                Bundle bundle=new Bundle();
                                                intent.putExtra("api_token",response.getJSONObject("data").getString("api_token"));
                                                intent.putExtra("name",response.getJSONObject("data").getString("name"));
                                                intent.putExtra("user_id",response.getJSONObject("data").getInt("user_id"));
                                                intent.putExtra("is_login",response.getJSONObject("data").getBoolean("is_login"));
                                                SingletonClass.getInstance().setValues(response.getJSONObject("data").getString("api_token"),
                                                        response.getJSONObject("data").getString("name"),response.getJSONObject("data"),
                                                        response.getJSONObject("data").getBoolean("is_login"));
//                                                Toast.makeText(getApplicationContext(),response.getString("capability_token"),Toast.LENGTH_LONG).show();


                                                    sessionManager.createLoginSession(response.getJSONObject("data").getString("name"),"waqarulzafar@gmail.com", response.getJSONObject("data").getString("api_token"), response.getString("capability_token"), "0");
                                                startActivity(intent);
//                                                    sessionManager.createLoginSession(response.getJSONObject("data").getString("name"), "waqar@gmail.com", response.getJSONObject("data").getString("api_token"), response.getString("capability_token"), response.getJSONObject("balance").getString("balance"));



                                            }
                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                            Log.e("Error",e.getMessage());
                                            loginButton.setEnabled(true);
                                        }

                                    }
                                },
                                new Response.ErrorListener()
                                {
                                    @Override
                                    public void onErrorResponse(VolleyError error) {
                                        Toast.makeText(getApplicationContext(),error.toString(),Toast.LENGTH_LONG).show();
                                        Log.d("Error.Response", error.toString());
                                        error.printStackTrace();
                                        progressDialog.dismiss();
                                        loginButton.setEnabled(true);
                                    }
                                }){
                            @Override
                            protected Map<String,String> getParams(){
                                Map<String,String> params = new HashMap<String, String>();
//                                params.put("email", email);
//                                params.put("password", password);

                                return params;
                            }};

//
//

// add it to the RequestQueue
//                        getRequest.setRetryPolicy(new DefaultRetryPolicy(500000, 0, DefaultRetryPolicy.DEFAULT_BACKOFF_MULT));
//                        TrustManager[] trustAllCerts = new TrustManager[] { new X509TrustManager() {
//                            public java.security.cert.X509Certificate[] getAcceptedIssuers() {
//                                return null;
//                            }
//                            public void checkClientTrusted(X509Certificate[] certs, String authType) {
//                            }
//                            public void checkServerTrusted(X509Certificate[] certs, String authType) {
//                            }
//                        } };
//                        SSLContext sc = null;
//                        try {
//                            sc = SSLContext.getInstance("SSL");
//                        } catch (NoSuchAlgorithmException e) {
//                            e.printStackTrace();
//                        }
//                        try {
//                            sc.init(null, trustAllCerts, new java.security.SecureRandom());
//                        } catch (KeyManagementException e) {
//                            e.printStackTrace();
//                        }
//                        HttpsURLConnection.setDefaultSSLSocketFactory(sc.getSocketFactory());
//                        // Create all-trusting host name verifier
//                        HostnameVerifier allHostsValid = new HostnameVerifier() {
//                            public boolean verify(String hostname, SSLSession session) {
//                                return true;
//                            }
//                        };
//                        // Install the all-trusting host verifier
//                        HttpsURLConnection.setDefaultHostnameVerifier(allHostsValid);
//                        handleSSLHandshake();
                        getRequest.setShouldCache(false);
//                        VolleyProvider.getInstance(getApplicationContext()).addRequest(getRequest);

                        // On complete call either onLoginSuccess or onLoginFailed
//                        onLoginSuccess();
                        // onLoginFailed();
                        queue.add(getRequest);
                    }
                }, 3000);

    }



    //permission
    private boolean checkPermissions() {
        int resultMic = ContextCompat.checkSelfPermission(this.getApplicationContext(), Manifest.permission.RECORD_AUDIO);
        int resultStorage=ContextCompat.checkSelfPermission(this.getApplicationContext(), Manifest.permission.READ_EXTERNAL_STORAGE);
        int resultWriteStorage=ContextCompat.checkSelfPermission(this.getApplicationContext(), Manifest.permission.WRITE_EXTERNAL_STORAGE);
        if (resultMic == PackageManager.PERMISSION_GRANTED) {
            return true;
        }
        if (resultStorage==PackageManager.PERMISSION_GRANTED){
            return true;
        }
        if (resultWriteStorage==PackageManager.PERMISSION_GRANTED){
            return true;
        }
        return false;
    }

    private void requestPermissionAll() {
        if (ActivityCompat.shouldShowRequestPermissionRationale(this, Manifest.permission.RECORD_AUDIO)) {
            Toast.makeText(this.getApplicationContext(),
                    "Microphone permissions needed. Please allow in App Settings for additional functionality.",
                    Toast.LENGTH_LONG).show();
        } else {
            ActivityCompat.requestPermissions(
                    this,
                    new String[]{Manifest.permission.RECORD_AUDIO},
                    MIC_PERMISSION_REQUEST_CODE);
        }
        if (ActivityCompat.shouldShowRequestPermissionRationale(this, Manifest.permission.READ_EXTERNAL_STORAGE)) {
            Toast.makeText(this.getApplicationContext(),
                    "Microphone permissions needed. Please allow in App Settings for additional functionality.",
                    Toast.LENGTH_LONG).show();
        } else {
            ActivityCompat.requestPermissions(
                    this,
                    new String[]{Manifest.permission.READ_EXTERNAL_STORAGE},
                    MY_PERMISSIONS_REQUEST_READ_Storage);
        }


    }
//    private SSLSocketFactory newSslSocketFactory() {
//        try {
//            // Get an instance of the Bouncy Castle KeyStore format
//            KeyStore trusted = KeyStore.getInstance("BKS");
//            // Get the raw resource, which contains the keystore with
//            // your trusted certificates (root and any intermediate certs)
//            InputStream in = getApplicationContext().getResources().openRawResource(R.raw.keystore);
//            try {
//                // Initialize the keystore with the provided trusted certificates
//                // Provide the password of the keystore
//                trusted.load(in, KEYSTORE_PASSWORD);
//            } finally {
//                in.close();
//            }
//
//            String tmfAlgorithm = TrustManagerFactory.getDefaultAlgorithm();
//            TrustManagerFactory tmf = TrustManagerFactory.getInstance(tmfAlgorithm);
//            tmf.init(trusted);
//
//            SSLContext context = SSLContext.getInstance("TLS");
//            context.init(null, tmf.getTrustManagers(), null);
//
//            SSLSocketFactory sf = context.getSocketFactory();
//            return sf;
//        } catch (Exception e) {
//            throw new AssertionError(e);
//        }
//    }

//
//    private void trustEveryone() {
//        try {
//            HttpsURLConnection.setDefaultHostnameVerifier(new HostnameVerifier(){
//                public boolean verify(String hostname, SSLSession session) {
//                    return true;
//                }});
//            SSLContext context = SSLContext.getInstance("TLS");
//            context.init(null, new X509TrustManager[]{new X509TrustManager(){
//                public void checkClientTrusted(X509Certificate[] chain,
//                                               String authType) throws CertificateException {}
//                public void checkServerTrusted(X509Certificate[] chain,
//                                               String authType) throws CertificateException {}
//                public X509Certificate[] getAcceptedIssuers() {
//                    return new X509Certificate[0];
//                }}}, new SecureRandom());
//            HttpsURLConnection.setDefaultSSLSocketFactory(
//                    context.getSocketFactory());
//        } catch (Exception e) { // should never happen
//            e.printStackTrace();
//        }
//    }
//
//    public static OkHttpClient.Builder getUnsafeOkHttpClient() {
//        try {
//            // Create a trust manager that does not validate certificate chains
//            final TrustManager[] trustAllCerts = new TrustManager[]{
//                    new X509TrustManager() {
//                        @Override
//                        public void checkClientTrusted(java.security.cert.X509Certificate[] chain, String authType) throws CertificateException {
//                        }
//
//                        @Override
//                        public void checkServerTrusted(java.security.cert.X509Certificate[] chain, String authType) throws CertificateException {
//                        }
//
//                        @Override
//                        public java.security.cert.X509Certificate[] getAcceptedIssuers() {
//                            return null;
//                        }
//                    }
//            };

            // Install the all-trusting trust manager
//            final SSLContext sslContext = SSLContext.getInstance("SSL");
//            sslContext.init(null, trustAllCerts, new java.security.SecureRandom());
//            // Create an ssl socket factory with our all-trusting manager
//            final SSLSocketFactory sslSocketFactory = sslContext.getSocketFactory();
//
//            OkHttpClient.Builder builder = new OkHttpClient.Builder();
//            builder.sslSocketFactory(sslSocketFactory, (X509TrustManager)trustAllCerts[0]);
//            builder.hostnameVerifier(new HostnameVerifier() {
//                @Override
//                public boolean verify(String hostname, SSLSession session) {
//                    return true;
//                }
//            });
//
//            return builder;
//        } catch (Exception e) {
//            throw new RuntimeException(e);
//        }
//    }


    @Override
    public void onProviderInstalled() {

    }

    @Override
    public void onProviderInstallFailed(int errorCode, Intent intent) {
        if (GooglePlayServicesUtil.isUserRecoverableError(errorCode)) {
            // Recoverable error. Show a dialog prompting the user to
            // install/update/enable Google Play services.
            GooglePlayServicesUtil.showErrorDialogFragment(
                    errorCode,
                    this,
                    ERROR_DIALOG_REQUEST_CODE,
                    new DialogInterface.OnCancelListener() {
                        @Override
                        public void onCancel(DialogInterface dialog) {
                            // The user chose not to take the recovery action
                            onProviderInstallerNotAvailable();
                        }
                    });
        } else {
            // Google Play services is not available.
            onProviderInstallerNotAvailable();
        }
    }
    private void onProviderInstallerNotAvailable() {
        // This is reached if the provider cannot be updated for some reason.
        // App should consider all HTTP communication to be vulnerable, and take
        // appropriate action.
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode,
                                    Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == ERROR_DIALOG_REQUEST_CODE) {
            // Adding a fragment via GooglePlayServicesUtil.showErrorDialogFragment
            // before the instance state is restored throws an error. So instead,
            // set a flag here, which will cause the fragment to delay until
            // onPostResume.
            mRetryProviderInstall = true;
        }
    }
//    @SuppressLint("TrulyRandom")
//    public static void handleSSLHandshake() {
//        try {
//            TrustManager[] trustAllCerts = new TrustManager[]{new X509TrustManager() {
//                public X509Certificate[] getAcceptedIssuers() {
//                    return new X509Certificate[0];
//                }
//
//                @Override
//                public void checkClientTrusted(X509Certificate[] certs, String authType) {
//                }
//
//                @Override
//                public void checkServerTrusted(X509Certificate[] certs, String authType) {
//                }
//            }};
//
//            SSLContext sc = SSLContext.getInstance("SSL");
//            sc.init(null, trustAllCerts, new SecureRandom());
//            HttpsURLConnection.setDefaultSSLSocketFactory(sc.getSocketFactory());
//            HttpsURLConnection.setDefaultHostnameVerifier(new HostnameVerifier() {
//                @Override
//                public boolean verify(String arg0, SSLSession arg1) {
//                    return true;
//                }
//            });
//        } catch (Exception ignored) {
//        }
//    }




}
