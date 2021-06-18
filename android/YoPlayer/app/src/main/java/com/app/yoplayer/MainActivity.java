package com.app.yoplayer;
import androidx.appcompat.app.AppCompatActivity;
import androidx.appcompat.app.ActionBar;
import android.app.AlertDialog;
import android.content.Intent;
import android.graphics.PixelFormat;
import android.os.Bundle;
import android.net.Uri;
import android.os.Handler;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.WindowManager;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageButton;
import android.widget.Toast;

public class MainActivity extends AppCompatActivity {
    private EditText urlEtext;
    private Intent tintent, cfintent, intent;
    private ImageButton vpGb;
    private Button chooseFb;
    private Uri choosenFile;
    private ActionBar actionBar;
    private static final int AUTO_SHOWHIDE_DELAY_MILLIS = 1000;
    private boolean SYS_UI_VISIBLE = false;
    private View mainView;
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
        getWindow().setFormat(PixelFormat.TRANSLUCENT);
        setContentView(R.layout.activity_main);
        urlEtext = (EditText) findViewById(R.id.urlEt);
        tintent = new Intent(MainActivity.this, VideoPlayer.class);
        vpGb = (ImageButton) findViewById(R.id.gbutton);
        vpGb.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if (urlEtext.getText().toString().isEmpty()) {
                    Toast.makeText(MainActivity.this, "No url provided", Toast.LENGTH_SHORT).show();
                } else {
                    tintent.putExtra(Intent.EXTRA_TEXT, urlEtext.getText().toString());
                    tintent.setAction("VideoData");
                    startActivity(tintent);
                }
            }
        });
        chooseFb = (Button) findViewById(R.id.fbutton);
        chooseFb.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                try {
                    intent = new Intent()
                            .setType("*/*")
                            .setAction(Intent.ACTION_GET_CONTENT);
                    startActivityForResult(Intent.createChooser(intent, "Choose a file"), 123);
                } catch(Exception ex) {
                    Toast.makeText(MainActivity.this, "Exception: "+ex.getMessage(), Toast.LENGTH_SHORT).show();
                }
            }
        });
        mainView = (View) findViewById(R.id.mainView);
        mainView.setOnTouchListener(new View.OnTouchListener() {
            @Override
            public boolean onTouch(View view, MotionEvent event) {

                toggleV(AUTO_SHOWHIDE_DELAY_MILLIS);
                return true;
            }
        });

    }
    // handling the choose file dialog
    @Override
    protected void onActivityResult(int requestCode, int resultCode, Intent data) {
        super.onActivityResult(requestCode, resultCode, data);
        if(requestCode == 123 && resultCode == RESULT_OK) {
            choosenFile = data.getData(); //The uri with the location of the file
            if (choosenFile.toString().isEmpty()) {
                Toast.makeText(MainActivity.this, "No file chosen", Toast.LENGTH_SHORT).show();
            } else {
                cfintent = new Intent(this, VideoPlayer.class);
                cfintent.putExtra(Intent.EXTRA_TEXT, choosenFile.toString());
                cfintent.setAction("VideoData");
                startActivity(cfintent);
            }
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
    // dialog for the actionBar help button is triggered
    private void helpDialog() {
        AlertDialog.Builder dialog = new AlertDialog.Builder(this);
        dialog.setMessage("Specify a video link by pasting it into the box and click play button or choose a local video file to play");
        dialog.setTitle("How to play");
        AlertDialog alertDialog = dialog.create();
        dialog.show();
    }
    // dialog for the actionBar info button is triggered
    private void infoDialog() {
        AlertDialog.Builder dialog = new AlertDialog.Builder(this);
        dialog.setMessage("Powered by: NajeemB");
        dialog.setTitle("About");
        AlertDialog alertDialog = dialog.create();
        dialog.show();
    }
}

// @CopyRights NajeemB
