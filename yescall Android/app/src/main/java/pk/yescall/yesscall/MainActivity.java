package pk.yescall.yesscall;

import android.annotation.SuppressLint;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;

import android.net.Uri;
import android.os.Build;
import android.os.Bundle;

import android.text.TextUtils;

import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;

import android.view.Menu;
import android.view.MenuItem;
import android.view.ViewGroup;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.FrameLayout;
import android.widget.ListView;
import android.widget.TextView;


import androidx.annotation.RequiresApi;
import androidx.appcompat.app.ActionBarDrawerToggle;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.widget.Toolbar;
import androidx.core.view.GravityCompat;
import androidx.drawerlayout.widget.DrawerLayout;
import androidx.fragment.app.Fragment;
import androidx.fragment.app.FragmentManager;
import androidx.fragment.app.FragmentPagerAdapter;
import androidx.viewpager.widget.ViewPager;

import com.android.volley.RequestQueue;

import com.google.android.gms.common.GooglePlayServicesUtil;
import com.google.android.gms.security.ProviderInstaller;


import com.google.android.material.floatingactionbutton.FloatingActionButton;
import com.google.android.material.navigation.NavigationView;
import com.google.android.material.tabs.TabLayout;


public class MainActivity extends AppCompatActivity
        implements Dailer.OnFragmentInteractionListener,CheckRate.OnFragmentInteractionListener,Contacts.OnFragmentInteractionListener,AddContact.OnFragmentInteractionListener,AddCredit.OnFragmentInteractionListener,contact_history.OnFragmentInteractionListener,BalanceCheck.OnFragmentInteractionListener
,ProviderInstaller.ProviderInstallListener,SendMessage.OnFragmentInteractionListener,EditContact.OnFragmentInteractionListener{
Button btn;
    private static final int ERROR_DIALOG_REQUEST_CODE = 1;

    private boolean mRetryProviderInstall;
    FloatingActionButton fab;
    ProgressDialog progressDialog;
    RequestQueue queue;
    ListView contactList;
    SessionManager sessionManager;
    public static final String FRAGMENT_CLASS = "MyDailerCall";
    private SectionsPagerAdapter mSectionsPagerAdapter;
    private ViewPager mViewPager;
    @RequiresApi(api = Build.VERSION_CODES.KITKAT)
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        System.setProperty("http.keepAlive", "false");
        Intent i = getIntent();
        String fragmentClass = i.getStringExtra(FRAGMENT_CLASS);
        String phone=i.getStringExtra("phone");
        String dialCode=i.getStringExtra("dail_code");
        String image=i.getStringExtra("image");
        String contactId=i.getStringExtra("contact_id");
        if (!TextUtils.isEmpty(fragmentClass)) {
//         Toast.makeText(getApplicationContext(),"Fragment Calling"+fragmentClass,Toast.LENGTH_LONG).show();
                // Handle the camera action
//                FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
//                layout.setVisibility(View.INVISIBLE);
            Bundle args=new Bundle();

            }else {
            Contacts f= Contacts.newInstance("Helloo","Helloo");
            getSupportFragmentManager().beginTransaction().
                    setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).add(R.id.mainL,f,"CallFragment").commit();

            FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
            layout.setVisibility(View.INVISIBLE);
            FrameLayout frameLayoout=(FrameLayout)findViewById(R.id.mainL);
            frameLayoout.setVisibility(View.VISIBLE);
        }

        sessionManager=new SessionManager(getApplicationContext());
        //end volly request
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_TRANSLUCENT_NAVIGATION, WindowManager.LayoutParams.FLAG_TRANSLUCENT_NAVIGATION);


        ProviderInstaller.installIfNeededAsync(this, this);
//        Contacts f=new Contacts();
//        LinearLayout l=(LinearLayout)findViewById(R.id.mainL);
//        l.removeAllViews();
//        getSupportFragmentManager().beginTransaction().replace(R.id.mainL,f).commit();
        mSectionsPagerAdapter = new SectionsPagerAdapter(getSupportFragmentManager());

        // Set up the ViewPager with the sections adapter.
        mViewPager = (ViewPager) findViewById(R.id.container);
        mViewPager.setAdapter(mSectionsPagerAdapter);

        TabLayout tabLayout = (TabLayout) findViewById(R.id.tabs);
        tabLayout.setupWithViewPager(mViewPager);
        tabLayout.addOnTabSelectedListener(new TabLayout.OnTabSelectedListener() {
            @Override
            public void onTabSelected(TabLayout.Tab tab) {
                FrameLayout mainl=(FrameLayout)findViewById(R.id.mainL);
                mainl.setVisibility(View.INVISIBLE);
                FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
                layout.setVisibility(View.VISIBLE);
            }

            @Override
            public void onTabUnselected(TabLayout.Tab tab) {
//                FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
//                layout.setVisibility(View.VISIBLE);
            }

            @Override
            public void onTabReselected(TabLayout.Tab tab) {
                FrameLayout mainl=(FrameLayout)findViewById(R.id.mainL);
                mainl.setVisibility(View.INVISIBLE);
                FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
                layout.setVisibility(View.VISIBLE);
            }
        });



        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.setDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(mSectionsPagerAdapter);
    }

    @SuppressLint("RestrictedApi")
    @RequiresApi(api = Build.VERSION_CODES.HONEYCOMB)
    @Override
    public void onBackPressed() {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);


FrameLayout frameLayout=(FrameLayout)findViewById(R.id.pagerFrame);
        try {
            if (drawer.isDrawerOpen(GravityCompat.START)) {
                drawer.closeDrawer(GravityCompat.START);
            } else if (getSupportFragmentManager().findFragmentByTag("CallFragment") != null && getSupportFragmentManager().findFragmentByTag("Call").isVisible()) {
                getSupportFragmentManager().popBackStack();
                frameLayout.setVisibility(View.INVISIBLE);

            } else if(getSupportFragmentManager().findFragmentByTag("CallFragment") != null && getSupportFragmentManager().findFragmentByTag("CallFragment").isVisible()){
                getSupportFragmentManager().popBackStack();
                fab.setVisibility(View.INVISIBLE);
            } else {
                super.onBackPressed();
            }
        }catch (NullPointerException e){
            super.onBackPressed();
        }

    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {

        int id = item.getItemId();

   
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

    @SuppressWarnings("StatementWithEmptyBody")

//
//        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
//        drawer.closeDrawer(GravityCompat.START);
//        return true;
//    }

    @Override
    public void onFragmentInteraction(Uri uri) {

    }

    @Override
    public void onProviderInstalled() {

    }

    @Override
    public void onProviderInstallFailed(int errorCode, Intent intent) {
        if (GooglePlayServicesUtil.isUserRecoverableError(errorCode)) {
            // Recoverable error. Show a dialog prompting the user to
            // install/update/enable Google Play services.
            GooglePlayServicesUtil.showErrorDialogFragment(
                    errorCode,
                    this,
                    ERROR_DIALOG_REQUEST_CODE,
                    new DialogInterface.OnCancelListener() {
                        @Override
                        public void onCancel(DialogInterface dialog) {
                            // The user chose not to take the recovery action
                            onProviderInstallerNotAvailable();
                        }
                    });
        } else {
            // Google Play services is not available.
            onProviderInstallerNotAvailable();
        }
    }
    private void onProviderInstallerNotAvailable() {
   
    }
    @Override
    protected void onActivityResult(int requestCode, int resultCode,
                                    Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if (requestCode == ERROR_DIALOG_REQUEST_CODE) {
    
            mRetryProviderInstall = true;
        }
    }
    @SuppressLint("TrulyRandom")



    public static class PlaceholderFragment extends Fragment {
        /**
         * The fragment argument representing the section number for this
         * fragment.
         */
        private static final String ARG_SECTION_NUMBER = "section_number";

        public PlaceholderFragment() {
        }

        /**
         * Returns a new instance of this fragment for the given section
         * number.
         */
        public static PlaceholderFragment newInstance(int sectionNumber) {
            PlaceholderFragment fragment = new PlaceholderFragment();
            Bundle args = new Bundle();
            args.putInt(ARG_SECTION_NUMBER, sectionNumber);
            fragment.setArguments(args);
            return fragment;
        }

        @Override
        public View onCreateView(LayoutInflater inflater, ViewGroup container,
                                 Bundle savedInstanceState) {
            View rootView = inflater.inflate(R.layout.fragment_table_activity_two, container, false);
            TextView textView = (TextView) rootView.findViewById(R.id.section_label);
            textView.setText(getString(R.string.section_format, getArguments().getInt(ARG_SECTION_NUMBER)));
            return rootView;
        }
    }

  
    public class SectionsPagerAdapter extends FragmentPagerAdapter implements NavigationView.OnNavigationItemSelectedListener {
        int id;
        public SectionsPagerAdapter(FragmentManager fm) {
            super(fm);
        }

        @Override
        public Fragment getItem(int position) {
        


            if (position==0){


//
//               getSupportFragmentManager().beginTransaction().setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();
                    return Contacts.newInstance("helloo","helloo");
           }else if (position==1){
               return AddContact.newInstance("Helloo","helloo");
           }else if (position==2){
               return contact_history.newInstance("heellloo","hellooo");

           }else if (position==3){
               return Dailer.newInstance("helll","helklkl");
           }


            return PlaceholderFragment.newInstance(position + 1);
        }

        @Override
        public int getCount() {
            // Show 3 total pages.
            return 4;
        }


        @Override
        public CharSequence getPageTitle(int position) {
            switch (position) {
                case 0:

                    return "Contacts";
                case 1:
                    return "Add Cont.";
                case 2:
                    return "History";
                case 3:
                    return "Dialer";
            }
            return null;
        }


        @Override
    public boolean onNavigationItemSelected(MenuItem item) {
        // Handle navigation view item clicks here.
        id = item.getItemId();
            FrameLayout mainl=(FrameLayout)findViewById(R.id.mainL);
            mainl.setVisibility(View.VISIBLE);
            if (id == R.id.contacts) {
            // Handle the camera action
            id=R.id.contacts;
            FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
            layout.setVisibility(View.INVISIBLE);
            Contacts f=new Contacts();


            getSupportFragmentManager().beginTransaction().
                    setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();

        } else if (id == R.id.dailer) {
            Dailer f=new Dailer();
            FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
            layout.setVisibility(View.INVISIBLE);
//            fab.setVisibility(View.INVISIBLE);

            getSupportFragmentManager().beginTransaction().setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();


        }
        else if (id==R.id.call_history){
            contact_history f=new contact_history();
            FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
            layout.setVisibility(View.INVISIBLE);
//            fab.setVisibility(View.INVISIBLE);
            getSupportFragmentManager().beginTransaction().setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();

        }

        else if (id == R.id.add_contact) {
            AddContact f=new AddContact();
            FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
            layout.setVisibility(View.INVISIBLE);
                        getSupportFragmentManager().beginTransaction().setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();
        } else if (id == R.id.nav_rates) {
            CheckRate f=new CheckRate();
//             l=(LinearLayout)findViewById(R.id.mainL);
            FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
            layout.setVisibility(View.INVISIBLE);
//            fab.setVisibility(View.INVISIBLE);
            getSupportFragmentManager().beginTransaction().setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();
        }else if (id==R.id.nav_logout){
            sessionManager.logoutUser();
            Intent i=new Intent(MainActivity.this,LoginActivity.class);
            startActivity(i);
        }else if(id==R.id.nav_buy_credit){
            AddCredit f=new AddCredit();
            FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
            layout.setVisibility(View.INVISIBLE);
//            fab.setVisibility(View.INVISIBLE);
            getSupportFragmentManager().beginTransaction().setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();
        }else if (id==R.id.credit){
            BalanceCheck f=new BalanceCheck();
            FrameLayout layout=(FrameLayout)findViewById(R.id.pagerFrame);
            layout.setVisibility(View.INVISIBLE);
//            fab.setVisibility(View.INVISIBLE);
            getSupportFragmentManager().beginTransaction().setCustomAnimations(R.anim.enter_from_left, R.anim.exit_to_right, R.anim.enter_from_right, R.anim.exit_to_left).replace(R.id.mainL,f).commit();


        }else if (id==R.id.nav_share_item){
                Intent sharingIntent = new Intent(android.content.Intent.ACTION_SEND);
                sharingIntent.setType("text/plain");
                sharingIntent.putExtra(android.content.Intent.EXTRA_SUBJECT,"Share Our App");
                sharingIntent.putExtra(android.content.Intent.EXTRA_TEXT, shareBodyText);
                startActivity(Intent.createChooser(sharingIntent, "Shearing Option"));
            }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }

    }

    @SuppressLint("LongLogTag")
    @Override
    protected void onStop() {
        super.onStop();
                  Log.e("Stop Method(MainActivity)","Stop is Called");


    }

    @SuppressLint("LongLogTag")
    @Override
    protected void onDestroy() {
        super.onDestroy();
        Log.e("On Destroy in(MainActivity)","On Destroy Is Called");
    }

    @Override
    protected void onPause() {
        super.onPause();
        Log.e("MainActivity OnPause","MainActivity On Pause is Called");
    }

    @Override
    public void finishAndRemoveTask() {
        super.finishAndRemoveTask();

        Log.e("Finish And Removed","Finished And Removed Task is Called");
        
    }
}
