package pk.yescall.yesscall;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.Bundle;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.LayoutRes;
import androidx.annotation.NonNull;
import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.bumptech.glide.Glide;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.Date;
import java.util.HashMap;
import java.util.Map;

import static android.view.View.INVISIBLE;
import static android.view.View.VISIBLE;



public class MyCallHistoryAdapter extends ArrayAdapter<String > {
    private Context context;
    private ArrayList str;
    String contactImage1;
    JSONArray jsonObject;
    RequestQueue queue;
    public MyCallHistoryAdapter(@NonNull Context context, @LayoutRes int resource, @NonNull ArrayList<String> objects, JSONArray j) {
        super(context, resource, objects);
        this.context=context;
        this.str=objects;
        jsonObject=j;
        queue= Volley.newRequestQueue(context);
        Log.e("Helloo",jsonObject.toString());
    }

    @NonNull
    @Override
    public View getView(final int position, @Nullable View convertView, @NonNull ViewGroup parent) {
        LayoutInflater inflater=(LayoutInflater)context.getSystemService(context.LAYOUT_INFLATER_SERVICE);
        View view=inflater.inflate(R.layout.history_row_layout,parent,false);
        ImageView call=(ImageView) view.findViewById(R.id.callButton);
        TextView userName=(TextView)view.findViewById(R.id.text_view_contact_username);
        ImageView messageButton=(ImageView)view.findViewById(R.id.messageButton);
        final TextView dialCode=(TextView)view.findViewById(R.id.dial_code);
        final TextView number=(TextView)view.findViewById(R.id.number);
        final TextView imageUrl=(TextView)view.findViewById(R.id.contact_url);
        final TextView contactId=(TextView)view.findViewById(R.id.contact_id);
        final ImageView contactImage=(ImageView)view.findViewById(R.id.image_view_contact_display);
        final TextView duration=(TextView)view.findViewById(R.id.duration);
        final TextView time=(TextView)view.findViewById(R.id.time);
        final TextView id=(TextView)view.findViewById(R.id.id);

        try {
            userName.setText(jsonObject.getJSONObject(position).getJSONObject("contacts").getString("name"));
            number.setText(jsonObject.getJSONObject(position).getJSONObject("contacts").getString("number"));
            dialCode.setText(jsonObject.getJSONObject(position).getJSONObject("contacts").getString("dial_code"));
            contactId.setText(jsonObject.getJSONObject(position).getJSONObject("contacts").getString("id"));
            id.setText(jsonObject.getJSONObject(position).getString("id"));

            time.setText(jsonObject.getJSONObject(position).getString("time") );
            duration.setText(jsonObject.getJSONObject(position).getString("duration")+ " Seconds");

imageUrl.setText("https://yescall.meetlay.com/public/contact/"+jsonObject.getJSONObject(position).getJSONObject("contacts").getString("filename"));
            Glide.with(context)
                    .load("https://yescall.meetlay.com/public/contact/"+jsonObject.getJSONObject(position).getJSONObject("contacts").getString("filename"))
                    .error(R.drawable.facebook_avatar)
                    .into(contactImage);

        } catch (JSONException e) {
            e.printStackTrace();
//            Toast.makeText(context,"Json Exception in Loading Image",Toast.LENGTH_LONG).show();
        }
        call.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
//                Toast.makeText(context,"Helloo" +position,Toast.LENGTH_LONG).show();
                AppCompatActivity activity=(AppCompatActivity)context;

            }
        });

        messageButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {


            deleteHistory(myid);

            }
        });

        return view;

    }
    private String getTimeAsString(long seconds) {
        if (seconds < 60) {     // rule 1
            return String.format("%s seconds", -seconds);
        } else if (seconds < 3600) {  // rule 2
            return String.format("%s minutes ago", -seconds / 60);
        }

        return "null";
    }
    private void deleteHistory(final String myId){
        AlertDialog.Builder builder1 = new AlertDialog.Builder(context);
        builder1.setTitle("Delete History");
        builder1.setMessage("Are you Sure You Want To Delete History.");
        builder1.setCancelable(true);
        builder1.setPositiveButton(
                "Yes",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {

                        String url = "https://i2iapp.uk/apii/deletehistory";
                        final HashMap<String, String> str = new HashMap<String, String>();

                        str.put("id",myId);
                        JsonObjectRequest getRequest1 = new JsonObjectRequest(Request.Method.POST, url, new JSONObject(str),
                                new Response.Listener<JSONObject>() {
                                    @Override
                                    public void onResponse(JSONObject response) {
                                        // display response
//                        Toast.makeText(getActivity(),response.toString(),Toast.LENGTH_LONG).show();
                                        try {
                                            Toast.makeText(context,response.getString("msg"),Toast.LENGTH_LONG).show();
                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                            Toast.makeText(context,"Error accaured While Deleting Record",Toast.LENGTH_LONG).show();
                                        }
                                        AppCompatActivity activity=(AppCompatActivity)context;
                                        FrameLayout layout=(FrameLayout)activity.findViewById(R.id.pagerFrame);
                                        layout.setVisibility(View.INVISIBLE);
                                        contact_history f=new contact_history();
                                        FrameLayout frameLayout= (FrameLayout) activity.findViewById(R.id.mainL);
                                        frameLayout.setVisibility(View.VISIBLE);




                                        activity.getSupportFragmentManager().beginTransaction()
                                                .addToBackStack(null).replace(R.id.mainL,f).commit();

                                    }
                                },
                                new Response.ErrorListener() {
                                    @Override
                                    public void onErrorResponse(VolleyError error) {
                                        Log.e("Error.Response", "Errors");
                                        Toast.makeText(context,error.toString(),Toast.LENGTH_LONG).show();


                                    }
                                }) {
                            @Override
                            protected Map<String, String> getParams() {
                                Map<String, String> params = new HashMap<String, String>();
                                params.put("api_token", str.get("api_token"));


                                return params;
                            }
                        };
                        queue.add(getRequest1);

                        dialog.cancel();
                    }
                });

        builder1.setNegativeButton(
                "No",
                new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int id) {
                        dialog.cancel();
                    }
                });

        AlertDialog alert11 = builder1.create();
        alert11.show();

    }
}
