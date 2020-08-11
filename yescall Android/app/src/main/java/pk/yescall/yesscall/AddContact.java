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

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.annotation.RequiresApi;
import androidx.core.app.ActivityCompat;
import androidx.fragment.app.Fragment;

import com.koushikdutta.async.future.FutureCallback;
import com.koushikdutta.ion.Ion;
import com.koushikdutta.ion.ProgressCallback;

import net.rimoto.intlphoneinput.IntlPhoneInput;

import java.io.File;
import java.io.IOException;
import java.security.cert.CertificateException;
import java.security.cert.X509Certificate;

import javax.net.ssl.TrustManager;
import javax.net.ssl.X509TrustManager;

import de.hdodenhof.circleimageview.CircleImageView;



public class AddContact extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private CircleImageView btnChoose;
    private EditText etname;
    public static final int MY_PERMISSIONS_REQUEST_READ_Storage=1;
    private String name;
    IntlPhoneInput number;
    Button addContact;
    static final int PICK_IMAGE_REQUEST = 1;
    public static String BASE_URL = "https://harbingerphonecall.herokuapp.com/api/postcontact";
    String filePath;
    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;
    ProgressDialog progressDialog;
private SessionManager sessionManager;
    private OnFragmentInteractionListener mListener;

    public AddContact() {
        // Required empty public constructor
    }

 
    // TODO: Rename and change types and number of parameters
    public static AddContact newInstance(String param1, String param2) {
        AddContact fragment = new AddContact();
        Bundle args = new Bundle();
        args.putString(ARG_PARAM1, param1);
        args.putString(ARG_PARAM2, param2);
        fragment.setArguments(args);
        return fragment;
    }

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        if (getArguments() != null) {
            mParam1 = getArguments().getString(ARG_PARAM1);
            mParam2 = getArguments().getString(ARG_PARAM2);
        }
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.add_contact_fragment, container, false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        btnChoose=(CircleImageView) view.findViewById(R.id.add_contact_image1);
        etname=(EditText)view.findViewById(R.id.inputName);
        number=(IntlPhoneInput)view.findViewById(R.id.phoneNumber);

        addContact=(Button)view.findViewById(R.id.add_contact_button);
        sessionManager=new SessionManager(getActivity());
        if (ActivityCompat.shouldShowRequestPermissionRationale(getActivity(), Manifest.permission.READ_EXTERNAL_STORAGE)) {
            Toast.makeText(this.getActivity(),
                    "Read External Storage permission Needed..",
                    Toast.LENGTH_LONG).show();
            ActivityCompat.requestPermissions(
                    getActivity(),
                    new String[]{Manifest.permission.READ_EXTERNAL_STORAGE},
                    MY_PERMISSIONS_REQUEST_READ_Storage);
        } else {
            ActivityCompat.requestPermissions(
                    getActivity(),
                    new String[]{Manifest.permission.READ_EXTERNAL_STORAGE},
                    MY_PERMISSIONS_REQUEST_READ_Storage);
        }
        btnChoose.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                imageBrowse();
            }
        });
        addContact.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
             if (!number.isValid()){

                Toast.makeText(getActivity(),"Number is Invalid",Toast.LENGTH_LONG).show();
                 return;
             }
             if (etname.getText().toString().equals("")|| etname.getText().toString().length()<3){
                 etname.setError("Name Must have at least Three Character.");
                 return;
             }
             if (filePath==null || filePath.equals("")){
                 Toast.makeText(getActivity(),"Please Chose an Image.",Toast.LENGTH_LONG).show();
                 return;
             }

            addToContact();
            }
        });
    }

    public void checkPermission(){
        if (ActivityCompat.shouldShowRequestPermissionRationale(getActivity(), Manifest.permission.READ_EXTERNAL_STORAGE)) {
            Toast.makeText(this.getActivity(),
                    "Read External Storage permission Needed..",
                    Toast.LENGTH_LONG).show();
            ActivityCompat.requestPermissions(
                    getActivity(),
                    new String[]{Manifest.permission.READ_EXTERNAL_STORAGE},
                    MY_PERMISSIONS_REQUEST_READ_Storage);
        } else {
            ActivityCompat.requestPermissions(
                    getActivity(),
                    new String[]{Manifest.permission.READ_EXTERNAL_STORAGE},
                    MY_PERMISSIONS_REQUEST_READ_Storage);
        }
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);
        if (requestCode==MY_PERMISSIONS_REQUEST_READ_Storage){

            Toast.makeText(getActivity(),"Permission Granted",Toast.LENGTH_LONG).show();
        }else {

        }
    }

    private void addToContact(){
        checkPermission();
        final ProgressDialog progressDialog = new ProgressDialog(getActivity(),
                R.style.Theme_AppCompat_Light_Dialog);
        progressDialog.setIndeterminate(true);
        progressDialog.setMessage("Uploading Contact...");
        progressDialog.show();

        final File fileToUpload = new File(filePath);
//        Ion.getDefault(getActivity()).getHttpClient().getSSLSocketMiddleware().setTrustManagers(new TrustManager[] {new X509TrustManager() {
//            @Override
//            public void checkClientTrusted(final X509Certificate[] chain, final String authType) throws CertificateException {}
//
//            @Override
//            public void checkServerTrusted(final X509Certificate[] chain, final String authType) throws CertificateException {}
//
//            @Override
//            public X509Certificate[] getAcceptedIssuers() {
//                return new X509Certificate[0];
//            }
//        }});
        Ion.with(getActivity())
                .load("POST",BASE_URL)
                .uploadProgressHandler(new ProgressCallback() {
                    @Override
                    public void onProgress(long uploaded, long total) {
                        progressDialog.setProgress(Integer.parseInt(Long.toString(uploaded)));
                    }
                })
                .setMultipartFile("filename", "image/jpeg", fileToUpload)
                .setMultipartParameter("api_token",sessionManager.getUserDetails().get("api_token"))
                .setMultipartParameter("dial_code",Integer.toString(number.getSelectedCountry().getDialCode()))
                .setMultipartParameter("name",etname.getText().toString())
                .setMultipartParameter("phone",number.getNumber())
                .asString()
                .setCallback(new FutureCallback<String>() {
                    @Override
                    public void onCompleted(Exception e, String result) {
                        Toast.makeText(getActivity(),"Successs",Toast.LENGTH_LONG).show();
                        if (result != null) {
                            //Upload Success
                            progressDialog.dismiss();

                            FrameLayout layout=(FrameLayout)getActivity().findViewById(R.id.pagerFrame);
                            layout.setVisibility(View.INVISIBLE);
                            FrameLayout mainL=(FrameLayout)getActivity().findViewById(R.id.mainL);
                            mainL.setVisibility(View.VISIBLE);
                            Contacts f=new Contacts();
                           getActivity().getSupportFragmentManager().beginTransaction().
                                    setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();



                            Toast.makeText(getActivity(),result,Toast.LENGTH_LONG).show();
                        } else {
                            //Upload
                            Toast.makeText(getActivity(),"Failed To Upload Contact",Toast.LENGTH_LONG).show();
                       progressDialog.dismiss();
                        }
                        if (e!=null){
                            Toast.makeText(getActivity(),e.getMessage(),Toast.LENGTH_LONG).show();
                            progressDialog.dismiss();
                        }
                    }


                });

    }
    private void imageBrowse() {
        checkPermission();
        Intent intent = new Intent();
        intent.setType("image/*");
        intent.setAction(Intent.ACTION_GET_CONTENT);
        startActivityForResult(Intent.createChooser(intent, "Select Picture"),PICK_IMAGE_REQUEST );
    }
    // TODO: Rename method, update argument and hook method into UI event
    public void onButtonPressed(Uri uri) {
        if (mListener != null) {
            mListener.onFragmentInteraction(uri);
        }
    }

    @Override
    public void onAttach(Context context) {
        super.onAttach(context);
        if (context instanceof OnFragmentInteractionListener) {
            mListener = (OnFragmentInteractionListener) context;
        } else {
            throw new RuntimeException(context.toString()
                    + " must implement OnFragmentInteractionListener");
        }
    }

    @Override
    public void onDetach() {
        super.onDetach();
        mListener = null;
    }
    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data)
    {
        checkPermission();
        if(data!=null){
        if (requestCode ==PICK_IMAGE_REQUEST ) {
            //TODO: action


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

            filePath=getPathFromUri(getActivity(),uri);

            Toast.makeText(getActivity(),filePath,Toast.LENGTH_LONG).show();
            try {
                Bitmap bitmap = MediaStore.Images.Media.getBitmap(getActivity().getContentResolver(), selectedImage);
                // Log.d(TAG, String.valueOf(bitmap));


                btnChoose.setImageBitmap(bitmap);
            } catch (IOException e) {
                e.printStackTrace();
            }
        }
        }
    }

  
    public interface OnFragmentInteractionListener {
        // TODO: Update argument type and name
        void onFragmentInteraction(Uri uri);
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
