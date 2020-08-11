package com.yescall.yescall;

import androidx.fragment.app.Fragment;


/**
 * A simple {@link Fragment} subclass.
 * Activities that contain this fragment must implement the
 * create an instance of this fragment.
 */
public class CallFragment extends Fragment {
    // TODO: Rename parameter arguments, choose names that match
    // the fragment initialization parameters, e.g. ARG_ITEM_NUMBER
//    private static final String ARG_PARAM1 = "param1";
//    private static final String ARG_PARAM2 = "param2";
//    private static final String TOKEN_SERVICE_URL = "https://harbingerphonecall.herokuapp.com/gettoken?identity=19173382784";
//    private Connection activeConnection;
//    private Connection pendingConnection;
//    private ClientProfile clientProfile;
//    private Button btnCall;
//    private EditText et;
//    public IntlPhoneInput phoneInputView;
//    private SessionManager sessionManager;
//    private AudioManager audioManager;
//    private int savedAudioMode = AudioManager.MODE_INVALID;
//    private Device clientDevice;
//    private static final int MIC_PERMISSION_REQUEST_CODE = 1;
//
//    // TODO: Rename and change types of parameters
//    private String mParam1;
//    private String mParam2;
//    private Chronometer chronometer;
//    public Context context;
//    private OnFragmentInteractionListener mListener;
//
//    @Override
//    public void onConnecting(Connection connection) {
//
//    }
//    private void initializeTwilioClientSDK() {
//
//        if (!Twilio.isInitialized()) {
//            Twilio.initialize(getContext(), new Twilio.InitListener() {
//
//                /*
//                 * Now that the SDK is initialized we can register using a Capability Token.
//                 * A Capability Token is a JSON Web Token (JWT) that specifies how an associated Device
//                 * can interact with Twilio services.
//                 */
//                @Override
//                public void onInitialized() {
//                    Twilio.setLogLevel(Log.DEBUG);
//                    /*
//                     * Retrieve the Capability Token from your own web server
//                     */
//                    retrieveCapabilityToken(clientProfile);
////                createDevice(sessionManager.getUserDetails().get("capability_token"));
//                }
//
//                @Override
//                public void onError(Exception e) {
//                    Log.e("tag", e.toString());
//                    Toast.makeText(getActivity(), "Failed to initialize the Twilio Client SDK", Toast.LENGTH_LONG).show();
//                }
//            });
//        }
//    }
//
//    @Override
//    public void onConnected(Connection connection) {
//
//    }
//
//    @Override
//    public void onDisconnected(Connection connection) {
//
//    }
//
//    @Override
//    public void onDisconnected(Connection connection, int i, String s) {
//        Toast.makeText(getActivity().getApplicationContext(),s,Toast.LENGTH_LONG).show();
//
//    }
//
//    @Override
//    public void onStartListening(Device device) {
//
//    }
//
//    @Override
//    public void onStopListening(Device device) {
//
//    }
//
//    @Override
//    public void onStopListening(Device device, int i, String s) {
//
//    }
//
//    @Override
//    public boolean receivePresenceEvents(Device device) {
//        return false;
//    }
//
//    @Override
//    public void onPresenceChanged(Device device, PresenceEvent presenceEvent) {
//
//    }
//
//    protected class ClientProfile {
//        private String name;
//        private boolean allowOutgoing = true;
//        private boolean allowIncoming = true;
//
//
//        public ClientProfile(String name, boolean allowOutgoing, boolean allowIncoming) {
//            this.name = "19173382784";
//            this.allowOutgoing = allowOutgoing;
//            this.allowIncoming = allowIncoming;
//        }
//
//        public String getName() {
//            return name;
//        }
//
//        public boolean isAllowOutgoing() {
//            return allowOutgoing;
//        }
//
//        public boolean isAllowIncoming() {
//            return allowIncoming;
//        }
//    }
//    public CallFragment() {
//        // Required empty public constructor
//    }
//
//    /**
//     * Use this factory method to create a new instance of
//     * this fragment using the provided parameters.
//     *
//     * @param param1 Parameter 1.
//     * @param param2 Parameter 2.
//     * @return A new instance of fragment BlankFragment.
//     */
//    // TODO: Rename and change types and number of parameters
//    public static CallFragment newInstance(String param1, String param2) {
//        CallFragment fragment = new CallFragment();
//        Bundle args = new Bundle();
//        args.putString(ARG_PARAM1, param1);
//        args.putString(ARG_PARAM2, param2);
//        fragment.setArguments(args);
//        return fragment;
//    }
//
//    @Override
//    public void onCreate(Bundle savedInstanceState) {
//        super.onCreate(savedInstanceState);
//        if (getArguments() != null) {
//            mParam1 = getArguments().getString(ARG_PARAM1);
//            mParam2 = getArguments().getString(ARG_PARAM2);
//        }
//        sessionManager=new SessionManager(getActivity());
//
//        Toast.makeText(getActivity(),sessionManager.getUserDetails().get("capability_token"),Toast.LENGTH_LONG).show();
//        clientProfile = new ClientProfile("jenny", true, true);
//        if (!checkPermissionForMicrophone()) {
//            requestPermissionForMicrophone();
//        } else {
//            /*
//             * Initialize the Twilio Client SDK
//             */
//            initializeTwilioClientSDK();
//            Toast.makeText(getActivity().getApplicationContext(),"Twilio client intialize successfully...",Toast.LENGTH_LONG).show();
//        }
//
//
//// audioManager = (AudioManager)(Context.AUDIO_SERVICE);
//    }
//
//    @RequiresApi(api = Build.VERSION_CODES.CUPCAKE)
//    @Override
//    public void onViewCreated(View view, @Nullable Bundle savedInstanceState) {
//        super.onViewCreated(view, savedInstanceState);
//        btnCall=(Button)view.findViewById(R.id.call);
//
//        phoneInputView = (IntlPhoneInput)view.findViewById(R.id.my_phone_input);
//        chronometer=(Chronometer)view.findViewById(R.id.chronometer3);
//        chronometer.setOnChronometerTickListener(new Chronometer.OnChronometerTickListener() {
//            @Override
//            public void onChronometerTick(Chronometer chronometer) {
//                Toast.makeText(getActivity(),chronometer.getText().toString(),Toast.LENGTH_SHORT).show();
//            }
//        });
//        phoneInputView.setOnFocusChangeListener(new View.OnFocusChangeListener() {
//            @Override
//            public void onFocusChange(View v, boolean hasFocus) {
//                if (hasFocus){
//                    phoneInputView.hideKeyboard();
//
//                }else {
//                    phoneInputView.hideKeyboard();
//                }
//            }
//        });
//
//        btnCall.setOnClickListener(new View.OnClickListener() {
//            @Override
//            public void onClick(View v) {
//                if (phoneInputView.isValid()) {
//
//                    int code = phoneInputView.getSelectedCountry().getDialCode();
//                    String num = phoneInputView.getNumber();
//                    Toast.makeText(getActivity(), num, Toast.LENGTH_LONG).show();
//                    connect(num, true);
//                    chronometer.setBase(SystemClock.elapsedRealtime());
//                    chronometer.start();}
//
//            }
//        });
//
//    }
//
//
//    private void connect(String contact, boolean isPhoneNumber) {
//        // Determine if you're calling another client or a phone number
//        if (!isPhoneNumber) {
//            contact = "client:" + contact.trim();
//        }
//
//        Map<String, String> params = new HashMap<String, String>();
//        params.put("To", contact);
//        params.put("From", "+19173382784");
//
//        if (clientDevice != null) {
//            // Create an outgoing connection
//            activeConnection = clientDevice.connect(params, this);
//
//        } else {
//            Toast.makeText(getActivity().getApplicationContext(),"Error",Toast.LENGTH_LONG).show();
//
//        }
//    }
//    private void retrieveCapabilityToken(final ClientProfile newClientProfile) {
//        Toast.makeText(getActivity(),"This is Retrieved Token",Toast.LENGTH_LONG).show();
//        // Correlate desired properties of the Device (from ClientProfile) to properties of the Capability Token
//        Uri.Builder b = Uri.parse(TOKEN_SERVICE_URL).buildUpon();
////        if (newClientProfile.isAllowOutgoing()) {
////            b.appendQueryParameter("allowOutgoing", newClientProfile.allowOutgoing ? "true" : "false");
////        }
////        if (newClientProfile.isAllowIncoming() && newClientProfile.getName() != null) {
////            b.appendQueryParameter("client", newClientProfile.getName());
////        }
//        Toast.makeText(getActivity().getApplicationContext(),b.toString(),Toast.LENGTH_LONG).show();
//        Ion.getDefault(getActivity()).getHttpClient().getSSLSocketMiddleware().setSpdyEnabled(false);
//        Ion.with(getActivity())
//                .load(b.toString())
//                .asString()
//                .setCallback(new FutureCallback<String>() {
//
//                    @Override
//                    public void onCompleted(Exception e, String capabilityToken) {
////                        Log.d("excetkj",e.toString());
////                        Toast.makeText(getActivity(),e.toString(),Toast.LENGTH_LONG).show();
//                        if (e == null) {
//                            Log.d("token", capabilityToken);
//
//                            // Update the current Client Profile to represent current properties
//                            CallFragment.this.clientProfile = newClientProfile;
//                            Toast.makeText(getActivity().getApplicationContext(),capabilityToken,Toast.LENGTH_LONG).show();
//                            // Create a Device with the Capability Token
//                            createDevice(capabilityToken);
//                        } else {
//                            Log.e("tsf", "Error retrieving token: " + e.toString());
//                            Toast.makeText(getActivity().getApplication(), "Error retrieving token", Toast.LENGTH_SHORT).show();
//                        }
//                    }
//                });
//    }
//    private void createDevice(String capabilityToken) {
//        try {
//            if (clientDevice == null) {
//                clientDevice = Twilio.createDevice(capabilityToken,this);
//                Toast.makeText(getActivity(),"Client is ready",Toast.LENGTH_LONG).show();
//
//                /*
//                 * Providing a PendingIntent to the newly created Device, allowing you to receive incoming calls
//                 *
//                 *  What you do when you receive the intent depends on the component you set in the Intent.
//                 *
//                 *  If you're using an Activity, you'll want to override Activity.onNewIntent()
//                 *  If you're using a Service, you'll want to override Service.onStartCommand().
//                 *  If you're using a BroadcastReceiver, override BroadcastReceiver.onReceive().
//                 */
//
////                Intent intent = new Intent(getActivity().getApplicationContext(), BlankFragment.th);
////                PendingIntent pendingIntent = PendingIntent.getActivity(getApplicationContext(), 0, intent, PendingIntent.FLAG_UPDATE_CURRENT);
////                clientDevice.setIncomingIntent(pendingIntent);
//            } else {
//                clientDevice.updateCapabilityToken(capabilityToken);
//                Toast.makeText(getActivity(),"Updated token",Toast.LENGTH_LONG).show();
//            }
//
////            TextView clientNameTextView = (TextView) capabilityPropertiesView.findViewById(R.id.client_name_registered_text);
////            clientNameTextView.setText("Client Name: " + ClientActivity.this.clientProfile.getName());
////
////            TextView outgoingCapabilityTextView = (TextView) capabilityPropertiesView.findViewById(R.id.outgoing_capability_registered_text);
////            outgoingCapabilityTextView.setText("Outgoing Capability: " +Boolean.toString(ClientActivity.this.clientProfile.isAllowOutgoing()));
////
////            TextView incomingCapabilityTextView = (TextView) capabilityPropertiesView.findViewById(R.id.incoming_capability_registered_text);
////            incomingCapabilityTextView.setText("Incoming Capability: " +Boolean.toString(ClientActivity.this.clientProfile.isAllowIncoming()));
////
////            TextView libraryVersionTextView = (TextView) capabilityPropertiesView.findViewById(R.id.library_version_text);
////            libraryVersionTextView.setText("Library Version: " + Twilio.getVersion());
//
//        } catch (Exception e) {
//            Log.e("Tag", "An error has occured updating or creating a Device: \n" + e.toString());
//            Toast.makeText(getActivity().getApplicationContext(), "Device error", Toast.LENGTH_SHORT).show();
//        }
//    }
//
//    @Override
//    public View onCreateView(LayoutInflater inflater, ViewGroup container,
//                             Bundle savedInstanceState) {
//        // Inflate the layout for this fragment
//        return inflater.inflate(R.layout.fragment_blank, container, false);
//    }
//
//    // TODO: Rename method, update argument and hook method into UI event
//    public void onButtonPressed(Uri uri) {
//        if (mListener != null) {
//            mListener.onFragmentInteraction(uri);
//        }
//    }
//
//    @Override
//    public void onAttach(Context context) {
//        super.onAttach(context);
//        if (context instanceof OnFragmentInteractionListener) {
//            mListener = (OnFragmentInteractionListener) context;
//        } else {
//            throw new RuntimeException(context.toString()
//                    + " must implement OnFragmentInteractionListener");
//        }
//    }
//
//    @Override
//    public void onDetach() {
//        super.onDetach();
//        mListener = null;
//    }
//
//    /**
//     * This interface must be implemented by activities that contain this
//     * fragment to allow an interaction in this fragment to be communicated
//     * to the activity and potentially other fragments contained in that
//     * activity.
//     * <p>
//     * See the Android Training lesson <a href=
//     * "http://developer.android.com/training/basics/fragments/communicating.html"
//     * >Communicating with Other Fragments</a> for more information.
//     */
//    public interface OnFragmentInteractionListener {
//        // TODO: Update argument type and name
//        void onFragmentInteraction(Uri uri);
//    }
//    private boolean checkPermissionForMicrophone() {
//        int resultMic = ContextCompat.checkSelfPermission(getActivity().getApplicationContext(), Manifest.permission.RECORD_AUDIO);
//        if (resultMic == PackageManager.PERMISSION_GRANTED) {
//            return true;
//        }
//        return false;
//    }
//    private void requestPermissionForMicrophone() {
//        if (ActivityCompat.shouldShowRequestPermissionRationale(getActivity(), Manifest.permission.RECORD_AUDIO)) {
//            Toast.makeText(getActivity().getApplicationContext(),
//                    "Microphone permissions needed. Please allow in App Settings for additional functionality.",
//                    Toast.LENGTH_LONG).show();
//        } else {
//            ActivityCompat.requestPermissions(
//                    getActivity(),
//                    new String[]{Manifest.permission.RECORD_AUDIO},
//                    MIC_PERMISSION_REQUEST_CODE);
//        }
//    }
}
