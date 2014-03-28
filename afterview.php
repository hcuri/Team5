<!--afterview.html-->
<!DOCTYPE HTML>
<html>
    <head>
        <link href="css/styles_afterview.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/jQuery.css" rel="stylesheet" />
        <script src="js/jQuery.js"></script>
        <script src="js/editor.js"></script>
        <script src="js/jquery-1.10.2.js"></script>
        <title>UPresent - Afterview</title>
    </head>
    <body>
        <div id="header">
            <div id="insideHeader"> <img id="logo" src="img/OfficialMiniLogo.png"/>
            </div>
        </div>
        <div id="content">
            
            <!--Title-->
            <div id="UPresentTitle">
                <h1>Lecture 11 By Chris Raley</h1>
            </div>
            
            <!--Left Side Content-->
            <div id="LeftCol">
                <div id="Slides">
                    <img src="img/coverview.png" />
                </div>
                <div id="NoteSection">
                    <form id="notes">
                        <fieldset>
                            <legend>Notes</legend>
                            <textarea rows="10" cols="63">       
    You can still type or correct your notes here after you watch the presentation.
    They will be stored automatically along the specific slide that you were viewing at the moment.
                            </textarea>
                        </fieldset>
                    </form>
                </div>
            </div>
            
            <div id="vline"></div>
            
            <!--Right Side-->
            <div id="RightCol">
                <div id="Chat">
                    <fieldset>
                        <legend>Viewers Chat</legend>
                        <textarea id="chatHistory" rows="15" cols="63">
User1: I really liked Raley's UPresent
                            
User2: Yeah, he's awesome!
                            
User3: I have something important to say to all. "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
                            
User1: That's boring
                        </textarea>
                            <form id="chatForm">
                                <input id="chatInput" type="text" name="chatInput" placeholder="You can comment and chat here" size="50"/>
                                <input id="chatSubmit" type="button" value="Send"/> 
                            </form>
                    </fieldset>
                </div>
                
                <div id="Options">
                    <input id="download" type="button" value="Download Slides" />
                    <input id="contact" type="button" value="Contact Presenter" />
                </div>
            </div>

            <!--Footer-->
            <div id="Footer">
                <form id="save">
                    <input type="button" id="home" value="Home" />
                    <span id="LogoMessage">Created with <img id="bottomlogo" src="img/logoS.png"/></span>
                </form>
            </div>
            
        </div>
    </body>
</html>