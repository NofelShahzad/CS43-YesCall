package com.yescall.yescall;

import android.content.Context;
import android.content.Intent;
import android.net.Uri;
import android.os.Bundle;
import android.os.Vibrator;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

import androidx.annotation.Nullable;
import androidx.appcompat.app.AppCompatActivity;
import androidx.fragment.app.Fragment;

import com.hbb20.CountryCodePicker;

import net.rimoto.intlphoneinput.IntlPhoneInput;


/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * {@link Dailer.OnFragmentInteractionListener} interface
 * to handle interaction events.
 * Use the {@link Dailer#newInstance} factory method to
 * create an instance of this fragment.
 */
public class Dailer extends Fragment implements  View.OnClickListener {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
    private static final String ARG_PARAM1 = "param1";
    String number;
    private static final String ARG_PARAM2 = "param2";
    private View mViewHolder;
    private ImageButton btn0,btn1,btn2,btn3,btn4,btn5,btn6,btn7,btn8,btn9,btnhash,btnstar,btnDelete,btncall,btnContract;
    public IntlPhoneInput phoneInputView;
    EditText phoneNumber;
private CountryCodePicker ccp;

    // TODO: Rename and change types of parameters
    private String mParam1;
    private String mParam2;

    private OnFragmentInteractionListener mListener;

    public Dailer() {
        // Required empty public constructor
    }

    /**
     * Use this factory method to create a new instance of
     * this fragment using the provided parameters.
     *
     * @param param1 Parameter 1.
     * @param param2 Parameter 2.
     * @return A new instance of fragment Dailer.
     */
    // TODO: Rename and change types and number of parameters
    public static Dailer newInstance(String param1, String param2) {
        Dailer fragment = new Dailer();
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
        return inflater.inflate(R.layout.fragment_dailer, container, false);
    }

    @Override
    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
        super.onViewCreated(view, savedInstanceState);

//



        mViewHolder=view;
        phoneNumber=(EditText)view.findViewById(R.id.EditTextPhoneNumber);

        btn0=(ImageButton) view.findViewById(R.id.Button0);
        btn1=(ImageButton) view.findViewById(R.id.Button1);
        btn2=(ImageButton) view.findViewById(R.id.Button2);
        btn3=(ImageButton) view.findViewById(R.id.Button3);
        btn4=(ImageButton) view.findViewById(R.id.Button4);
        btn5=(ImageButton) view.findViewById(R.id.Button5);
        btn6=(ImageButton) view.findViewById(R.id.Button6);
        btn7=(ImageButton) view.findViewById(R.id.Button7);
        btn8=(ImageButton) view.findViewById(R.id.Button8);
        btn9=(ImageButton) view.findViewById(R.id.Button9);
        btnstar=(ImageButton)view.findViewById(R.id.ButtonStar);
        btnhash=(ImageButton)view.findViewById(R.id.ButtonHash);
        btnDelete=(ImageButton)view.findViewById(R.id.ButtonDelete);
        btnContract=(ImageButton)view.findViewById(R.id.ButtonContract);
        ccp=(CountryCodePicker)view.findViewById(R.id.CountryCodePicker);
        btncall=(ImageButton)view.findViewById(R.id.ButtonCall);
        btn0.setOnClickListener(this);
        btn1.setOnClickListener(this);
        btn2.setOnClickListener(this);
        btn3.setOnClickListener(this);
        btn4.setOnClickListener(this);
        btn5.setOnClickListener(this);
        btn6.setOnClickListener(this);
        btn7.setOnClickListener(this);
        btn8.setOnClickListener(this);
        btn9.setOnClickListener(this);
        btnstar.setOnClickListener(this);
        btnhash.setOnClickListener(this);
        btnDelete.setOnClickListener(this);
        btncall.setOnClickListener(this);
        btnContract.setOnClickListener(this);
        ccp.setOnCountryChangeListener(new CountryCodePicker.OnCountryChangeListener() {
            @Override
            public void onCountrySelected() {
//                Toast.makeText(getContext(), "Updated " + ccp.getSelectedCountryName()+" "+ccp.getSelectedCountryCode(), Toast.LENGTH_SHORT).show();
            }
        });
        ccp.registerCarrierNumberEditText(phoneNumber);
        ccp.setNumberAutoFormattingEnabled(false);

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



    /**
     * This interface must be implemented by activities that contain this
     * fragment to allow an interaction in this fragment to be communicated
     * to the activity and potentially other fragments contained in that
     * activity.
     * <p>
     * See the Android Training lesson <a href=
     * "http://developer.android.com/training/basics/fragments/communicating.html"
     * >Communicating with Other Fragments</a> for more information.
     */
    public interface OnFragmentInteractionListener {
        // TODO: Update argument type and name
        void onFragmentInteraction(Uri uri);
    }
    //dailer Function

@Override
    public void onClick(View v) {
        final Vibrator vibrator = (Vibrator)getActivity().getSystemService(Context.VIBRATOR_SERVICE);
        new Thread() {
            @Override
            public void run() {
                vibrator.vibrate(100);
            }
        }.start();



        switch(v.getId()) {
            case R.id.Button0:
                onCharacterPressed('0');
                break;
            case R.id.Button1:
                onCharacterPressed('1');
                break;
            case R.id.Button2:
                onCharacterPressed('2');
                break;
            case R.id.Button3:
                onCharacterPressed('3');
                break;
            case R.id.Button4:
                onCharacterPressed('4');
                break;
            case R.id.Button5:
                onCharacterPressed('5');
                break;
            case R.id.Button6:
                onCharacterPressed('6');
                break;
            case R.id.Button7:
                onCharacterPressed('7');
                break;
            case R.id.Button8:
                onCharacterPressed('8');
                break;
            case R.id.Button9:
                onCharacterPressed('9');
                break;
            case R.id.ButtonStar:
                onCharacterPressed('*');
                break;
            case R.id.ButtonHash:
                onCharacterPressed('#');
                break;
            case R.id.ButtonDelete:
                onDeletePressed();
                break;
            case R.id.ButtonCall:

                String number=ccp.getFormattedFullNumber();
                ccp.setPhoneNumberValidityChangeListener(new CountryCodePicker.PhoneNumberValidityChangeListener() {
                    @Override
                    public void onValidityChanged(boolean isValidNumber) {

                    }
                });

                if (ccp.isValidFullNumber()){
                if (0 != phoneNumber.getText().length()) {

                    AppCompatActivity activity=(AppCompatActivity)getActivity();

                    Intent intent=new Intent(getActivity(),VoiceActivity.class);
                    startActivity(intent);


//                    MyDailerCall f=MyDailerCall.newInstance("helloo","Hellion","","");
//                Intent i=new Intent(context,CallFragment.class);
//                i.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
//                context.startActivity(i);
                    Intent voiceStart=new Intent(getActivity(),VoiceActivity.class);
                    Bundle args = new Bundle();
                    args.putString("phone",number);
                    args.putString("dailCode",ccp.getSelectedCountryCode());
                    voiceStart.putExtras(args);
                    getActivity().startActivity(voiceStart);



//                    f.setArguments(args);
//                    FrameLayout l= (FrameLayout) activity.findViewById(R.id.mainL);
//                    l.removeAllViews();
//                    l.setVisibility(VISIBLE);
//                    FrameLayout pager=(FrameLayout)activity.findViewById(R.id.pagerFrame);
//                    pager.setVisibility(INVISIBLE);
//                    activity.getSupportFragmentManager().beginTransaction().add(R.id.mainL,f,"CallFragment").addToBackStack("CallFragment").commit();
//                   activity.getFragmentManager().executePendingTransactions();
                    }}else {
                    Toast.makeText(getActivity(),"Number Is Invalid Please Enter Valid Number",Toast.LENGTH_LONG).show();
                }
                break;

            case R.id.ButtonContract:

                break;
            case R.id.EditTextPhoneNumber:

                break;
        }
    }

    private void onCharacterPressed(char digit) {
//       private void onCharacterPressed(char digit) {
        CharSequence cur = phoneNumber.getText();

        int start = phoneNumber.getSelectionStart();
        int end = phoneNumber.getSelectionEnd();
        int len = cur.length();


        if (cur.length() == 0) {
            phoneNumber.setCursorVisible(false);
        }

        cur = cur.subSequence(0, start).toString() + digit + cur.subSequence(end, len).toString();
        phoneNumber.setText(cur);
        phoneNumber.setSelection(start+1);
    }
//


    private void onDeletePressed() {
        EditText editText=(EditText) mViewHolder.findViewById(R.id.EditTextPhoneNumber);
        CharSequence cur = editText.getText();
        int start = editText.getSelectionStart();
        int end = editText.getSelectionEnd();
        if (start == end) { // remove the item behind the cursor
            if (start != 0) {
                cur = cur.subSequence(0, start-1).toString() + cur.subSequence(start, cur.length()).toString();
                editText.setText(cur);
                editText.setSelection(start-1);
                if (cur.length() == 0) {
                    editText.setCursorVisible(false);
                }
            }
        } else { // remove the whole selection
            cur = cur.subSequence(0, start).toString() + cur.subSequence(end, cur.length()).toString();
            editText.setText(cur);
            editText.setSelection(end - (end - start));
            if (cur.length() == 0) {
                editText.setCursorVisible(false);
            }
        }
    }


}
