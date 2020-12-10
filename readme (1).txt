Thank you for using Burgers and Fries' Sandvik Drill Parser! Below is all of the information needed to recreate the system:
(1) Download the files from github
(2) Set up a LAMP stack for running the pages in the folders Find-Drill-System and sandvik-drill-parser, the version numbers  and packages are below:
Apache: 2.4, mysql: 5.6, PHP: 7.0
Packages: php70,mysql56-server,php70-mysqlnd,php70-mbstring
(3) Name the database 'drills', otherwise the REST api won't function.
(4) Using the mysql database dumb inside of the github called drills-database-dump.txt, recreate the database using that file.
*Important notes about the database:
Inside of the table "Drill_Table" will be a null element with drill_id=1, this is often used in code and should be included. Examples are its use
to read the lables of the table when all elements within the list shown on the sandvik-drill-parser page is deleted, another is the search system itself
relying on that element existing when finding no elements at times. The other tables (Pipe Length, Pipe Sizes, etc.) I believe are deprecated and shouldn't be needed,
however in case an unexpected event happens they were included regardless. (Originally, their use was to read the lables of th rigs themselves for searching using them, this
was no longer needed given further understanding of the needs of the site).
