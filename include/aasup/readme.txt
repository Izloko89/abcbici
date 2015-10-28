aasup - anti-auto-sign-up-project
plebian.com 14th may 2002
  
the idea is that an image is generated that a computer program can't read but a human can.
on your signup form, you display this image and ask the user to type in the text. the text is then checked, and if matches, allows the form to go through otherwise not

this is the very early stage for this project and we have kept things very basic for testing purposes (weather it's easy to break or get around etc)

we generate a random 7 char string which is placed onto a randomly generated grid at a slant.  this is then saved as an image out sent to the browser.
this string is then stored in a session and when the form is submitted, the user text (from form) and session text are compared and will tell you of either failure or sucess.
you can see this in the example file signup.php

this project relies upon the php module GD being installed and sessions.
it uses png files by default, if you wish to use another format you'll need to edit aasup.class.php

aasup.class.php - class file that holds the image generation code
	setFont(string font); set a font to use
	getFont(); return the current font in use
	createImage([int w][, int x]); create the image and output it to browser
aasup.php - ultilizes the class file to generate the image and save the random text to sessions
signup.php - example file showing how to use the project