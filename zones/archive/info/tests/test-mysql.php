<?php
#  $link = mysqli_connect( 'localhost', 'root', 'password', 'mysql' );
  $link = mysqli_connect    ( '127.0.0.1', 'root', 'password', 'mysql' );

  if ( ! $link )
  {
    print "Cannot connect to mysql server\n";
    exit;
  }

  $result_db = $link->query( "select * from mysql.user");

  print "<h3>PHP MySQL Test</h3>\n";
  print "<h4>select * from mysql.user</h4>\n";

  while ( $row = mysqli_fetch_row( $result_db ) )
  {
    print "$row[0] $row[1] $row[2]<br>\n";
  }

  $result = mysqli_close( $link );

  if ( ! $result )
  {
    print "Cannot disconnect from mysql server.\n";
    exit;
  }
?>
