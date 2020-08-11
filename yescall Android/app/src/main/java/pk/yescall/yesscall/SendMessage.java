package pk.yescall.yesscall;

import android.app.ProgressDialog;
import android.content.Context;
import android.net.Uri;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;


public class SendMessage extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;
    private String number,message,countryCode;
    Button sendMessage;
    EditText etMessage;
    SessionManager sessionManager;
    RequestQueue queue;
    ProgressDialog progressDialog;
    TextView sendNumber;

    private OnFragmentInteractionListener mListener;

    public SendMessage() {
        // Required empty public constructor
    }

 
    // TODO: Rename and change types and number of parameters
    public static SendMessage newInstance(String param1, String param2) {
        SendMessage fragment = new SendMessage();
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
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
       etMessage=(EditText)view.findViewById(R.id.message);
        sendMessage=(Button)view.findViewById(R.id.sen_message);
        assert getArguments() != null;
        countryCode=getArguments().getString("dailCode");
        number=getArguments().getString("phone");
        queue= Volley.newRequestQueue(getActivity());
        sendNumber=view.findViewById(R.id.textView3);
        sendNumber.setText(number);
        progressDialog=new ProgressDialog(getActivity(),R.style.Theme_AppCompat_Light_Dialog);
        progressDialog.setMessage("Sending Message");

        sessionManager=new SessionManager(getActivity());
        final HashMap<String,String> str=sessionManager.getUserDetails();
        str.put("api",sessionManager.getUserDetails().get("api_token"));

        JSONObject j=new JSONObject();
        sendMessage.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                progressDialog.show();
                str.put("country_code",countryCode);
                str.put("number",number.replace("+",""));
                str.put("msg",etMessage.getText().toString());
                String url="https://harbingerphonecall.herokuapp.com/api/sendSMS";
                final JsonObjectRequest getRequest = new JsonObjectRequest(Request.Method.POST , url,new JSONObject(str),
                        new Response.Listener<JSONObject>()
                        {
                            @Override
                            public void onResponse(JSONObject response) {
                                // display response

//
                                progressDialog.dismiss();
//                                Toast.makeText(getActivity(),response.toString(),Toast.LENGTH_LONG).show();
                            Toast.makeText(getActivity(),"Message Sent Successfully",Toast.LENGTH_LONG).show();

                            }
                        },
                        new Response.ErrorListener()
                        {
                            @Override
                            public void onErrorResponse(VolleyError error) {
                                Toast.makeText(getActivity(),error.toString(),Toast.LENGTH_LONG).show();
                                Log.d("Error.Response", error.toString());
                                error.printStackTrace();
                                progressDialog.dismiss();
                            }
                        }){
                    @Override
                    protected Map<String,String> getParams(){
                        Map<String,String> params = new HashMap<String, String>();
                        params.put("api", str.get("api_token"));


                        return params;
                    }};


//
// add it to the RequestQueue
                queue.add(getRequest);
            }
        });
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_send_message, container, false);
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


    public interface OnFragmentInteractionListener {
        // TODO: Update argument type and name
        void onFragmentInteraction(Uri uri);
    }
}
