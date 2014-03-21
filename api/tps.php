<?php
	require_once "header.php";
?>

<body bgcolor="#333333">
	<CENTER>
    <DIV ID="header">
    	<div style="position:relative;width:1400px;"><IMG SRC="images/TBHeaderFixed.png" />
        <a href="index.php" id="name">TBDesigns</a>
        <span id="head1">Beautiful websites</span>
        <span id="head2">For beautiful people</span>
        <a href="mailto:webmaster@imagedfw.com" id="email">webmaster@imagedfw.com</a>
        </div>
    </DIV>
    <DIV ID="SiteHolder">
    	<DIV ID="SelectedWorks">
        	TEXAS PROTEIN SOLUTIONS<A href="tlc.php" id="next"><img src="images/next.gif" /></A><a href="jep.php" ID="prev"><img src="images/prev.gif" /></a>
        </DIV>
        
        <CENTER>
            <DIV ID="SiteDescript">
                With a scrollable design that eleminates load-time with back-end loading of the elements and pictures, Texas Protein Solutions featured a easy to use contact form and clutterless menu for easy navigation.
            </DIV>
            <br />
            <img src="images/sitePics/tps1.jpg" id="sitePic" /><br /><br />
            <img src="images/sitePics/tps2.jpg" id="sitePic" /><br /><br />
            <img src="images/sitePics/tps3.jpg" id="sitePic" /><br />
        </CENTER><br />
        
        <DIV ID="SelectedWorks">
        	CONTACT
        </DIV>
        
        <DIV ID="Contact">
            <FORM ID="Contact" ACTION="Contacted.php" METHOD="POST">
                <DIV ID="headers">Name </DIV><INPUT TYPE="text" NAME="name" ID="name" /><div id='Contact_name_errorloc'></div>
                <DIV ID="headers">Email</DIV><INPUT TYPE="text" NAME="email" ID="name" /><div id='Contact_email_errorloc'></div>
                <DIV ID="headers">Subject</DIV><INPUT TYPE="text" NAME="subj" ID="subj" /><div id='Contact_subj_errorloc'></div>
                <DIV ID="headers">Message</DIV><TEXTAREA ROW=50 COLS=50 NAME="msg" ID="msg"></TEXTAREA><div id='Contact_msg_errorloc' ></div>
                <INPUT TYPE="Submit" NAME="submit" VALUE="Email me" />
            </FORM><br /><br />
        </DIV>
        
        <script  type="text/javascript">
			 var frmvalidator = new Validator("Contact");
			 frmvalidator.EnableOnPageErrorDisplay();
			 frmvalidator.EnableMsgsTogether();
			 
			 frmvalidator.addValidation("name","req","Please enter your name");
			 
			 frmvalidator.addValidation("email","req", "Please enter your email address");
			 frmvalidator.addValidation("email","email", "Please enter a valid email address");
			 
			 frmvalidator.addValidation("subj","req", "Please enter a subject");
			 
			 frmvalidator.addValidation("msg","Body is empty. What do you want to say?");
		</script>
        
    </DIV>
    </CENTER>
</body>
</html>