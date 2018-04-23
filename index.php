<!-- IFW Email Signature Generator | Version 2.0-->

<?php

if (!empty($_REQUEST['Sender'])):
    $sender = $_REQUEST['Sender'];
    $layout = file_get_contents('./layout_v2.html', FILE_USE_INCLUDE_PATH);

    foreach ($sender as $key => $value) {
        $key         = strtoupper($key);
        $start_if    = strpos($layout, '[[IF-' . $key . ']]');
        $end_if      = strpos($layout, '[[ENDIF-' . $key . ']]');
        $length      = strlen('[[ENDIF-' . $key . ']]');

    # if (!empty($value))
	#{
			// Check if fields are empty ?
	#		die(msg(0,"All the fields are required"));
	#	}
	#	elseif
	#		(!(preg_match("/^[\.A-z0-9_\-\+]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/", ['email'])))
	#		die(msg(0,"You haven't provided a valid email"));
		
		if (!empty($value)) 
		{
            // Add the value at its proper location.
            $layout = str_replace('[[IF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[ENDIF-' . $key . ']]', '', $layout);
            $layout = str_replace('[[' . $key . ']]', $value, $layout);
   	 	}
			
		elseif (is_numeric($start_if)) 
		{
            // Remove the placeholder and brackets if there is an if-statement but no value.
            $layout = str_replace(substr($layout, $start_if, $end_if - $start_if + $length), '', $layout);
        } 
		else 
		{
            // Remove the placeholder if there is no value.
            $layout = str_replace('[[' . $key . ']]', '', $layout);
        }
    }

    // Clean up any leftover placeholders. This is useful for booleans,
    // which are not submitted if left unchecked.
    $layout = preg_replace("/\[\[IF-(.*?)\]\]([\s\S]*?)\[\[ENDIF-(.*?)\]\]/u", "", $layout);

    if (!empty($_REQUEST['download'])) 
	{
        header('Content-Description: File Transfer');
        header('Content-Type: text/html');
        header('Content-Disposition: attachment; filename=ifw_mail_signature.html');
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
    }

    echo $layout;
else: ?><!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Email Signature Generator">
        <meta name="author" content="Anggarda Tiratana">

        <title>Email Signature Generator</title>

        <!-- Bootstrap core CSS -->
        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <style type="text/css">
            /* Sticky footer styles
            -------------------------------------------------- */

            html,
            body {
                height: 100%;
                /* The html and body elements cannot have any padding or margin. */
            }

            /* Wrapper for page content to push down footer */
            #wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                /* Negative indent footer by its height */
                margin: 0 auto -60px;
                /* Pad bottom by footer height */
                padding: 0 0 60px;
            }

            /* Set the fixed height of the footer here */
            #footer {
                height: 60px;
                background-color: #f5f5f5;
            }


            /* Custom page CSS
            -------------------------------------------------- */
            /* Not required for template or sticky footer method. */

            #wrap > .container {
                padding: 60px 15px 0;
            }
            .container .credit {
                margin: 20px 0;
            }

            #footer > .container {
                padding-left: 15px;
                padding-right: 15px;
            }

            code {
                font-size: 80%;
            }
        </style>

    </head>

    <body>

        <!-- Wrap all page content here -->
        <div id="wrap">

            <!-- Fixed navbar -->
            <div class="navbar navbar-default navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#">Email Signature Generator</a>
                    </div>
                </div>
            </div>

            <!-- Begin page content -->
            <div class="container">
                <div class="page-header">
                    <h4>Please input your detail below :</h4>
                </div>
                <form role="form" method="post" target="preview" id="form">
                    <div class="form-group">
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" id="Name" name="Sender[name]" placeholder="Enter your name">
                    </div>
                    <div class="form-group">
                        <label for="Email">Email</label>
                        <input type="email" class="form-control" id="Email" name="Sender[email]" placeholder="firstname.lastname@frameworks-studios.com">
                    </div>
                    <div class="form-group">
                        <label for="Job">Job Title</label>
                        <input type="text" class="form-control" id="Job" name="Sender[job]" placeholder="Senior 3D Animator">
                    </div>
                    <div class="form-group">
                        <label for="Mobile">Mobile No.</label>
                        <input type="phone" class="form-control" id="Mobile" name="Sender[mobile]" placeholder="+62 812 0000 0000">
                    </div>
                    <!--<div class="form-group">
                        <label for="Disclaimer">Display Disclaimer</label>
                        <input type="checkbox" class="form-control" id="Disclaimer" name="Sender[disclaimer]">
                    </div>-->

                    <button id="preview" type="submit" class="btn btn-default">Preview</button>
                    <button id="download" class="btn btn-default">Download</button>
                    <input type="hidden" name="download" id="will-download" value="">
                </form>
            </div>

            <div class="container">
                <iframe src="about:blank" name="preview" width="100%" height="250"></iframe>
            </div>

        </div>

        <div id="footer">
            <div class="container">
		<p class="text-muted credit">Developed by <a href="https://github.com/anggarda">Frameworks Lab Tech (c) 2018</a>.</p>	   
            </div>
        </div>


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
        <script type="text/javascript">
        $( document ).ready(function() {
            $("#download").bind( "click", function() {
                $('#will-download').val('true');
                $('#form').removeAttr('target').submit();
            });

            $("#preview").bind( "click", function() {
                $('#will-download').val('');
                $('#form').attr('target','preview');
            });

        });
        </script>
    </body>
</html>

<?php endif;
