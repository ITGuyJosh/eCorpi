<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META INFORMATION -->
    <title>Visualisation Tool</title>
    <meta name="Description" content="A tag based Data Visualisation Tool for the Digital Humanities that incorcoporates Text Analysis to discover insight surrounding entities within historical documents. Designed for the University of Chester in 2016-17 by Joshua Evans."
    />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <!-- STYLING -->
    <link href="Libs/bootstrap/css/bootstrap.css" rel="stylesheet" />
    <link href="Libs/jquery-ui-1.12.1/jquery-ui.min.css" rel="stylesheet"/>
    <link href="Libs/jquery-ui-1.12.1/jquery-ui.structure.min.css" rel="stylesheet"/>
    <link href="Libs/jquery-ui-1.12.1/jquery-ui.theme.min.css" rel="stylesheet"/>
    <link href="Libs/jquery-contextMenu/dist/jquery.contextMenu.min.css" rel="stylesheet"/>
    <!-- <link href="Libs/mark.js/jquery.highlight-within-textarea.css" rel="stylesheet"/> -->
    <link href="CSS/custom.css" rel="stylesheet" title="custom" />

    <!-- SCRIPTS -->
    <script src="Libs/jquery-3.1.1.js"></script>
    <script src="Libs/bootstrap/js/bootstrap.js"></script>
    <script src="Libs/jquery-ui-1.12.1/jquery-ui.min.js"></script>
    <script src="Libs/jquery-contextMenu/dist/jquery.contextMenu.min.js"></script>
    <script src="Libs/jquery-contextMenu/dist/jquery.ui.position.min.js"></script>
    <script src="Libs/wordfreq/src/wordfreq.js"></script>
    <script src="Libs/wordcloud2/src/wordcloud2.js"></script>
    <script src="Libs/mark.js/dist/jquery.mark.min.js"></script>
    <script src="Libs/jquery.selection/src/jquery.selection.js"></script>
    <script src="Libs/jquery.form/src/jquery.form.js"></script>
    <script src="JS/custom.js"></script>
</head>

<body>

    <!-- HEADER -->
    <header>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container-fluid">

                <!-- Brand and toggle get grouped for better mobile display -->
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#my-navbar">
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <div class="navbar-header">
                    <a class="navbar-brand" href="#">University of Chester</a>
                </div>
                <div class="collapse navbar-collapse" id="my-navbar" />
                <ul class="nav navbar-nav navbar-right">
                    <li id="load-modal-button" data-toggle="modal" data-target="#load-modal"><a href="#">Load</a></li>
                    <li data-toggle="modal" data-target="#upload-modal"><a href="#">Upload</a></li>
                    <li data-toggle="modal" data-target="#tag-modal"><a href="#">Tags</a></li>
                    <li data-toggle="modal" data-target="#export-modal"><a href="#">Export</a></li>
                </ul>
            </div>
            </div>
            </div>
        </nav>
    </header>


    <!-- MODALS -->
    <!-- LOAD MODAL -->
    <div class="modal fade" id="load-modal" tabindex="-1" role="dialog" aria-labelledby="load-modal-label">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="load-modal-label">Load Document</h4>
                </div>
              <!-- <form method="post" enctype="multipart/form-data" id="load-form" action="ServerFiles/load.php"> -->
                <div class="modal-body">

                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="load-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
              Select document...
              <span class="caret"></span>
            </button>
                        <ul class="dropdown-menu" aria-labelledby="load-dropdown" id="available-files-list">
                        </ul>
                    </div>
                    <!-- <div class="input-group selected-file-style">
                      <input type="text" class="form-control" id="selected-file" readonly name="selected-file" placeholder="Document...">
                    </div> -->

                </div>
                <div class="modal-footer">
                  <span class="selected-file-style" id="selected-file"></span>
                  <!-- <input type="submit" class="btn btn-default" id="load-file" name="submit" value="Load" /> -->
                  <button type="button" class="btn btn-default" id="file-load">Load</button>
                </div>

              <!-- </form> -->
            </div>
        </div>
    </div>

    <!-- UPLOAD MODAL -->

    <div class="modal fade" id="upload-modal" tabindex="-1" role="dialog" aria-labelledby="upload-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="upload-modal-label">Upload Document</h4>
                </div>

                <!-- <form method="post" enctype="multipart/form-data" id="upload-form"> -->
                <form method="post" enctype="multipart/form-data" id="upload-form" action="ServerFiles/upload.php">

                <div class="modal-body">

                        <div class="form-group upload-form">
                            <label class="btn btn-primary" for="file-selector">
              <input name="file-selector" id="file-selector" type="file" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">
              Select file...
          </label>
                            <span class='label label-info' id="upload-file-info"></span>
                            <div class="upload-form-meta">
                                <h5>Optional Meta Data</h5>
                                <input type="text" class="form-control" placeholder="Author..." aria-describedby="author-text" name="file-meta-author">
                                <input type="text" class="form-control" placeholder="Title..." aria-describedby="title-text" name="file-meta-title">
                                <input type="text" class="form-control" placeholder="Genre..." aria-describedby="genre-text" name="file-meta-genre">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-default" id="upload-file" name="submit" value="Upload" />
                </div>

                </form>
            </div>
        </div>
    </div>

    <!-- TAGS MODAL -->

    <div class="modal fade" id="tag-modal" tabindex="-1" role="dialog" aria-labelledby="tags-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="upload-modal-label">Tag Management</h4>
                </div>
                <div class="modal-body">

                    <div class="row schema-tags">
                        <div class="col-md-4 available-tags">
                            <h5>Available Tags</h5>
                            <div class="list-group">
                                <button type="button" class="list-group-item">Tag 1</button>
                                <button type="button" class="list-group-item">Tag 2</button>
                                <button type="button" class="list-group-item">Tag 3</button>
                                <button type="button" class="list-group-item">Tag 4</button>
                                <button type="button" class="list-group-item">Tag 5</button>
                            </div>

                        </div>

                        <div class="col-md-8">

                            <form>
                                <div class="form-group">
                                    <div class="tags-form">
                                        <h5>Modify</h5>
                                        <input type="text" class="form-control" placeholder="Element..." id="tag-element">

                                        <div class="input-group tag-input-groups">
                                            <input type="text" class="form-control" placeholder="Attribute..." id="tag-attribute">
                                            <span class="input-group-btn">
                                        <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-remove" id="remove-attribute"></span></button>
                                            </span>
                                        </div>
                                        <div class="container-fluid tag-values">
                                            <div class="row-fluid">
                                                <div class="col-md-2">
                                                    <div class="add-field">
                                                        <span class="glyphicon glyphicon-plus" id="add-value"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="input-group tag-input-groups">
                                                        <input type="text" class="form-control" placeholder="Value..." id="tag-value">
                                                        <span class="input-group-btn">
                                                      <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-remove" id="remove-value"></span></button>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="add-field">
                                            <span class="glyphicon glyphicon-plus" id="add-value"></span>
                                        </div>
                                    </div>

                                </div>
                            </form>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left">New</button>
                        <button type="button" class="btn btn-danger outline">Delete</button>
                        <button type="button" class="btn btn-default">Cancel</button>
                        <button type="button" class="btn btn-default">Save</button>
                    </div>


                </div>

            </div>
        </div>
    </div>

    <!-- EXPORT MODAL -->

    <div class="modal fade" id="export-modal" tabindex="-1" role="dialog" aria-labelledby="export-modal-label">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="export-modal-label">Export File</h4>
                </div>
                <div class="modal-body">

                    <h5>Select a file to download.</h5>
                    <div class="list-group export-links">
                        <a href="#" class="list-group-item">Document metadata<span class="glyphicon glyphicon-circle-arrow-down"></span></a>
                        <a href="#" class="list-group-item">Visualisation extract<span class="glyphicon glyphicon-circle-arrow-down"></span></a>
                        <a href="#" class="list-group-item">System schema<span class="glyphicon glyphicon-circle-arrow-down"></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ASSIGN MODAL -->

    <div class="modal fade" id="assign-tag-modal" tabindex="-1" role="dialog" aria-labelledby="assign-tag-modal-label">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="upload-modal-label">Tag Assignment</h4>
                </div>
                <!-- <form method="post" enctype="multipart/form-data" id="assign-tags-form" action="ServerFiles/assign.php"> -->
                <div class="modal-body">

                  <div class="input-group">
                    <span class="input-group-addon">Selection</span>
                    <input type="text" class="form-control" id="selected-word" readonly name="selection">
                  </div>
                    <div class="row schema-tags">
                        <div class="col-md-4 available-tags">
                            <h5>Available Tags</h5>
                            <div class="list-group" id="tag-elements">

                            </div>

                        </div>

                        <div class="col-md-8">

                            <form>
                                <div class="form-group">
                                    <div class="tags-form">
                                        <h5>Assign Tag</h5>
                                        <div class="input-group available-tags-input-groups">
                                            <div class="dropdown assign-tag-dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="attribute-selection-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" disabled>
                                  Select attribute...
                                  <span class="caret"></span>
                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="attribute-selection-dropdown" id="tag-attributes">
                                                </ul>
                                            </div>

                                            <div class="input-group selected-attr">
                                              <span class="input-group-addon">Attribute</span>
                                              <input type="text" class="form-control" id="selected-attr" readonly name="attribute">
                                            </div>

                                        </div>
                                        <!-- <div class="input-group available-tags-input-groups"> -->
                                            <!-- <div class="dropdown assign-tag-dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" id="value-selection-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                  Value...
                                  <span class="caret"></span>
                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="value-selection-dropdown">
                                                    <li><a href="#">Value 1</a></li>
                                                    <li><a href="#">Value 2</a></li>
                                                    <li><a href="#">Value 3</a></li>
                                                </ul>
                                            </div> -->
                                        <!-- </div> -->

                                        <div class="input-group selected-attr">
                                          <span class="input-group-addon selected-val-addon">Value</span>
                                          <input type="text" class="form-control" id="new-value" placeholder="Enter value..." name="value">
                                        </div>

                                        <!-- <input type="text" class="form-control" placeholder="Enter value..." id="new-value"> -->
                                    </div>

                                </div>


                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default">Assign</button>
                        <!-- <input type="submit" class="btn btn-default" id="assign-tags" name="submit" value="Assign" /> -->
                        <!-- <button type="button" class="btn btn-default">Assign All</button> -->
                    </div>

                    <!-- </form> -->

                </div>

            </div>
        </div>
    </div>

    <!-- MAIN INTERFACE -->
    <section>
        <div class="container-fluid fill custom-main-interface">



            <div class="row fill">

                <!-- OVERVIEW -->

                <div class="col-md-5 fill custom-overview-pane">
                    <div class="overview-pane">

                        <div class="input-group search-bar">
                            <input type="text" class="form-control" placeholder="Search..." id="search-bar">
                            <span class="input-group-btn">
                          <button class="btn btn-default" type="button" id="search-bar-button">
                            <span class="glyphicon glyphicon-search"></span>
                            </button>
                            </span>
                        </div>

                        <!-- <div class="overview-content" oncontextmenu="return false;"> -->
                        <div class="overview-content" oncontextmenu="return false;">
                        <!-- <textarea class="textarea-content right-click-menu" placeholder="Please load in a document for analysis..." readonly id="document-textarea"></textarea> -->
                        <div class="textarea-content right-click-menu" placeholder="Please load in a document for analysis..." readonly id="document-textarea"></div>
                        <!-- <textarea class="textarea-content right-click-menu" placeholder="Please load in a document for analysis..." readonly id="document-textarea2">This is the test textarea.</textarea> -->
                        <?php  //$xmlDoc = new DOMDocument();$xmlDoc->load('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.xml');?>
                        <?PHP //  echo '<textarea class="textarea-content right-click-menu" placeholder="Please load in a document for analysis..." readonly>', strip_tags(file_get_contents('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.xml')), '</textarea>'; ?>
                        <?PHP //echo '<pre>', strip_tags(file_get_contents('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.xml')), '</pre>'; ?>
                        <?php // echo nl2br( htmlspecialchars( file_get_contents('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.xml'))); ?>
                        <?php //include('/Applications/XAMPP/xamppfiles/htdocs/eCorpi/UserFiles/Files/Chretien 1 Erec.txt'); ?>

                        </div>

                    </div>
                </div>



                <!-- VISUALISATION -->

                <div class="col-md-7 fill custom-visualisation-pane">
                    <div class="visualisation-pane">

                        <div class="dropdown">
                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              Select visualisation...
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                <li><a href="#">Word Cloud</a></li>
                                <li><a href="#">Word Tree</a></li>
                            </ul>
                        </div>

                        <div class="visualisation-content">


                        </div>

                    </div>
                </div>
                <div id="positive-alert" class="alert alert-success" role="alert"></div>
                <div id="negative-alert" class="alert alert-danger" role="alert"></div>
            </div>
            <div class="row">
              <!-- notifications -->

            </div>
        </div>
    </section>

</body>

</html>
