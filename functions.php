<?php

function enqueue_bk_kaakeli_style() {
  wp_enqueue_style( 'bk_kaakeli', get_stylesheet_directory_uri().'/style.css', array('kaakeli'), '3.2', 'all' );
}
add_action( 'wp_enqueue_scripts', 'enqueue_bk_kaakeli_style' );


function bk_nachrichten_shortcode( $atts) {
  $uploaddir = "wp-content/uploads/";
  $dir = new DirectoryIterator($uploaddir);
  $stack = array();

  foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot() && substr( $fileinfo->getFilename(), 0, 14 ) === "bk-nachrichten" &&   pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION) === "pdf") {
      array_push($stack, $fileinfo->getFilename());
    }
  }
  arsort($stack);

  foreach ($stack as $filename) {
    $time = mktime(0, 0, 0, intval(substr( $filename, 20, 2 )));
    $monat_kurz = strftime("%b", $time);
    $monat_lang = strftime("%B", $time);
    $jahr = substr( $filename, 15, 4 );
    $filenameWithoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);

    $ret = $ret . ' <div class="col-xs-6 col-md-3"><a target="_blank" href="/' . $uploaddir . $filename . '">
        <div class="thumbnail thumbnail-bk">
          <img src="/' .$uploaddir . $filenameWithoutExt . '-pdf.jpg" alt="BK Nachrichten ' . $monat_lang . ' ' . $jahr . '">
          <div class="caption"><small class="visible-xs">' . $monat_kurz . '  '. $jahr . '</small><small class="hidden-xs">' . $monat_lang . '  '. $jahr . '</small></div>
        </div>
      </a>
    </div>';

  }

  return  $ret;
}
add_shortcode( 'bk_nachrichten', 'bk_nachrichten_shortcode' );


function neuste_bk_nachrichten_shortcode( $atts) {
  $uploaddir = "wp-content/uploads/";
  $dir = new DirectoryIterator($uploaddir);
  $stack = array();

  foreach ($dir as $fileinfo) {
    if (!$fileinfo->isDot() && substr( $fileinfo->getFilename(), 0, 14 ) === "bk-nachrichten" &&   pathinfo($fileinfo->getFilename(), PATHINFO_EXTENSION) === "pdf") {
      array_push($stack, $fileinfo->getFilename());
    }
  }
  arsort($stack);


  $filename = array_values($stack)[0];

  $time = mktime(0, 0, 0, intval(substr( $filename, 18, 2 )));
  $name = strftime("%B", $time);
  $jahr = substr( $filename, 15, 4 );
  $filenameWithoutExt = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);

  $ret = '
  <a target="_blank" href="/' . $uploaddir . $filename . '">
    <img class="img-responsive home-bk-thumb" src="/' .$uploaddir . $filenameWithoutExt . '-pdf.jpg" alt="BK Nachrichten' . $name . ' ' . $jahr . '">
  </a>
  ';
  return  $ret;
}
add_shortcode( 'neuste_bk_nachrichten', 'neuste_bk_nachrichten_shortcode' );
?>
