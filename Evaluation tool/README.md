# PHP evaluation tool

In this directory the code for the custom made evaluation tool is made available. It is adopter from [a previously made tool by me](https://github.com/pikawika/bachelorproef-compressie).

## Table of contents
> - [Student info](#student-info)
> - [Setting up the evaluation tool](#setting-up-the-evaluation-tool)
> - [Running the evaluation tool](#running-the-evaluation-tool)
> - [Human made or computer generated](#human-made-or-computer-generated)

## Student info
- **Name**: Bontinck Lennert
- **StudentID**: 568702
- **Affiliation**: VUB - Master Computer Science: AI

## Setting up the evaluation tool
To run this evaluation tool a webserver is needed that is able to serve PHP, html, js and CSS. A PHP database is also needed. The following files allow to edit the most important variables:

- The connection settings for the SQL database can be managed in [db/db_actions.php](db/db_actions.php).
- The administration key for setting up the SQL database can be managed in [setup.php](setup.php).
- The administration key for exporting the SQL database can be managed in [export.php](export.php).
   - NOTE: the generated export of the SQL database is written to a ```results``` folder, if this is sensetive data the folder should be protected by your webserver!
- The introduction video (iframe) can be edited in [introduction.php](introduction.php) and [introduction_nl.php](introduction_nl.php).
- Images should be uploaded to their right folder inside [images](images/):
   - There is a [test folder](images/test/), the ratings for these images will be labeled as "test". Test images allow a user to get comfortable with the rating system as a form of 'burn in'.
   - There is an [evaluation folder](images/evaluation/) for non test images.


## Running the evaluation tool
Before running be sure to have [set up the evaluation tool correctly](setting-up-the-evaluation-tool).

- Go to ```/setup.php?&key={YOUR-KEY}``` to create all required tables, replace ```{YOUR-KEY}``` with your administration key for setting up the database configured [in the previous section](#setting-up-the-evaluation-tool).
- The survey can now be initiated by going to the URL to the evaluation tool.
- After all surveys are completed the ```images```, ```participants``` and ```ratings``` SQL tables can be exported as CSV by going to ```/export.php?&key={YOUR-KEY}```, again your ```{YOUR-KEY}``` should be replaced by your administration key for exporting the database configured [in the previous section](#setting-up-the-evaluation-tool).

## Human made or computer generated
For each image it is randomly selected to show "human made" or "computer generated".

## Order of images
The order of images is randomly selected, but test images are always shown first.