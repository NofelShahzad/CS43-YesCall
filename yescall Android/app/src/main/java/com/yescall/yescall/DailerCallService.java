package com.yescall.yescall;

import android.app.Service;
import android.content.Intent;
import android.os.Binder;
import android.os.Handler;
import android.os.IBinder;
import android.os.SystemClock;
import android.util.Log;
import android.widget.Chronometer;
import android.widget.Toast;

import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.Response;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

public class DailerCallService extends Service {
    private static String LOG_TAG = "BoundService";
    private IBinder mBinder = new MyBinder();
    public static Chronometer mChronometer;
    private SessionManager sessionManager;
    private String credit_id;
    private String country_cost;
    private String contact_history_id;
    private static Handler timerHandler;
    private static Runnable timerRunnable;
    RequestQueue queue;
    public DailerCallService() {
    }

    @Override
    public void onCreate() {
        super.onCreate();
        mChronometer = new Chronometer(getApplicationContext());
        sessionManager=new SessionManager(getApplicationContext());
        mChronometer.setBase(SystemClock.elapsedRealtime());
        queue= Volley.newRequestQueue(getApplicationContext());

        Log.d(LOG_TAG, "TimerService created");
        timerHandler = new Handler();
        timerRunnable = new Runnable() {
            @Override
            public void run() {
                Log.e(LOG_TAG, "TICK");
                Log.e("Update","Chronometer called");
                String url = Config.HOST_URL+"updaetseconds";
                final HashMap<String, String> str = sessionManager.getUserDetails();
                str.put("api_token", sessionManager.getUserDetails().get("api_token"));
                str.put("id", credit_id);
                str.put("country_cost",country_cost);
                str.put("history_id",contact_history_id);
                JsonObjectRequest getRequest1 = new JsonObjectRequest(Request.Method.POST, url, new JSONObject(str),
                        new Response.Listener<JSONObject>() {
                            @Override
                            public void onResponse(JSONObject response) {
                                // display response
//                        Toast.makeText(getActivity(),response.toString(),Toast.LENGTH_LONG).show();

                            }
                        },
                        new Response.ErrorListener() {
                            @Override
                            public void onErrorResponse(VolleyError error) {
                                Log.e("Error.Response", "Errors");
                                Toast.makeText(getApplicationContext(),error.toString(),Toast.LENGTH_LONG).show();

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
                timerHandler.postDelayed(timerRunnable, 1000);
//                Toast.makeText(getApplicationContext(),timerHandler.toString(),Toast.LENGTH_SHORT).show();

            }
        };


//        mChronometer.setOnChronometerTickListener(new Chronometer.OnChronometerTickListener() {
//            @Override
//            public void onChronometerTick(Chronometer chronometer) {
//
//
//
//
//            }
//        });

    }
    public void startTimer() {
        Log.d(LOG_TAG, "Timer started");
        timerHandler.post(timerRunnable);
    }

    public void stopTimer() {
        Log.d(LOG_TAG, "Timer stopped");
        timerHandler.removeCallbacks(timerRunnable);
    }
    @Override
    public void onRebind(Intent intent) {
        Log.e(LOG_TAG, "in onRebind");
        super.onRebind(intent);
    }
    @Override
    public boolean onUnbind(Intent intent) {
        Log.e(LOG_TAG, "in onUnbind");
        return true;
    }
    @Override
    public void onDestroy() {
        super.onDestroy();
        Log.e(LOG_TAG, "in onDestroy");
        mChronometer.stop();
    }

    @Override
    public IBinder onBind(Intent intent) {
//        // TODO: Return the communication channel to the service.
//        throw new UnsupportedOperationException("Not yet implemented");
        Log.e(LOG_TAG, "in onBind");
        return mBinder;
    }
    public long getTimestamp() {
        long elapsedMillis = SystemClock.elapsedRealtime()
                - mChronometer.getBase();
        int hours = (int) (elapsedMillis / 3600000);
        int minutes = (int) (elapsedMillis - hours * 3600000) / 60000;
        long seconds = (long) (elapsedMillis - hours * 3600000 - minutes * 60000) / 1000;
        int millis = (int) (elapsedMillis - hours * 3600000 - minutes * 60000 - seconds * 1000);

//        return hours + ":" + minutes + ":" + seconds + ":" + millis;
   return elapsedMillis;
    }
    public void startChronoMeter(String credit_id,String contact_history_id,String country_cost,Chronometer chronometer){
//        mChronometer.start();
//        mChronometer=chronometer;

        this.country_cost=country_cost;
        this.credit_id=credit_id;
        this.contact_history_id=contact_history_id;

        timerHandler.post(timerRunnable);
    }
    public static void setBaseofChronometer(Chronometer chronometer){
        mChronometer.setBase(SystemClock.elapsedRealtime()-chronometer.getBase());
    }
    public static void stopChronometer(){
        mChronometer.stop();
        timerHandler.removeCallbacks(timerRunnable);
    }
    public void startChrono(){
        mChronometer.start();
    }


    public class MyBinder extends Binder {
        DailerCallService getService() {
            return DailerCallService.this;
        }
    }

    @Override
    public void onTaskRemoved(Intent rootIntent) {
        super.onTaskRemoved(rootIntent);
        Log.e("Task Removed is Called","Task removed");
//        if (MyDailerCall.clientDevice!=null) {
//            MyDailerCall.clientDevice.disconnectAll();
//        }
//        if (MyDailerCall.chronometer!=null){
//        MyDailerCall.chronometer.stop();
//
//        }
//        if (mChronometer!=null){
//        mChronometer.stop();
//        }
//        if (timerHandler!=null) {
//            timerHandler.removeCallbacks(timerRunnable);
//        }
//        if (MyDailerCall.notificationManager!=null){
//        MyDailerCall.notificationManager.cancelAll();
//        }
    }
}
