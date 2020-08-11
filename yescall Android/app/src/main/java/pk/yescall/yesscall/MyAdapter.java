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
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.bumptech.glide.Glide;

import org.jetbrains.annotations.Nullable;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;

import static android.view.View.VISIBLE;



public class MyAdapter extends ArrayAdapter<String> {
    //    String[] items;
    private Context context;
    private ArrayList str;
    String contactImage1;
    private SessionManager sessionManager;
    RequestQueue queue;
    JSONArray jsonObject;
    public MyAdapter(Context context,  int resource,  ArrayList<String> objects, JSONArray j) {
        super(context, resource, objects);
        this.context=context;
        this.str=objects;
        jsonObject=j;
        sessionManager=new SessionManager(context);
        queue= Volley.newRequestQueue(context);
    }

    @Override
    public View getView(final int position, @Nullable View convertView,ViewGroup parent) {
        LayoutInflater inflater=(LayoutInflater)context.getSystemService(context.LAYOUT_INFLATER_SERVICE);
        View view=inflater.inflate(R.layout.contact_row_layout,parent,false);
        ImageView call=(ImageView) view.findViewById(R.id.callButton);
        ImageView messageButton=(ImageView)view.findViewById(R.id.messageButton);
        ImageView delButton=(ImageView)view.findViewById(R.id.delete);
        final TextView userName=(TextView)view.findViewById(R.id.text_view_contact_username);
        final TextView dialCode=(TextView)view.findViewById(R.id.dial_code);
        final TextView number=(TextView)view.findViewById(R.id.number);
        final TextView imageUrl=(TextView)view.findViewById(R.id.contact_url);
        final TextView contactId=(TextView)view.findViewById(R.id.contact_id);
        ImageView edit=(ImageView)view.findViewById(R.id.edit);
        final ImageView contactImage=(ImageView)view.findViewById(R.id.image_view_contact_display);

        try {
            userName.setText(jsonObject.getJSONObject(position).getString("name"));
            number.setText(jsonObject.getJSONObject(position).getString("number"));
            dialCode.setText(jsonObject.getJSONObject(position).getString("dial_code"));
            contactId.setText(jsonObject.getJSONObject(position).getString("id"));
            imageUrl.setText("https://yescall.meetlay.com/contact/"+jsonObject.getJSONObject(position).getString("filename"));
            Glide.with(context)
                    .load("https://yescall.meetlay.com/contact/"+jsonObject.getJSONObject(position).getString("filename"))
                    .error(R.drawable.facebook_avatar)
                    .into(contactImage);

        } catch (JSONException e) {
            e.printStackTrace();
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
                    Toast.makeText(context,"Helloo" +position,Toast.LENGTH_LONG).show();
                    AppCompatActivity activity=(AppCompatActivity)context;
                    SendMessage f=new SendMessage();
//                Intent i=new Intent(context,CallFragment.class);
//                i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
//                context.startActivity(i);
                    Bundle args = new Bundle();
                    int id=Integer.parseInt(contactId.getText().toString());
                    args.putString("phone", number.getText().toString());
                    args.putString("contactImage",imageUrl.getText().toString());
                    args.putString("dailCode",dialCode.getText().toString());
                    args.putString("contact_id",Integer.toString(id));
                    Toast.makeText(getContext(),number.getText(),Toast.LENGTH_LONG).show();
                    Toast.makeText(getContext(),imageUrl.getText().toString(),Toast.LENGTH_LONG).show();

                    Toast.makeText(getContext(),dialCode.getText().toString(),Toast.LENGTH_LONG).show();

                    f.setArguments(args);
                    FrameLayout layout=(FrameLayout)activity.findViewById(R.id.pagerFrame);
                    layout.setVisibility(View.INVISIBLE);
                    FrameLayout l= (FrameLayout) activity.findViewById(R.id.mainL);
                    l.removeAllViews();
                    l.setVisibility(VISIBLE);
                    activity.getSupportFragmentManager().beginTransaction().replace(R.id.mainL,f).commit();
                }
            });
        delButton.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {

//                Toast.makeText(context,contactId.getText().toString(),Toast.LENGTH_LONG).show();
                AlertDialog.Builder builder1 = new AlertDialog.Builder(context);
                                builder1.setTitle("Delete Contact");
                                builder1.setMessage("Are you Sure You Want To Delete Contact.");
                                builder1.setCancelable(true);

                                builder1.setPositiveButton(
                                        "Yes",
                                        new DialogInterface.OnClickListener() {
                                            public void onClick(DialogInterface dialog, int id) {

                                String url = "https://harbingerphonecall.herokuapp.com/api/deleteCallList";
                                final HashMap<String, String> str = sessionManager.getUserDetails();
                                str.put("api", sessionManager.getUserDetails().get("api_token"));
                                str.put("id",contactId.getText().toString());
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
                                                Contacts f=new Contacts();
            FrameLayout linearLayout=(FrameLayout) activity.findViewById(R.id.mainL);
            linearLayout.setVisibility(View.VISIBLE);
//            mViewPager.removeAllViews();
//            mViewPager.setVisibility(View.INVISIBLE);




                                                activity.getSupportFragmentManager().beginTransaction().
                                                setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left)
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
        });

        edit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                AppCompatActivity activity=(AppCompatActivity)context;
                FrameLayout layout=(FrameLayout)activity.findViewById(R.id.pagerFrame);
                layout.setVisibility(View.INVISIBLE);
                EditContact f=new EditContact();
                Bundle args = new Bundle();
                args.putString("contact_id",contactId.getText().toString());
                args.putString("phone", number.getText().toString());
                args.putString("name",userName.getText().toString());
                f.setArguments(args);
            FrameLayout framelayour=(FrameLayout)activity.findViewById(R.id.mainL);
            framelayour.setVisibility(View.VISIBLE);
//            mViewPager.removeAllViews();
//            mViewPager.setVisibility(View.INVISIBLE);




                activity.getSupportFragmentManager().beginTransaction()
                        .addToBackStack(null).setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();
            }
        });
        return view;

    }
}
