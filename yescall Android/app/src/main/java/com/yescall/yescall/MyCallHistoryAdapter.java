package com.yescall.yescall;

import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;

import android.content.Intent;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.FrameLayout;
import android.widget.ImageView;
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
import java.util.HashMap;
import java.util.Map;

/**
 * Created by superior on 4/25/2018.
 */

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
//            Long date = System.currentTimeMillis()/1000;
//            String result = (String) DateUtils.getRelativeTimeSpanString(jsonObject.getJSONObject(position).getLong("call_started_at"),date, 0);
//           long myDuration=jsonObject.getJSONObject(position).getLong("call_started_at")-jsonObject.getJSONObject(position).getLong("call_ended_at");
            time.setText(jsonObject.getJSONObject(position).getString("time") );
            duration.setText(jsonObject.getJSONObject(position).getString("duration")+ " Seconds");

imageUrl.setText(Config.BASE_URL+"contact/"+jsonObject.getJSONObject(position).getJSONObject("contacts").getString("filename"));
            Glide.with(context)
                    .load(Config.BASE_URL+"contact/"+jsonObject.getJSONObject(position).getJSONObject("contacts").getString("filename"))
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


                Intent intent=new Intent(activity,VoiceActivity.class);

                Bundle args = new Bundle();
                int id=Integer.parseInt(contactId.getText().toString());
                args.putString("phone", number.getText().toString());
                args.putString("contactImage",imageUrl.getText().toString());
                args.putString("dailCode",dialCode.getText().toString());
                args.putString("contact_id",Integer.toString(id));
                intent.putExtras(args);
                activity.startActivity(intent);

            }
        });

        messageButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

//                Toast.makeText(context,"Helloo" +position,Toast.LENGTH_LONG).show();
//                AppCompatActivity activity=(AppCompatActivity)context;
//                SendMessage f=new SendMessage()                                                                                                                 ;
//                Intent i=new Intent(context,CallFragment.class);
//                i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
//                context.startActivity(i);
//                Bundle args = new Bundle();
//                int id=Integer.parseInt(contactId.getText().toString());
//                args.putString("phone", number.getText().toString());
//                args.putString("contactImage",imageUrl.getText().toString());
//                args.putString("dailCode",dialCode.getText().toString());
//                args.putString("contact_id",Integer.toString(id));
//                Toast.makeText(getContext(),number.getText(),Toast.LENGTH_LONG).show();
//                Toast.makeText(getContext(),imageUrl.getText().toString(),Toast.LENGTH_LONG).show();
//
//                Toast.makeText(getContext(),dialCode.getText().toString(),Toast.LENGTH_LONG).show();
//
//                f.setArguments(args);
//                FrameLayout l= (FrameLayout) activity.findViewById(R.id.mainL);
//                l.removeAllViews();
//                l.setVisibility(VISIBLE);
//                FrameLayout pager=(FrameLayout)activity.findViewById(R.id.pagerFrame);
//                pager.setVisibility(INVISIBLE);
//                activity.getSupportFragmentManager().beginTransaction().replace(R.id.mainL,f).commit();
                String myid=id.getText().toString();
//                Toast.makeText(context,myid,Toast.LENGTH_LONG).show();

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

                        String url = Config.HOST_URL+"deletehistory";
                        final HashMap<String, String> str = new HashMap<String, String>();

                        str.put("id",myId);
                        JsonObjectRequest getRequest1 = new JsonObjectRequest(Request.Method.POST, url, new JSONObject(str),
                                new Response.Listener<JSONObject>() {
                                    @Override
                                    public void onResponse(JSONObject response) {
                                        // display response
//                        Toast.makeText(getActivity(),response.toString(),Toast.LENGTH_LONG).show();
                                        try {
                                            Toast.makeText(context,response.getString("message"),Toast.LENGTH_LONG).show();
                                        } catch (JSONException e) {
                                            e.printStackTrace();
                                            Toast.makeText(context,"Error accaured While Deleting Record",Toast.LENGTH_LONG).show();
                                        }
                                        AppCompatActivity activity=(AppCompatActivity)context;
                                        FrameLayout layout=(FrameLayout)activity.findViewById(R.id.pagerFrame);
                                        layout.setVisibility(View.INVISIBLE);
                                        contact_history f=new contact_history();
//            LinearLayout linearLayout=(LinearLayout)findViewById(R.id.mainL);
//            linearLayout.setVisibility(View.INVISIBLE);
//            mViewPager.removeAllViews();
//            mViewPager.setVisibility(View.INVISIBLE);
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
