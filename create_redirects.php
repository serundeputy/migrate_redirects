<?php
/**
 * @file
 *  Create redirects from a data source such as an old site.
 *
 *  Usage:
 *    Make a csv file of the paths from the old data source that will need
 *    redirecting.  Put those paths into a file named redirects.csv in the
 *    data directory.
 *    The csv should have source path, destination path one per line.
 *
 *    I usually run this with drush like:
 *      drush scr create_redirects.php
 */

/**
 * Import URLs from a data source (e.g. an old site)
 * to be redirected to the new URLs.
 */
function create_redirects() {
  $path = BACKDROP_ROOT . '/modules/migrate_redirects/data/redirects.csv';
  $redirects = file($path, FILE_IGNORE_NEW_LINES);
  foreach($redirects as $redirect) {
    $fields = explode(',', $redirect);
    $r = new Redirect();
    //redirect_object_prepare($r);
    $r->source = trim($fields[0]);
    $dest = backdrop_lookup_path('source', trim($fields[1]));
    $r->redirect = $dest;
    $r->type = 'redirect';
    redirect_save($r);
  }
  print_r("\n\tdone.\n");
}

// run the function
create_redirects();