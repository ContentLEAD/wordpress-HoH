wordpress-HoH
=============

Wordpress Headlines on Homepage designed for PHP websites with wordpress subfolders, written as two classes using a direct db query and metaweblog (xmlrpc.php, respectively.)
-They written as classes instead of scripts to prevent namespace issues involving mysql queries for a particular client.
-These are both intended to be initialized at the beginning of a page, so the styles can be placed in the head rather than in the body as we did in the past.
-Credit for much of the code here (especially the connections and queries for both of these scripts) goes to Brian Corey (bwcorey@gmail.com).  Most of the significant additions were to put it into a class structure for a cleaner call and to prevent namespace issues.

Headlines.php contains example uses of both classes.

HeadlinesImages.PHP is the database query class, and returns headlines with images.
-The initialization requires db user, db password, db name, and host.


HeadlinesXML.PHP is the metaweblog, and currently does not support images.  
-The initialization requires wordpress user, wordpress password, and the link to xmlrpc.php (usually located in the base folder of wordpress.)
-The wordpress user in question requires a certain level of permissions for this to function, otherwise it will fail silently.  I believe it's Editor.

The styles functions in both are the styles used for the client this was written for.  They can be easily modified.
