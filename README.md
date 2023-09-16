# MPoll.github.io

# Warning:
This project is given from University of Regina. That i have solved on my own by having guidance of Professor of CS 215 course. Therefore, i declare that for copying of this code i wouldn't be held responsible for any of this. So if you copy this code for you're Assignments then it would be you're responsibility and only yours. 

Micro-Polling Website is a web application developed as part of course CS 215 (or any relevant course number). It allows users to create, participate in, and manage single-question polls. This repository contains the source code and documentation for the project.

## Project Files

1. **Login.php**: This PHP page is the main page of the polling website. It retrieves recent polls from a database, lets users log in, vote on polls, and redirects them to results. It uses HTML forms and PHP to manage interactions, errors, and database queries. The layout includes a navigation bar, poll list, and login form.

2. **signup.php**: This PHP page is for user registration on the website. It validates user inputs for email, username, and password, checks for existing accounts, handles avatar uploads, and inserts user data into a database. The layout includes a form for entering registration details, including choosing an avatar image. If successful, users are redirected to the login page. If errors occur, they are displayed.

3. **HomePage.php**: This PHP page displays a user's polls and handles voting. It checks if the user is logged in, retrieves their polls from the database, and allows them to vote on options. If a user votes, the database is updated, and the page is redirected to show the results. The layout includes user details, poll questions, options, and voting buttons.

4. **NewPoll.php**: This PHP page allows a logged-in user to create a new poll. It validates user inputs for the question, options, and timing information. If the data is valid, it inserts the poll and associated options into the database. If there are any errors, it displays corresponding error messages. The page includes form fields for poll details, question, options, start and end times, and dates. It also provides a "Create Poll" button to submit the form.

5. **YourVote.php**: This PHP page displays a list of polls for voting, fetched from the database. Users can select options and submit votes. It showcases user avatars and usernames based on sessions. If logged in, recent vote history is shown. The page offers navigation links and dynamically generates poll details, options, and voting forms. Generation and recent vote times are also displayed.

6. **Results.php**: This PHP page displays the results of a poll based on the selected options. It retrieves poll details, user information, and vote statistics from the database. The page includes user avatars and usernames, the poll question, and the voting options along with graphical representations of the vote percentages. It also shows generation and recent vote times. The user can navigate through multiple poll results using the "Previous" and "Next" buttons.

## Features

- User registration and login
- Create and manage polls
- Vote on polls
- Real-time updates of latest polls using AJAX
- Graphical representation of poll results

## JavaScript Files

1. **eventRegisterYourVote.js**: This file handles event registration and AJAX methods for the YourVote.php page, facilitating data retrieval from the database and manipulation on the page.

2. **eventRegisterLogin.js**: This file has been updated to use the `setInterval` function, which uses the function defined in eventHandler.js (`checkForNewPoll`) every 90 seconds.

3. **eventHandler.js**: This file contains a new function named `checkForNewPoll`, which uses AJAX methods to retrieve data from the database about new polls and manipulate it on the login.php page.

## AJAX PHP Files

1. **ajax_login.php**: This server-side logic file accepts requests from the client and processes them according to received data. It then provides data about updated polls in the database and sends it in encoded JSON format.

2. **ajax_pollvote.php**: This server-side logic file accepts requests from eventRegisterYourVote.js and sends encoded JSON data about obtained votes on a particular poll.

## Directory Structure

- **uploads**: This directory handles uploaded avatars
