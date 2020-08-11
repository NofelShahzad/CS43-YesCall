package pk.yescall.yesscall;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.view.animation.Animation;
import android.view.animation.AnimationUtils;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.cardview.widget.CardView;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.hbb20.CountryCodePicker;

import org.json.JSONException;
import org.json.JSONObject;
import org.w3c.dom.Text;

import java.util.HashMap;
import java.util.Map;



public class CheckRate extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";
    private static TextView call,landline,sms,name;
    RequestQueue queue;
    private static CardView cardView;

    CountryCodePicker codePicker;


    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private OnFragmentInteractionListener mListener;

    public CheckRate() {
        // Required empty public constructor
    }

    
    // TODO: Rename and change types and number of parameters
    public static CheckRate newInstance(String param1, String param2) {
        CheckRate fragment = new CheckRate();
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
        return inflater.inflate(R.layout.check_rates_fragment, container, false);
    }

    // TODO: Rename method, update argument and hook method into UI event
    public void onButtonPressed(Uri uri) {
        if (mListener != null) {
            mListener.onFragmentInteraction(uri);
        }
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
      codePicker=(CountryCodePicker)view.findViewById(R.id.CountryCodePicker);
        cardView=(CardView) view.findViewById(R.id.maincontaner);
        landline=(TextView)view.findViewById(R.id.rate);
        call=(TextView)view.findViewById(R.id.rate1);
        sms=(TextView)view.findViewById(R.id.rate2);
        name=(TextView)view.findViewById(R.id.search_nearby);
        queue= Volley.newRequestQueue(getActivity());
        codePicker.setOnCountryChangeListener(new CountryCodePicker.OnCountryChangeListener() {
            @Override
            public void onCountrySelected() {
//            cardView.setVisibility(View.VISIBLE);
                final String url = "https://yescall.meetlay.com/api/checkrates";

                Map<String, String> paramss = new HashMap<String, String>();
                paramss.put("code",codePicker.getSelectedCountryCode());

// prepare the Request
                JsonObjectRequest getRequest = new JsonObjectRequest(Request.Method.POST                        , url, new JSONObject(paramss),
                        new Response.Listener<JSONObject>()
                        {
                            @Override
                            public void onResponse(JSONObject response) {
                                // display response
//                                Toast.makeText(getActivity(),response.toString(),Toast.LENGTH_LONG).show();

                                Log.d("Response", response.toString());
                                try {
                                    Animation animation = AnimationUtils.loadAnimation(getActivity(), R.anim.enter_from_right);

                                    cardView.setVisibility(View.INVISIBLE);
                                    String name1=response.getJSONObject("data").getString("name");
                                  String call1=response.getJSONObject("data").getString("cost_per_minute");
                                    String sms1=response.getJSONObject("data").getString("cost_per_sms");
                                    cardView.setVisibility(View.VISIBLE);
                                    cardView.startAnimation(animation);
                                    landline.setText(call1);
                                    call.setText(call1);
                                    sms.setText(sms1);
                                    name.setText(name1);

                                } catch (JSONException e) {
                                    e.printStackTrace();
                                    Toast.makeText(getActivity(),"Sorry Country is not Available Right Now...",Toast.LENGTH_LONG).show();
                                    cardView.setVisibility(View.INVISIBLE);
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
                        params.put("code",codePicker.getSelectedCountryCode());


                        return params;
                    }};
                queue.add(getRequest);
            }
        });

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
