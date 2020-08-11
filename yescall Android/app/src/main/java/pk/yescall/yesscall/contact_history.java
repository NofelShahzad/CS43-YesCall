package pk.yescall.yesscall;

import android.content.Context;
import android.net.Uri;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ListView;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Map;


public class contact_history extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;
    RequestQueue queue;
    ListView contactList;
    SessionManager sessionManager;
    

    private OnFragmentInteractionListener mListener;

    public contact_history() {
        // Required empty public constructor
    }

    // TODO: Rename and change types and number of parameters
    public static contact_history newInstance(String param1, String param2) {
        contact_history fragment = new contact_history();
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

        queue= Volley.newRequestQueue(getActivity());
        contactList=(ListView)view.findViewById(R.id.contact_list);
        String token=SingletonClass.getInstance().getApiToken();
        sessionManager=new SessionManager(getActivity());
        final HashMap<String,String> str=sessionManager.getUserDetails();
        str.put("api",sessionManager.getUserDetails().get("api_token"));
        JSONObject j=new JSONObject();

//volly request
        String url="https://yescall.meetlay.com/api/callhistory";
        final JsonObjectRequest getRequest = new JsonObjectRequest(Request.Method.POST , url,new JSONObject(str),
                new Response.Listener<JSONObject>()
                {
                    @Override
                    public void onResponse(JSONObject response) {
                        // display response

//                        Log.d("Response", response.toString());
                        MyCallHistoryAdapter adapter= null;
                        ArrayList<String> arr=new ArrayList<String>();
                        try {
//                            Toast.makeText(getActivity(),"Legnth Is"+response.getJSONArray("contacts").length(),Toast.LENGTH_LONG).show();
                            for (int i=0;i<response.getJSONArray("data").length();i++){
                                arr.add(response.getJSONArray("data").getString(i));
                            }

                            try {
                                adapter = new MyCallHistoryAdapter(getActivity(), R.layout.support_simple_spinner_dropdown_item, arr, response.getJSONArray("data"));
                            }catch (NullPointerException e){
                                e.printStackTrace();
                            }
                            contactList.setAdapter(adapter);
                        } catch (JSONException e) {
                            e.printStackTrace();
                        }


                    }
                },
                new Response.ErrorListener()
                {
                    @Override
                    public void onErrorResponse(VolleyError error) {
                        Toast.makeText(getActivity(),error.toString(),Toast.LENGTH_LONG).show();
                        Log.d("Error.Response", error.toString());
                    }
                }){
            @Override
            protected Map<String,String> getParams(){
                Map<String,String> params = new HashMap<String, String>();
                params.put("api_token", str.get("api_token"));


                return params;
            }};



// add it to the RequestQueue
        queue.add(getRequest);
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment
        return inflater.inflate(R.layout.fragment_contact_history, container, false);
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
