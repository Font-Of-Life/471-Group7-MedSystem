# 471-Group7-MedSystem

## Setup Instruction Steps:
1. Download appServ. ***Take note of your root username and root password for mySQL installation, we need it for the steps later on!**

2. Upon downloading appServ onto your computer go to your search bar on windows and type **MySQL Start** and click on it, and allow access.

3. Do the same thing again from **"step 2"** but this time search for **Apache Start**.

4. Go to the github folder **"SQL Database"** and download the **med_database.sql** file onto your computer.

5. Download the entire folder **"Med-System"** onto your desktop or download the files contained in that folder onto your desktop and into a new folder.

6. Go into that folder in the previous step, and open up the **"connections.php"** with a text editor (Visual Studio or Notepad++).

7. Upon it opening, change the **"$db_username"** variable to be your root username for your mySQL installation, and the **"db_password"** to be your password for mySQL. And then save it, and close it.

8. Go to the AppServ folder. ***By default it should be on your local disk drive (C:) or "C:\" in windows explorer bar.

9. Drag that folder from **step 5**, to the folder in appServ named **"www"**.

10. Now go type into a web browser "http://localhost/phpmyadmin", and log in with your corresponding mySQL root username and password you made during installation from **step 1**.

11. Upon logging in select the **"Import"** option, hit the **"choose file"** button, and then find and select the **med_database.sql** file, then hit the **"Go"** button.

12. The file should have been uploaded onto myphpadmin, now go to http://localhost/**"insert your folder name from step 9 after"** and you have access to the site!

If ya want to end the process of MySQL and Apache, just type into your search bar on your computer **"MySQL Stop"** and **"Apache Stop"** respectively, 
and do the same thing as **step 2 and 3**. 
