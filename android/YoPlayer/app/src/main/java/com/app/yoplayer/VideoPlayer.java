package com.app.yoplayer;
import android.app.AlertDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.media.MediaPlayer;
import android.net.Uri;
import android.os.Bundle;
import android.os.Handler;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.WindowManager;
import android.widget.MediaController;
import android.widget.ProgressBar;
import android.widget.Toast;
import android.widget.VideoView;
import androidx.appcompat.app.ActionBar;
import androidx.appcompat.app.AppCompatActivity;

public class VideoPlayer extends AppCompatActivity {
    private ProgressBar prb;
    private MediaController ctlr;
    private VideoView videoView;
    private MediaPlayer Mp;
    private Uri uri;
    private Intent intent;
    private ActionBar actionBar;
    private static final int AUTO_SHOWHIDE_DELAY_MILLIS = 1000;
    private boolean SYS_UI_VISIBLE = false;
    private View vView;
    private final Handler showHideHandler = new Handler();
    private final Runnable showHideRunnable = new Runnable() {
        @Override
        public void run() {
            if (SYS_UI_VISIBLE) {
                getWindow().setFlags(WindowManager.LayoutParams.FLAG_FORCE_NOT_FULLSCREEN,
                        WindowManager.LayoutParams.FLAG_FORCE_NOT_FULLSCREEN);
                actionBar = getSupportActionBar();
                actionBar.show();
                SYS_UI_VISIBLE = false;
            } else {
                getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                        WindowManager.LayoutParams.FLAG_FULLSCREEN);
                getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_HIDE_NAVIGATION);
                actionBar = getSupportActionBar();
                actionBar.hide();
                SYS_UI_VISIBLE = true;
            }
        }
    };
    private void toggleV(int delayMillis) {
        showHideHandler.removeCallbacks(showHideRunnable);
        showHideHandler.postDelayed(showHideRunnable, delayMillis);
    }
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
                WindowManager.LayoutParams.FLAG_FULLSCREEN);
        getWindow().getDecorView().setSystemUiVisibility(View.SYSTEM_UI_FLAG_HIDE_NAVIGATION);
        setContentView(R.layout.activity_video);
        // getting the intent data if from main activity or send and opened by other apps as filter app
        intent = getIntent();
        if (("VideoData").equals(intent.getAction()))
            uri = Uri.parse(intent.getStringExtra(Intent.EXTRA_TEXT));
        else
            uri = intent.getData();
        prb = (ProgressBar) findViewById(R.id.vPb);
        prb.setVisibility(View.VISIBLE);
        videoView = (VideoView) findViewById(R.id.vdVw);
        ctlr = new MediaController(this);
        ctlr.setAnchorView(videoView);
        videoView.setMediaController(ctlr);
        videoView.setVideoURI(uri); // setting the uri of the video local file or hosted files
        videoView.requestFocus();
        videoView.start();
        videoView.setOnPreparedListener(new MediaPlayer.OnPreparedListener() {
            @Override
            public void onPrepared(MediaPlayer mp) {
                // TODO Auto-generated method stub
                mp.start();
                // hiding the progress spanner and playing the video
                mp.setOnVideoSizeChangedListener(new MediaPlayer.OnVideoSizeChangedListener() {
                    @Override
                    public void onVideoSizeChanged(MediaPlayer mp, int arg1,
                                                   int arg2) {
                        // TODO Auto-generated method stub
                        Mp = mp;
                        prb.setVisibility(View.GONE);
                        Mp.start();
                    }
                });
            }
        });
        vView = (View) findViewById(R.id.vView);
        vView.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent event) {

                toggleV(AUTO_SHOWHIDE_DELAY_MILLIS);
                return true;
            }
        });

    }
    public void pause(){
        if (Mp != null){
            Mp.pause();
        }
    }

    public void resume(){
        if (Mp != null){
            Mp.start(); //Video will begin where it stopped
        }
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu_main, menu);
        return super.onCreateOptionsMenu(menu);
    }
    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        switch (item.getItemId()) {
            case R.id.action_help:
                helpDialog();
                return true;

            case R.id.action_info:
                infoDialog();
                return true;

            default:
                // If we got here, the user's action was not recognized.
                // Invoke the superclass to handle it.
                return super.onOptionsItemSelected(item);

        }

    }
    @Override
    protected void onPostCreate(Bundle savedInstanceState) {
        super.onPostCreate(savedInstanceState);

        // Trigger the initial hide() shortly after the activity has been
        // created, to briefly hint to the user that UI controls
        // are available.
        toggleV(600);
    }
    /* pausing the video on each dialog fading in
    and resuming the video on each dialog fading out
     */

    // dialog for the actionBar help button is triggered
    private void helpDialog() {
        AlertDialog.Builder dialog = new AlertDialog.Builder(this);
        dialog.setMessage("Specify a video link by pasting it into the box and click play button or choose a local video file to play");
        dialog.setTitle("How to play");
        dialog.setOnDismissListener(new alertDialogI());
        AlertDialog alertDialog = dialog.create();
        dialog.show();
        pause();
    }
    // dialog for the actionBar info button is triggered
    private void infoDialog() {
        AlertDialog.Builder dialog = new AlertDialog.Builder(this);
        dialog.setMessage("Powered by: NajeemB");
        dialog.setTitle("About");
        dialog.setOnDismissListener(new alertDialogI());
        AlertDialog alertDialog = dialog.create();
        dialog.show();
        pause();
    }
    // implementing the DialogInterface.OnDismissListener and resuming each video on each dialog dismiss
    public class alertDialogI implements DialogInterface.OnDismissListener {
        @Override
        public void onDismiss(DialogInterface dialog) {
            resume();
        }
    }
}

// @CopyRights NajeemB
