package pk.yescall.yesscall;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.EditText;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.fragment.app.Fragment;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.JsonObject;
import com.paypal.android.sdk.payments.PayPalConfiguration;
import com.paypal.android.sdk.payments.PayPalPayment;
import com.paypal.android.sdk.payments.PayPalService;
import com.paypal.android.sdk.payments.PaymentActivity;
import com.paypal.android.sdk.payments.PaymentConfirmation;

import org.json.JSONObject;

import java.math.BigDecimal;
import java.util.HashMap;
import java.util.Map;


public class AddCredit extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    private static final String ARG_PARAM2 = "param2";

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;
    private Button addCredit;
    private EditText amount;
    SessionManager sessionManager;
    RequestQueue queue,queue1;
    private static final int Paypal_Request_Code=2;
    private static PayPalConfiguration config=new PayPalConfiguration().environment(PayPalConfiguration.ENVIRONMENT_PRODUCTION)
            .clientId(ConfigClientId.PAYPAL_CLIENT_ID);

    private OnFragmentInteractionListener mListener;

    public AddCredit() {
        // Required empty public constructor
    }


    public static AddCredit newInstance(String param1, String param2) {
        AddCredit fragment = new AddCredit();
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
        return inflater.inflate(R.layout.add_credit_fragment, container, false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);
        addCredit=(Button) view.findViewById(R.id.add_credit);
        amount=(EditText)view.findViewById(R.id.input_credit);
        addCredit.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (amount.getText().toString().equals("")||amount.getText().toString().equals("0")||amount.getText()==null){
                    amount.setError("Please Enter valid Amount");
                    return;
                }else {
                    processPayment();
                }

            }
        });
        sessionManager=new SessionManager(getActivity());
        queue= Volley.newRequestQueue(getActivity());

    }
    private void processPayment(){
        String credit=amount.getText().toString();
        PayPalPayment payPalPayment=new PayPalPayment(new BigDecimal(credit),"USD","Buy Credit",PayPalPayment.PAYMENT_INTENT_SALE);
        Intent i=new Intent(getActivity(),PaymentActivity.class);
        i.putExtra(PayPalService.EXTRA_PAYPAL_CONFIGURATION,config);
        i.putExtra(PaymentActivity.EXTRA_PAYMENT,payPalPayment);
        startActivityForResult(i,Paypal_Request_Code);
    }

    @Override
    public void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);

        if (requestCode==Paypal_Request_Code){
            if (data!=null){
            Toast.makeText(getActivity(),"Payment Made Successfully",Toast.LENGTH_LONG).show();
            PaymentConfirmation paymentConfirmation=data.getParcelableExtra(PaymentActivity.EXTRA_RESULT_CONFIRMATION);
       JSONObject paymentDetail=paymentConfirmation.toJSONObject();

                String url = "https://yescall.meetlay.com/api/creatuser/api/buyCredit";
                final HashMap<String, String> str = sessionManager.getUserDetails();
                str.put("api", sessionManager.getUserDetails().get("api_token"));
                str.put("credit", amount.getText().toString());

                JsonObjectRequest getRequest1 = new JsonObjectRequest(Request.Method.POST, url, new JSONObject(str),
                        new Response.Listener<JSONObject>() {
                            @Override
                            public void onResponse(JSONObject response) {
                                // display response
                                Toast.makeText(getActivity(),response.toString(),Toast.LENGTH_LONG).show();

                            }
                        },
                        new Response.ErrorListener() {
                            @Override
                            public void onErrorResponse(VolleyError error) {
                                Log.e("Error.Response", "Errors");
                                Toast.makeText(getActivity(),error.toString(),Toast.LENGTH_LONG).show();


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


                Log.e("Payment Detail",paymentDetail.toString());
            Toast.makeText(getActivity(),paymentDetail.toString(),Toast.LENGTH_LONG).show();
        }else {
                Toast.makeText(getActivity(),"You Canceled The Payment....",Toast.LENGTH_LONG).show();
            }
        }
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
